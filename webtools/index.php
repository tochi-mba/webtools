<?php
 // It sets the variable 'logs' to an empty string
 $logs = "";
// This code checks if the parameters 'p', 'lang', and 'u' are set in the URL
if(isset($_GET['p'], $_GET['lang'], $_GET['u'])) {
    // If they are set, it requires the file 'connect.php'
    require "../connect.php";
    // It sets the variable 'query' to a SQL query that selects the 'authorized_websites' from the 'scripts' table where the 'uid' and 'script_id' match the values in the URL
    $query = "SELECT `authorized_websites`, `status` FROM `scripts` WHERE uid = '".$_GET['u']."' AND script_id = '".$_GET['p']."'";
    // It runs the query and stores the result in the variable 'result'
    $result = mysqli_query($conn, $query);
    // If the query returns more than 0 rows
    if(mysqli_num_rows($result) > 0) {
        // It stores the row in the variable 'row'
        $row = mysqli_fetch_assoc($result);
        // It sets the variable 'authorized_websites' to an array of the websites stored in the 'authorized_websites' column
        $authorized_websites = explode(",", $row['authorized_websites']);
        // It defines a function 'url' that returns the URL of the page
        function url(){
            return sprintf(
              "%s://%s",
              isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
              $_SERVER['SERVER_NAME']
            );
          }
        // Trims the whitespace from the beginning and end of each element in the 'authorized_websites' array
        foreach($authorized_websites as $key => $value) {
            $authorized_websites[$key] = trim($value);
        }
        // If the URL of the page is in the 'authorized_websites' array
        // Unless project is unlisted or public
        if(in_array(url(), $authorized_websites) || in_array(url()."/", $authorized_websites) || $row['status'] == "1" || $row['status'] == "3") {
            // If the parameter 'v' is set in the URL
            if(isset($_GET['v'])) {
                // It sets the variable 'project_folder' to the folder of the script version
                $project_folder = "../scripts/".$_GET['u']."/".$_GET['p']."/v".$_GET['v'];
                // If the folder exists
                if(is_dir($project_folder)) {
                    // If the language is 'js'
                    if($_GET['lang'] == "js") {
                        // It redirects the page to the script file
                        $code = file_get_contents($project_folder."/".$_GET['p'].".js");
                        require "../jsServe.php";
                        echo $code;
                        // It adds a log to the 'logs' variable
                        $logs=$logs."console.log('CodeConnect: Script loaded successfully');";
                    // If the language is 'css'
                    } else if($_GET['lang'] == "css") {
                        // It redirects the page to the style file
                        $css=$project_folder."/".$_GET['p'].".css";
                        if (!file_exists($css)) {
                            echo "console.log('CodeConnectError: Style file not found');";
                            exit();
                        }
                        // It adds a log to the 'logs' variable
                        $css_content = file_get_contents($css);
                        $css_content = str_replace(array("\r\n", "\r", "\n"), " ", $css_content);
                        echo "let cssContent = '$css_content';";
                        ?>
                        let styleTag = document.createElement("style");
                        styleTag.innerHTML = cssContent;
                        document.head.appendChild(styleTag);
                        <?php
                        // It adds a log to the 'logs' variable
                        $logs=$logs."console.log('CodeConnect: Style loaded successfully');";
                    // If the language is neither 'js' nor 'css'
                    } else {
                        // It adds an error log to the 'logs' variable
                        $logs=$logs."console.log('CodeConnectError: Invalid language');";
                    }
                // If the folder doesn't exist
                } else {
                    // It adds an error log to the 'logs' variable
                    $logs=$logs."console.log('CodeConnectError: Error: Invalid version');";
                }
            // If the parameter 'v' is not set in the URL
            } else {
                // It sets the variable 'project_folder' to the folder of the script
                $project_folder = "../scripts/".$_GET['u']."/".$_GET['p'];
                // It sets the variable 'versions' to an empty array
                $versions = array();
                // It loops through all the folders in the script folder
                foreach(glob($project_folder."/v*") as $version) {
                    // It sets the variable 'version_number' to the version number of the folder
                    $version_number = substr($version, strlen($project_folder)+2);
                    // It adds the version number to the 'versions' array
                    $versions[] = $version_number;
                }
                // If the 'versions' array is not empty
                if(count($versions) > 0) {
                    // It sorts the 'versions' array in reverse order
                    rsort($versions);
                    // It sets the variable 'project_folder' to the folder of the latest version
                    $project_folder = $project_folder."/v".$versions[0];
                    // If the language is 'js'
                    if($_GET['lang'] == "js") {
                        // It redirects the page to the script file
                        $code = file_get_contents($project_folder."/".$_GET['p'].".js");
                        require "../jsServe.php";
                        echo $code;
                        // It adds a log to the 'logs' variable
                        $logs=$logs."console.log('CodeConnect: Script loaded successfully');";
                    // If the language is 'css'
                    } else if($_GET['lang'] == "css") {
                        // It redirects the page to the style file
                        $css=$project_folder."/".$_GET['p'].".css";
                        // It adds a log to the 'logs' variable
                        if (!file_exists($css)) {
                            echo "console.log('CodeConnectError: Style file not found');";
                            exit();
                        }
                        $css_content = file_get_contents($css);
                        $css_content = str_replace(array("\r\n", "\r", "\n"), " ", $css_content);
                        echo "let cssContent = '$css_content';";
                        ?>
                        let styleTag = document.createElement("style");
                        styleTag.innerHTML = cssContent;
                        document.head.appendChild(styleTag);
                        <?php
                        // It adds a log to the 'logs' variable
                        $logs=$logs."console.log('CodeConnect: Style loaded successfully');";
                    // If the language is neither 'js' nor 'css'
                    } else {
                        // It adds an error log to the 'logs' variable
                        $logs=$logs."console.log('CodeConnectError: Invalid Language);";
                    }
                // If the 'versions' array is empty
                } else {
                    // It adds an error log to the 'logs' variable
                    $logs=$logs."console.log('CodeConnectError: No versions found);";
                }
            }
        // If the URL of the page is not in the 'authorized_websites' array
        } else {
            // It adds an error log to the 'logs' variable
            $logs=$logs."console.log('CodeConnectError: Unauthorized website');";
        }
    // If the query returns 0 rows
    } else {
        // It adds an error log to the 'logs' variable
        $logs=$logs."console.log('CodeConnectError: Script not found');";
    }
// If the parameters 'p', 'lang', and 'u' are not set in the URL
} else{
    // It adds an error log to the 'logs' variable
    $logs=$logs."console.log('CodeConnectError: Missing parameters');";
    
}
if($logs != "") {
    // It prints the logs
    echo ";".$logs."";
}

// If the 'logs' variable is not empty

?>