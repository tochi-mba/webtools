<?php
require_once "../head.php";
require_once "../connect.php";

if (isset($_GET['cid'])) {
    $clusterId = $_GET['cid'];
    $clusterId = mysqli_real_escape_string($conn, $clusterId);
    $clusterQuery = "SELECT * FROM clusters WHERE cluster_id = '$clusterId'";
    $clusterResult = mysqli_query($conn, $clusterQuery);
    $log = array(
        "ip_address" => $_SERVER['REMOTE_ADDR'],
        "logs" => array(),
        "timestamp" => time(),
    );
    
    function saveLogs($newLogs) {
        global $clusterId;
        global $conn;
    
        $cluster_id = $clusterId;
        $clusterQuery = "SELECT logs FROM clusters WHERE cluster_id = '$cluster_id'";
        $clusterResult = mysqli_query($conn, $clusterQuery);
    
        while ($clusterRow = mysqli_fetch_assoc($clusterResult)) {
            $legacyLog = json_decode($clusterRow['logs'], true);
        }
    
        $currentProtocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
        $currentWebsite = $currentProtocol . $_SERVER['HTTP_HOST'];
    
        // Check if legacyLog is empty or null
        if (empty($legacyLog) || is_null($legacyLog)) {
            $legacyLog = array(); // Convert it to an array
        }
    
        // Check if the current website key already exists in the legacyLog array
        if (isset($legacyLog[$currentWebsite])) {
            // Add new logs to the existing logs array
            $legacyLog[$currentWebsite][] = $newLogs;
        } else {
            // Create a new logs array for the current website key
            $legacyLog[$currentWebsite] = [$newLogs];
        }
    
        // Remove logs from the biggest website array if log size exceeds 3 GB
        $logSizeLimit = 2 * 1024 * 1024 * 1024; // 3 GB in bytes
        $totalLogSize = strlen(json_encode($legacyLog));
    
        while ($totalLogSize > $logSizeLimit) {
            $biggestWebsite = null;
            $biggestWebsiteSize = 0;
    
            // Find the website with the largest log array
            foreach ($legacyLog as $website => $logs) {
                $websiteSize = count($logs);
                if ($websiteSize > $biggestWebsiteSize) {
                    $biggestWebsite = $website;
                    $biggestWebsiteSize = $websiteSize;
                }
            }
    
            // Remove the last log from the biggest website array
            array_pop($legacyLog[$biggestWebsite]);
    
            // Recalculate the total log size
            $totalLogSize = strlen(json_encode($legacyLog));
        }
    
        $legacyLog = json_encode($legacyLog);
        $sql = "UPDATE clusters SET logs = '" . $legacyLog . "' WHERE cluster_id = '" . $cluster_id . "';";
        $result = mysqli_query($conn, $sql);
    }
    
    
    
    if (mysqli_num_rows($clusterResult) > 0) {
        while ($clusterRow = mysqli_fetch_assoc($clusterResult)) {
            if ($clusterRow['status'] == "private") {
                $authorizedWebsites = json_decode($clusterRow['authorized_websites'], true);
                
                // Check if current website is authorized
                $currentProtocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
                $currentWebsite = $currentProtocol . $_SERVER['HTTP_HOST'];
                $isAuthorized = false;

                foreach ($authorizedWebsites as $website) {
                    if (strpos($website, $currentWebsite) === 0) {
                        $isAuthorized = true;
                        echo 'console.log("CodeConnect Authentication: Authorized website for cluster `' . $clusterRow['name'] . '`");';
                        $log['logs'][] = array(
                            "message" => 'Authorized website for cluster `' . $clusterRow['name'] . '`',
                            "level" => "green",
                        );
                        break;
                    }
                }

                if (!$isAuthorized) {
                    echo 'console.log("CodeConnect Error: Unauthorized Website");';
                    $log['logs'][] = array(
                        "message" => 'Unauthorized Website',
                        "level" => "red",
                    );
                    saveLogs($log);
                    exit;
                }
            }

            $contentArray = json_decode($clusterRow['content'], true);

            foreach ($contentArray as $contentItem) {
                $projectId = $contentItem['project_id'];
                $authorId = $contentItem['author_id'];
                $version = $contentItem['version'];

                $scriptQuery = "SELECT manifest, type, title, active_files FROM scripts WHERE script_id = '$projectId' AND uid = '$authorId';";
                $scriptResult = mysqli_query($conn, $scriptQuery);

                if (mysqli_num_rows($scriptResult) > 0) {
                    while ($scriptRow = mysqli_fetch_assoc($scriptResult)) {
                        $manifest = $scriptRow['manifest'];
                        $manifest = json_decode($manifest, true);
                        $title = $scriptRow['title'];
                        $active_files = $scriptRow['active_files'];
                        $active_files = json_decode($active_files, true);
                        $hasJS = ($active_files['code'] === "active");
                        $hasCss = ($active_files['codeCss'] === "active");
                        $authorQuery = "SELECT username, scripts_id FROM users WHERE uid = '$authorId';";
                        $authorResult = mysqli_query($conn, $authorQuery);

                        while ($authorRow = mysqli_fetch_assoc($authorResult)) {
                            $username = $authorRow['username'];
                            $security_code = $authorRow['scripts_id'];
                        }

                        $isModule = ($scriptRow['type'] == "module");
                        $isAuthorized = false;
                        $status = false;

                        foreach ($manifest as $versionKey => $versionDetails) {
                            foreach ($versionDetails as $detail) {
                                if ($versionKey == $version && $detail['status'] == 'private') {
                                    $projectAuthorizedWebsites = $detail['authorized_websites'];
                                    
                                    foreach ($projectAuthorizedWebsites as $website) {
                                        if (strpos($website, $currentWebsite) === 0) {
                                            $isAuthorized = true;
                                            $status =  $detail['status'];
                                            break;
                                        }
                                    }
                                } elseif ($versionKey == $version) {
                                    $isAuthorized = true;
                                    $status =  $detail['status'];
                                    break;
                                }
                            }
                        }
                        

                        if ($isAuthorized && $isModule) {
                            if ($hasCss){
                                if ($status == "monetized"){
                                    echo "console.log('CodeConnect Error: Monetized projects not yet supported')";
                                    $log['logs'][] = array(
                                        "message" => 'Monetized projects not yet supported',
                                        "level" => "amber",
                                    );
                                    break;
                                }elseif ($status == "private"){
                                    $css = "/scripts/".$authorId."_private/".$version."/".$projectId.".css";
                                }elseif ($status == "public"){
                                    $css = "/scripts/".$authorId."_public/".$version."/".$projectId.".css";

                                }elseif ($status == "unlisted"){
                                    $css = "/scripts/".$authorId."_unlisted_".$security_code."/".$version."/".$projectId.".css";
                                }
                                if (file_exists("..".$css)) {
                                ?>
css = document.createElement('link');
css.href = `<?php echo $website1.$css?>`;
css.rel = 'stylesheet';
document.head.appendChild(css);
<?php
                                echo "console.log('CodeConnect: CSS Loaded for `".$title." - ".$version."` by `@".$username."`');";
                                $log['logs'][] = array(
                                    "message" => "CSS Loaded for `".$title." - ".$version."` by `@".$username."`'",
                                    "level" => "green",
                                );
                                }else{
                                    $css = '';
                                }                                    
                             
                            }
                            if ($hasJS) {
                                if ($status == "monetized"){
                                    echo "console.log('CodeConnect Error: Monetized projects not yet supported');";
                                    $log['logs'][] = array(
                                        "message" => 'Monetized projects not yet supported',
                                        "level" => "amber",
                                    );
                                    break;
                                }elseif ($status == "private"){
                                    ?>
var moduleUrl =
"<?php echo $website?>/scripts/<?php echo $authorId?>_private/<?php echo $projectId?>/<?php echo $version?>/<?php echo $projectId?>.js";

<?php
    
                                }elseif ($status == "public"){
                                    ?>
var moduleUrl =
"<?php echo $website?>/scripts/<?php echo $authorId?>_public/<?php echo $projectId?>/<?php echo $version?>/<?php echo $projectId?>.js";

<?php
    
                                }elseif ($status == "unlisted"){
                                    ?>
var moduleUrl =
"<?php echo $website?>/scripts/<?php echo $authorId?>_unlisted_<?php echo $security_code?>/<?php echo $projectId?>/<?php echo $version?>/<?php echo $projectId?>.js";

<?php
    
                                }
                                echo "console.log('CodeConnect Error: Modules not yet supported. `".$title." - ".$version."` by `".$username."`');";
                                $log['logs'][] = array(
                                    "message" => "Modules not yet supported. `".$title." - ".$version."` by `".$username."`",
                                    "level" => "amber",
                                );
                                break;
                                ?>


var scriptTags = document.querySelectorAll("script[type='module']");
scriptTags.forEach(function(script) {
var newScript = document.createElement('script');
newScript.type = 'module';
var importFunc = script.getAttribute("cid-data") || "*";
newScript.setAttribute("cid-data", importFunc);
importFunc = importFunc.split(",");
var moduleCode = "";

var moduleUrl = ""; // Provide the URL of the module here

for (var i = 0; i < importFunc.length; i++) { var importStatement=importFunc[i].trim();
    checkExportExists(importStatement, moduleUrl) // Call the function and log the result .then(result=> {
    if (result) {
    moduleCode += "import " + importStatement + " from '" + moduleUrl + "';\n";
    }
    })
    .catch(error => console.error(error));
    }

    newScript.innerHTML = moduleCode + script.innerHTML;
    script.parentNode.insertBefore(newScript, script);
    script.parentNode.removeChild(script);
    });

    function checkExportExists(exportName, url) {
    return fetch(url)
    .then(response => response.text())
    .then(text => {
    const regex = new RegExp(`\\bexport\\s+(?:default\\s+)?{[^}]*\\b${exportName}\\b[^}]*}`);
    return regex.test(text);
    })
    .catch(error => console.error(error));
    }





    <?php
    echo "console.log('CodeConnect: JS Loaded in all script[type=\'module\'] for `".$title."` by `".$username."`');";
                            }

                           
                      
                        } elseif ($isAuthorized) {
                            if ($hasJS){
                                if ($status == "monetized"){
                                    echo "console.log('CodeConnect Error: Monetized projects not yet supported');";
                                    $log['logs'][] = array(
                                        "message" => 'Monetized projects not yet supported',
                                        "level" => "amber",
                                    );
                                    break;
                                }elseif ($status == "private"){
                                    $js = "../scripts/".$authorId."_private/".$projectId."/".$version."/".$projectId.".js";
                                }elseif ($status == "public"){
                                    $js = "../scripts/".$authorId."_public/".$projectId."/".$version."/".$projectId.".js";

                                }elseif ($status == "unlisted"){
                                    $js = "../scripts/".$authorId."_unlisted_".$security_code."/".$projectId."/".$version."/".$projectId.".js";
                                }
                                if (file_exists($js)) {
                                    $js = file_get_contents($js);
                                    $js = str_replace('`', '\`', $js);
                                    $js = str_replace('const', 'var', $js);
                                    ?>
    var jsCode = `<?php echo $js?>`;
    eval(jsCode);

    <?php
                                       echo "console.log('CodeConnect: JS Loaded for `".$title." - ".$version."` by `@".$username."`');";
                                       $log['logs'][] = array(
                                            "message" => "JS Loaded for `".$title." - ".$version."` by `@".$username."`",
                                            "level" => "green",
                                        );
                                } else {
                                    $js = "";
                                }                            
                           
                            }      

                            if ($hasCss){
                                if ($status == "monetized"){
                                    echo "console.log('CodeConnect Error: Monetized projects not yet supported');";
                                    $log['logs'][] = array(
                                        "message" => 'Monetized projects not yet supported',
                                        "level" => "amber",
                                    );
                                    break;
                                }elseif ($status == "private"){
                                    $css = "/scripts/".$authorId."_private/".$projectId."/".$version."/".$projectId.".css";
                                }elseif ($status == "public"){
                                    $css = "/scripts/".$authorId."_public/".$projectId."/".$version."/".$projectId.".css";

                                }elseif ($status == "unlisted"){
                                    $css = "/scripts/".$authorId."_unlisted_".$security_code."/".$projectId."/".$version."/".$projectId.".css";
                                }
                                if (file_exists("..".$css)) {
                                ?>
    css = document.createElement('link');
    css.href = `<?php echo $website1.$css?>`;
    css.rel = 'stylesheet';
    document.head.appendChild(css);
    <?php
                                echo "console.log('CodeConnect: CSS Loaded for `".$title." - ".$version."` by `@".$username."`');";
                                $log['logs'][] = array(
                                    "message" => "CSS Loaded for `".$title." - ".$version."` by `@".$username."`",
                                    "level" => "green",
                                );
                                }else{
                                    $css = '';
                                }                                
                              
                            }
                        
                        } else {
                            echo 'console.log("CodeConnect Error: Unauthorized website for `'.$title.' - '.$version.'` by ' . $username . '");';
                            $log['logs'][] = array(
                                "message" => 'Unauthorized website for `'.$title.' - '.$version.'` by ' . $username,
                                "level" => "red",
                            );
                        }

                       
                    }
                } else {
                    echo 'console.log("CodeConnect Error: Project Not Found ' . $projectId . ' by ' . $authorId . '");';
                    $log['logs'][] = array(
                        "message" => 'Project Not Found ' . $projectId . ' by ' . $authorId,
                        "level" => "red",
                    );
                }
            }
        }
    } else {
        echo 'console.log("CodeConnect Error: Cluster not found");';
        $log['logs'][] = array(
            "message" => "Cluster not found",
            "level" => "red",
        );
    }
} else {
    echo 'console.log("CodeConnect Error: No cluster ID specified");';
}

saveLogs($log);
?>