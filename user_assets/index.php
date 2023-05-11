<?php
require "../head.php";
require "../connect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    .verticalLine {
        border-left: 2px solid white;
        height: 100%;
        position: absolute;
        left: 2px;
        z-index: 999999;
    }

    #columnItems {
        width: 100%;
        height: 100%;
        float: left;
        display: inline-block;
        overflow-y: scroll;

    }

    #columnContents {
        width: 75vw;
        height: 87.5%;
        display: inline-block;
        color: black;
        overflow-y: scroll;
        padding: 5px;
        background-color: #282A36;
    }

    .loader {}

    #columnFolder {
        width: 20%;
        height: 90.2%;
        float: left;
        display: inline-block;
        overflow-y: scroll;
        overflow-x: scroll;
        border-right: solid 1px #353535;
        background-color: #202123;
    }

    #viewingBar {
        width: 100%;
        height: 4vh;
        float: left;
        border-bottom: solid 1px #353535;
        display: flex;
    }

    #tabs {
        width: 100%;
        height: auto;
        float: left;
        border-bottom: solid 1px #353535;
        display: inline-block;
        background-color: #202123;
    }

    .tabs {
        width: 50px;
        height: 30px;
        float: left;
        display: inline-block;
        cursor: pointer;
        background: none;
        border: none;
        border: solid rgba(224, 224, 224, 0) 1px;
        transition: all 0.5s ease;
        color: white;
    }

    .tabs:hover {
        border: solid rgba(224, 224, 224, 0.5) 1px;
    }

    .active {
        background-color: #1A7ACB;
        border-radius: 0px;
        color: #fff;
    }

    #forwardBtn,
    #backBtn {
        width: 5%;
        height: 100%;
        float: left;
        display: inline-block;
        cursor: pointer;
        background: none;
        border: solid #353535 1px;
        margin: auto;
        flex-direction: column;
        justify-content: left;
    }

    #filePath {
        width: 70%;
        height: 100%;
        float: left;
        display: inline-block;
        cursor: pointer;
        background: none;
        border: solid #353535 1px;
        margin: auto;
        flex-direction: column;
        justify-content: center;
        overflow: hidden;
    }

    #sBox {
        width: 20%;
        height: 100%;
        float: left;
        display: inline-block;
        cursor: pointer;
        background: none;
        border: solid #353535 1px;
        margin: auto;
        flex-direction: column;
        justify-content: left;
    }

    #sBox input {
        width: 90% !important;
        background: none;
        border: none;
        color: white;
    }

    #sBox input:focus {
        outline: none;
    }

    .columnItem {
        width: 100%;
        min-height: 20px;
        float: left;
        cursor: pointer;
        background: none;
        border: none;
        position: relative;
        border-bottom: 1px solid #353535;
        transition: all 0.2s ease;
    }

    .columnItem:hover {
        background-color: #1A7ACB;
        border-radius: 0px;
        color: #fff;
    }

    .columnItem p {
        margin: 0px;
        top: 10%;
        font-family: sans-serif;
        font-size: 13px;
        color: white;
    }

    .activeFile {
        background-color: #3E3F4B;
        border-radius: 0px;
        color: black;
    }

    .up,
    .down {
        position: absolute;
        right: 0;
        opacity: 0.5;
    }

    #fileExplorer {
        width: 98%;
        display: inline-block;
        margin: 0 auto;
        padding: 0;
        border: solid 1px #353535;
        border-radius: 5px;
        height: 88vh;
        border-top: none;
        position: absolute;
        top: 5px;
        background-color: #282A36;
        margin-top: 60px;
        overflow: hidden;
    }

    body {
        user-select: none;
        overflow-y: hidden !important;
        background-color: #18181B;
    }

    ::-webkit-scrollbar {
        width: 5px;
        height: 5px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 5px;

    }

    * {
        scrollbar-width: thin;
        scrollbar-color: #888 #eee;
    }

    .folderContents {
        display: inline-block;
        height: 140px;
        text-align: center;
        width: 100px;
        text-overflow: ellipsis;
        overflow: hidden;
        font-size: 12px;
        padding: 5px;
        color: white;
    }

    .folderContents:hover {
        background-color: #3E3F4B;
    }

    #folderGrid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        grid-auto-rows: minmax(0, auto);
        grid-gap: 10px;
    }

    .folderIcon {
        width: 100%;
        height: auto;
        margin: 0 auto;
        padding: 0 auto;
    }

    .videoIcon {
        width: 100%;
        height: auto;
        margin: 0 auto;
        padding: 0 auto;
    }

    .imgIcon {
        max-width: 100px;
        max-height: 100px;
        margin: 0 auto;
        padding: 0 auto;
    }

    #custom-box {
        width: 350px;
        border-radius: 5px;
        border: solid 1px #353535;
    }

    #custom-box button {
        width: 100%;
    }

    .clicked {
        background-color: #3E3F4B;
        border: 1px solid #BFD8EA;
        overflow: visible;
        height: fit-content;
        word-wrap: break-word;
        min-height: 139px;
        width: 99px;

    }

    .loader img {
        height: 100px;
        width: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

    }

    .loader {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 999;
        background-color: #282A36;
    }

    #progression {
        z-index: 999;
        background-color: red;
        height: 100%;
    }

    .loading-bar {
        width: 100%;
        height: 30%;
        background-color: blue;
        border-radius: 5px;
        border: 1px solid;
    }

    .filePathShow {
        background: none;
        border: none;
        cursor: pointer;
        height: 100%;
        border-right: 1px solid #353535;
        color: white;
    }

    .filePathShow:hover {
        background-color: #3E3F4B;
    }

    #pathCopy {
        background: none;
        border: none;
        color: white;
    }

    video:focus {
        outline: none;
    }

    .imgView {
        max-width: 100% !important;
        max-height: 100% !important;
        object-fit: contain;
    }

    #miniResults {
        position: absolute;
        background-color: #282A36;
        border: 1px solid #353535;
        border-radius: 5px;
        z-index: 99999;
        overflow: scroll;
        display: none;
    }

    .miniResult:hover {
        background-color: #3E3F4B;
    }

    .miniResult {
        width: 100% !important;
        border-bottom: 1px solid #353535;
        cursor: pointer;
        color: white;
        font-size: 14px;
        text-overflow: ellipsis !important;
    }

    .miniResult img {
        width: 15% !important;
    }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/codemirror.css">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Explorer - CodeConnect</title>
</head>

<body>

    <link rel="stylesheet" href="../codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="../codemirror/addon/lint/lint.css">
    <link rel="stylesheet" href="../codemirror/addon/dialog/dialog.css">
    <link rel="stylesheet" href="../codemirror/addon/search/matchesonscrollbar.css">
    <link rel="stylesheet" href="../codemirror/theme/dracula.css">
    <script src="../codemirror/lib/codemirror.js"></script>
    <script src="../codemirror/mode/javascript/javascript.js"></script>
    <script src="../codemirror/mode/css/css.js"></script>
    <script src="https://unpkg.com/jshint@2.13.2/dist/jshint.js"></script>
    <script src="https://unpkg.com/jsonlint@1.6.3/web/jsonlint.js"></script>
    <script src="https://unpkg.com/csslint@1.0.5/dist/csslint.js"></script>
    <script src="../codemirror/addon/lint/lint.js"></script>
    <script src="../codemirror/addon/lint/javascript-lint.js"></script>
    <script src="../codemirror/addon/lint/json-lint.js"></script>
    <script src="../codemirror/addon/lint/css-lint.js"></script>
    <link rel="stylesheet" href="../codemirror/addon/scroll/simplescrollbars.css">
    <script src="../codemirror/addon/scroll/simplescrollbars.js"></script>
    <script src="../codemirror/addon/edit/closebrackets.js"></script>
    <script src="../codemirror/mode/javascript/javascript.js"></script>
    <link rel="stylesheet" href="../codemirror/addon/display/fullscreen.css">
    <script src="../codemirror/addon/display/fullscreen.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/mode/meta.js"></script>
    <div id="custom-box" style="display:none;">
        <button>ss</button>
        <br>
        <button>ss</button>
    </div>
    <?php require "../navbar.php";?>
    <div id="fileExplorer">
        <div id="tabs">
            <button class="tabs active">Home</button>
            <button class="tabs">Share</button>
            <button class="tabs">View</button>
        </div>
        <div id="viewingBar">
            <div id="backBtn">&#8592;</div>
            <div id="forwardBtn">&#8594;</div>
            <div id="filePath"></div>
            <div id="sBox"><input onkeyup="minires(this)" id="search_box" placeholder="Search Recent..." type="text">
            </div>
        </div>
        <div id="miniResults">

        </div>
        <script>
        all = [];
        </script>
        <input type="hidden" id="searchPos">
        <div id="columnFolder">
            <?php 
            $sql = "SELECT `scripts_id` FROM `users` WHERE `uid` = '".$_SESSION['uid']."' AND `api_token` = '".$_SESSION['api_token']."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $mainDir = '../scripts/'.$_SESSION['uid'].'_assets_' . $row['scripts_id'] . '/'; 
            $mainDir1 = 'scripts\/'.$_SESSION['uid'].'_assets_' . $row['scripts_id'];
            
            $length = strlen($mainDir);
            $substring = substr($mainDir, 0, $length - 1);
            $dir = $substring;

            function get_most_recent_files($dir) {
                $files = array();
                $time = time();
            
                if ($handle = opendir($dir)) {
                    while (false !== ($entry = readdir($handle))) {
                        if ($entry != "." && $entry != "..") {
                            $fullpath = $dir . "/" . $entry;
                            if (is_dir($fullpath)) {
                                $files = array_merge($files, get_most_recent_files($fullpath));
                            } else {
                                $files[$fullpath] = array(
                                    "atime" => fileatime($fullpath),
                                    "path" => $fullpath
                                );
                            }
                        }
                    }
                    closedir($handle);
                }
            
                uasort($files, function ($a, $b) use ($time) {
                    return $b["atime"] - $a["atime"];
                });
            
                return array_slice($files, 0, 32);
            }
            $most_recent_files = get_most_recent_files($dir);
            
            // Convert the array to JSON
            $files_json = json_encode(array_values($most_recent_files));
              
            ?>
            <script>
            recents = JSON.parse(`<?php echo $files_json;?>`);
            </script>
            <?php
            

            function mapDirectory($dir) {
                $files = scandir($dir);
                $filesObject = [];
                foreach($files as $file) {
                    if($file != '.' && $file != '..') {
                        if(is_dir($dir . $file)) {
                            $full_path = $dir . $file . '/';
                            $filesObject[$file] = mapDirectory($full_path);
                        } else {
                            $full_path = $dir . $file;
                            $filesObject[$file] = file_get_contents($full_path);
                        }
                    }
                }
                return $filesObject;
            }
            
            function outputDirectory($dir, $depth = 0, $root = true) {
                $files = scandir($dir);
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        $mainDirectory = $dir;

                        $mainDirectory = explode("/",$mainDirectory);
                        if (is_dir($dir . $file)) {
                            if ($root) {
                                echo '<div class="columnItem" is_folder="true" open="false" full_path="' . $dir . $file . '/" onclick="loading(this);" style="display: block;">';
                                ?>
            <script>
            all.push("<?php echo $dir . $file . '/';?>");
            </script>
            <?php
                            } else {
                                echo '<div class="columnItem" is_folder="true" status="'.$mainDirectory[3].'" open="false" full_path="' . $dir . $file . '/" onclick="loading(this);" style="display: none;">';
                                ?>
            <script>
            all.push("<?php echo $dir . $file . '/';?>");
            </script>
            <?php
                            }
                            for ($i = 0; $i < $depth; $i++) {
                                echo '<div class="verticalLine"></div>';
                            }
                            echo '<p style="padding-left: ' . ($depth * 20) . 'px">' . $file . '</p></div>';
                            outputDirectory($dir . $file . '/', $depth + 1, false);
                        } else {
                            $full_path = $dir . $file;
                            if ($root) {
                                echo '<div class="columnItem" open="false" full_path="' . $full_path . '" onclick="loading(this);" style="display: block;">';
                                ?>
            <script>
            all.push("<?php echo $full_path;?>");
            </script>
            <?php
                            } else {
                                echo '<div class="columnItem" open="false" status="'.$mainDirectory[3].'" full_path="' . $full_path . '" onclick="loading(this);" style="display: none;">';
                                ?>
            <script>
            all.push("<?php echo $full_path;?>");
            </script>
            <?php
                            }
                            
                            for ($i = 0; $i < $depth; $i++) {
                                echo '<div class="verticalLine"></div>';
                            }
                            echo '<p style="padding-left: ' . ($depth * 20) . 'px">' . $file . '</p></div>';
                        }
                    }
                }
            }
            
            
            outputDirectory($mainDir);
            ?>
        </div>
        <div id="columnContents">
        </div>
    </div>
    <script>
    function isTextBasedLanguage(url) {
        const textBasedExtensions = [
            'txt', 'md', 'doc', 'docx', 'odt', 'pdf', 'html', 'htm', 'xml', 'svg',
            'css', 'scss', 'sass', 'less', 'styl', 'js', 'jsx', 'ts', 'tsx', 'json',
            'py', 'rb', 'php', 'java', 'c', 'cpp', 'h', 'hpp', 'go', 'swift', 'sql',
            'yml', 'yaml', 'toml', 'ini', 'cfg', 'conf', 'sh', 'bash', 'zsh', 'fish',
            'ps1', 'psm1', 'bat', 'cmd', 'log', 'gitignore', 'env', 'csv', 'tsv',
            'mdx', 'adoc', 'rtf', 'tex', 'latex', 'ltx', 'bib', 'hbs', 'ejs', 'jade'
        ];

        // Get the last part of the URL
        const parts = url.split('/');
        const lastPart = parts[parts.length - 1];

        // Get the file extension
        const extension = lastPart.split('.').pop().toLowerCase();

        // Check if the file extension is for a text-based language
        return textBasedExtensions.includes(extension);
    }

    function isImage(url) {
        const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];

        // Get the last part of the URL
        const parts = url.split('/');
        const lastPart = parts[parts.length - 1];

        // Get the file extension
        const extension = lastPart.split('.').pop().toLowerCase();

        // Check if the file extension is for an image
        return imageExtensions.includes(extension);
    }

    function isVideo(url) {
        const videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi', 'flv', 'wmv', 'mkv', 'm4v'];

        // Get the last part of the URL
        const parts = url.split('/');
        const lastPart = parts[parts.length - 1];

        // Get the file extension
        const extension = lastPart.split('.').pop().toLowerCase();

        // Check if the file extension is for a video
        return videoExtensions.includes(extension);
    }

    function removeminires() {
        document.getElementById("miniResults").style.display = "none";
        document.getElementById("search_box").value = "";
    }

    function minires(search_box) {

        document.getElementById("miniResults").style.top = search_box.offsetTop + search_box.offsetHeight +
            5 + "px";
        document.getElementById("miniResults").style.left = search_box.offsetLeft + "px";
        document.getElementById("miniResults").style.width = search_box.offsetWidth + "px";
        document.getElementById("miniResults").style.height = "auto";
        document.getElementById("miniResults").style.maxHeight = "200px";

        search_term = search_box.value;
        if (search_term == "") {
            document.getElementById("miniResults").style.display = "none";
        } else {
            document.getElementById("miniResults").style.display = "block";
            amountResults = 0;
            document.getElementById("miniResults").innerHTML = "";
            searchPos = document.getElementById("searchPos").value;
            for (var i = 0; i < all.length; i++) {
                if (searchPos != "") {
                    s = searchPos.split("/");
                    s.pop();
                    s = s.join("/");
                    if (!all[i].includes(s)) {
                        continue;
                    }
                }
                fileName = all[i].split("/")[all[i].split("/").length - 1];
                folder = false;
                is_folder = "";
                if (fileName == "") {
                    fileName = all[i].split("/")[all[i].split("/").length - 2];
                    folder = true;
                    is_folder = "is_folder='true'";
                }
                status = all[i].split("/")[3];
                if (folder) {
                    preview = "<img src='../assets/images/folder.png' />";
                } else {
                    if (isImage(all[i])) {
                        privElem = all[i].split('/');
                        privElem.splice(0, 3);
                        privElem.pop();
                        privElem = privElem.join('/');
                        if (status == 'private') {
                            preview = "<img src='image.php?v=" + encodeURIComponent(privElem + "/" + fileName) +
                                "' />";
                        } else {
                            preview = "<img src='" + all[i] + "' />";
                        }
                    } else if (isVideo(all[i])) {
                        preview = "<img src='../assets/images/video.png' />";
                    } else {
                        preview = "";
                    }
                }
                if (fileName.toLowerCase().includes(search_term.toLowerCase())) {
                    document.getElementById("miniResults").innerHTML +=
                        "<div class='miniResult' " + is_folder + " status='" + status + "' full_path='" + all[
                            i] +
                        "' onclick='loading(this);'> " + preview + fileName + "</div>";
                    amountResults++;

                }
                if (amountResults > 10) {
                    break;
                }
            }


        }
    }









    function checkPath(str1, str2) {
        // check if the strings are the same
        if (str1 === str2) return false;
        arr1 = str1.split('/');
        arr2 = str2.split('/');
        arr1 = arr1.filter(val => val !== "");
        arr2 = arr2.filter(val => val !== "");
        if (arr1.length + 1 !== arr2.length) {
            return false;
        }
        if (str1.length < str2.length) {
            // check if str1 is a substring of str2
            if (str2.indexOf(str1) === 0) {
                return true;
            }
        } else {
            // check if str2 is a substring of str1
            return false;
        }
    }
    const elemsWithFullPath = document.querySelectorAll('[full_path]');
    elemsWithFullPath.forEach(elem => {
        if (elem.getAttribute('is_folder')) {
            elem.innerHTML += '<p class="up">▲</p>';
        }
    });

    function makeApiRequest(method, url, data) {
        return new Promise(function(resolve, reject) {
            const xhr = new XMLHttpRequest();
            xhr.open(method, url);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    resolve(xhr.response);
                } else {
                    reject(new Error(
                        `API request failed with status ${xhr.status}: ${xhr.statusText}`));
                }
            };
            xhr.onerror = function() {
                reject(new Error('API request failed due to a network error.'));
            };
            xhr.send(JSON.stringify(data));
        });
    }

    function activeIcon(elem) {
        const main = elem;
        const elems = document.querySelectorAll('.folderContents');
        elems.forEach(elem => {
            if (main != elem) {
                elem.classList.remove('clicked');
            }
        });

        if (elem.classList.contains('clicked')) {
            elem.classList.remove('clicked');
        } else {
            elem.classList.add('clicked');
        }
    }

    function loading(elem) {
        removeminires(document.getElementById('search_box'));
        const show = document.getElementById('columnContents');
        show.innerHTML = '';
        const overlay = document.createElement('div');
        overlay.classList.add('loader');
        const img = document.createElement('img');
        img.src = '../assets/images/loading.gif';
        img.alt = 'Loading...';
        overlay.style.width = show.offsetWidth + 'px';
        overlay.style.height = show.offsetHeight + 'px';
        overlay.style.position = 'absolute';
        overlay.style.left = (show.offsetLeft + 10) + 'px';
        overlay.style.top = (show.offsetTop + 65) + 'px';
        document.body.appendChild(overlay);
        overlay.appendChild(img);

        img.onload = function() {
            consoleLogPath(elem);
        };
    }


    function consoleLogPath(elem) {
        var columnContents = document.getElementById("columnContents");
        var elements1 = columnContents.querySelectorAll("*");

        for (var i = 0; i < elements1.length; i++) {
            var listeners = getEventListeners(elements1[i]);

            for (var eventType in listeners) {
                for (var j = 0; j < listeners[eventType].length; j++) {
                    elements1[i].removeEventListener(eventType, listeners[eventType][j].listener);
                }
            }
        }

        status = elem.getAttribute('status');
        const show = document.getElementById('columnContents');
        const elements = document.querySelectorAll('[full_path]');
        const elemPath = elem.getAttribute('full_path'); // Set the desired full_path value to compare against
        pathInf = elemPath.split('/');
        privElem = elemPath.split('/');
        privElem.splice(0, 3);
        privElem = privElem.join('/');
        pathInf.pop()
        pathInf.splice(0, 3);
        if (pathInf.includes('')) {
            pathInf.pop();
        }
        filePathShow = document.getElementById('filePath');
        filePathShow.innerHTML = '';
        paths = []
        for (let i = 0; i < pathInf.length; i++) {
            if (i == 0) {
                paths[i] = pathInf[i];
            } else {
                paths[i] = paths[i - 1] + "/" + pathInf[i];
            }
        }

        document.getElementsByTagName("title")[0].innerText = paths[paths.length - 1] + "/ - CodeConnect";
        document.getElementById("sBox").querySelectorAll("input")[0].placeholder = "Search " + pathInf[pathInf.length -
            1] + "...";
        document.getElementById("searchPos").value = elemPath;

        for (let i = 0; i < pathInf.length; i++) {
            filePathShow.innerHTML +=
                `<button is_folder="true" full_path="../scripts/<?php echo $_SESSION['uid']?>_assets_<?php echo $row['scripts_id']?>/` +
                paths[i] +
                `/" onclick="event.stopPropagation();loading(this)" class="filePathShow">` + pathInf[i] + `   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" height="70%">
                <path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" fill="#fff"/></svg></button>
`;
        }

        function renderFiles(folder, mainDirectory, fileName, path, recent = false) {
            if (recent) {
                privElem = path.split('/');
                privElem.splice(0, 3);
                privElem.pop();
                privElem = privElem.join('/');
            }
            const audioExtensions = [
                'mp3', 'wav', 'ogg', 'flac', 'aac', 'm4a', 'wma', 'aiff', 'alac'
            ];

            const textBasedExtensions = [
                'txt', 'md', 'doc', 'docx', 'odt', 'pdf', 'html', 'htm', 'xml', 'svg',
                'css', 'scss', 'sass', 'less', 'styl', 'js', 'jsx', 'ts', 'tsx', 'json',
                'py', 'rb', 'php', 'java', 'c', 'cpp', 'h', 'hpp', 'go', 'swift', 'sql',
                'yml', 'yaml', 'toml', 'ini', 'cfg', 'conf', 'sh', 'bash', 'zsh', 'fish',
                'ps1', 'psm1', 'bat', 'cmd', 'log', 'gitignore', 'env', 'csv', 'tsv',
                'mdx', 'adoc', 'rtf', 'tex', 'latex', 'ltx', 'bib', 'hbs', 'ejs', 'jade'
            ];

            const imageExtensions = [
                'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'tif', 'webp', 'ico', 'svg'
            ];

            const videoExtensions = [
                'mp4', 'webm', 'mkv', 'flv', 'vob', 'ogv', 'ogg', 'avi', 'mov', 'wmv', 'yuv', 'rm', 'rmvb', 'mpg',
                'mp2', 'mpeg', 'mpe', 'mpv', 'm2v', 'm4v', 'svi', '3gp', '3g2', 'mxf', 'roq', 'nsv', 'flv', 'f4v',
                'f4p', 'f4a', 'f4b'
            ];

            if (folder) {
                fileName = fileName[fileName.length - 1] + '/';
                fileName = fileName.slice(0, -1);
                document.getElementById('folderGrid').innerHTML +=
                    "<div is_folder='" + folder + "' status='" + mainDirectory[3] +
                    "' ondblclick='loading(this);' full_path='" +
                    path +
                    "' class='folderContents'><img src='../assets/images/folder.png' class='folderIcon'/>" +
                    fileName +
                    "</div>";
            } else {

                fileName = fileName[fileName.length - 1];
                ext = fileName.split('.');
                ext = ext[ext.length - 1];
                if (videoExtensions.includes(ext)) {
                    document.getElementById('folderGrid').innerHTML +=
                        "<div  ondblclick='loading(this);' status='" + mainDirectory[3] + "' full_path='" + path +
                        "' class='folderContents'><img src='../assets/images/video.png' class='videoIcon'/>" +
                        fileName +
                        "</div>";
                } else if (imageExtensions.includes(ext)) {
                    document.getElementById('folderGrid').innerHTML +=
                        "<div status='" + mainDirectory[3] + "'  ondblclick='loading(this);' full_path='" + path +
                        "' class='folderContents'><img src='imgPreview.php?v=" + encodeURIComponent(privElem) + "/" +
                        fileName + " ' class='imgIcon'/></br>" +
                        fileName +
                        "</div>";
                } else if (audioExtensions.includes(ext)) {
                    document.getElementById('folderGrid').innerHTML +=
                        "<div status='" + mainDirectory[3] + "'  ondblclick='loading(this);' full_path='" + path +
                        "' class='folderContents'>" +
                        fileName +
                        "</div>";
                } else if (textBasedExtensions.includes(ext)) {
                    document.getElementById('folderGrid').innerHTML +=
                        "<div status='" + mainDirectory[3] + "'  ondblclick='loading(this);' full_path='" + path +
                        "' class='folderContents'>" +
                        fileName +
                        "</div>";
                } else {
                    document.getElementById('folderGrid').innerHTML +=
                        "<div status='" + mainDirectory[3] + "' ondblclick='loading(this);' full_path='" + path +
                        "' class='folderContents'>" +
                        fileName +
                        "</div>";
                }


            }
        }
        const elemsWithFullPath = document.querySelectorAll(
            '[full_path]'); // Get all elements with a full_path attribute

        const baseUrl = window.location.protocol + "//" + window.location.hostname;
        fullUrl = "<?php echo $mainDir;?>".replace(/^\./, '');
        url = elemPath.replace(/^\.\/<?php echo $mainDir1;?>/, '');
        fullUrl = url;
        fullUrl = fullUrl.slice(2);
        fullUrl = fullUrl.replace(/\/+/g, '/');
        fullUrl = baseUrl + fullUrl;

        if (status == 'public') {
            filePathShow.addEventListener('click', function(e) {
                e.target.innerHTML = "<input readonly id='pathCopy' value='" + fullUrl +
                    "' style='width:100%;height:100%'/>";

                document.getElementById("pathCopy").focus();
                document.getElementById("pathCopy").setSelectionRange(0, document.getElementById("pathCopy")
                    .value.length);
            });
        } else if (status == 'private') {

            filePathShow.removeEventListener('click', function(e) {
                e.target.innerHTML = "<input readonly id='pathCopy' value='" + fullUrl +
                    "' style='width:100%;height:100%'/>";

                document.getElementById("pathCopy").focus();
                document.getElementById("pathCopy").setSelectionRange(0, document.getElementById("pathCopy")
                    .value.length);
            });
        }


        filePathShow.addEventListener('blur', function() {
            filePathShow.innerHTML = '';
            document.getElementById("sBox").querySelectorAll("input")[0].placeholder = "Search " + pathInf[
                pathInf.length - 1] + "...";
            document.getElementById("searchPos").value =
                "../scripts/<?php echo $_SESSION['uid']?>_assets_<?php echo $row['scripts_id']?>/" + paths[i] +
                "/";


            for (let i = 0; i < pathInf.length; i++) {
                filePathShow.innerHTML +=
                    `<button is_folder="true" full_path="../scripts/<?php echo $_SESSION['uid']?>_assets_<?php echo $row['scripts_id']?>/` +
                    paths[i] + `/" onclick="event.stopPropagation();loading(this)" class="filePathShow">` +
                    pathInf[i] + `</button>`;
            }
        });

        if (isTextBasedLanguage(elemPath)) {
            const method = 'POST';
            const url = baseUrl + "/api/private/get_item_contents/";
            const data = {
                "full_url": elemPath,
                "uid": "<?php echo $_SESSION['uid']?>",
                "scripts_id": "<?php echo $row['scripts_id']?>",
                "api_token": "<?php echo $_SESSION['api_token']?>"
            };
            const contents = (response) => {
                const contents = JSON.parse(response);
                if (contents['success'] && contents['ext'] === 'pdf') {
                    document.getElementById('columnContents').innerHTML = `<p>Unable to display PDF files.</p>`;
                } else if (contents['success']) {
                    document.getElementById('columnContents').innerHTML =
                        "<textarea id='content' style='width:100%;height:98%;'>" +
                        contents['data'] + "</textarea>";
                    var textarea = document.getElementById('content');
                    var fileExt = contents['ext'];
                    var mode;

                    if (fileExt) {
                        // Lookup the mode based on the file extension
                        var modeInfo = CodeMirror.findModeByExtension(fileExt);
                        if (modeInfo) {
                            mode = modeInfo.mode;
                        }
                    }

                    // If we couldn't find a mode by extension, use plain text mode
                    if (!mode) {
                        mode = "text/plain";
                    }
                    var editor = CodeMirror.fromTextArea(textarea, {
                        mode: mode,
                        lineNumbers: true,
                        theme: "dracula",
                        gutters: ["CodeMirror-lint-markers"],
                        lint: {
                            options: {
                                esversion: 2021
                            }
                        },
                        autoCloseBrackets: true,
                        extraKeys: {
                            "Alt-F": "findPersistent"
                        },
                        highlightSelectionMatches: {
                            showToken: /\w/,
                            annotateScrollbar: true
                        },
                        extraKeys: {
                            "F11": function(cm) {
                                cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                            },
                            "Esc": function(cm) {
                                if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                            }
                        }
                    });
                    editor.setSize(null, 500);
                    document.getElementById('columnContents').style.overflowY = 'hidden';
                    document.getElementsByClassName('loader')[0].remove();

                } else {
                    document.getElementById('columnContents').innerHTML += "Error: " + contents['error'];
                }
            };
            makeApiRequest(method, url, data)
                .then(contents)
                .catch((error) => console.error(error));
        } else if (isImage(elemPath)) {
            if (elem.getAttribute('status') == 'private') {
                document.getElementById('columnContents').innerHTML =
                    '<div style="display:flex;align-items:center;justify-content:center;height:100%;width:100%"><img class="imgView" src="./image.php?v=' +
                    encodeURIComponent(privElem) + '"></div>';
                filePathShow.removeEventListener('click', function(e) {
                    if (status == 'public') {
                        e.target.innerHTML = "<input readonly id='pathCopy' value='" + fullUrl +
                            "' style='width:100%;height:100%'/>";
                    }

                    document.getElementById("pathCopy").focus();
                    document.getElementById("pathCopy").setSelectionRange(0, document.getElementById("pathCopy")
                        .value.length);
                });
                filePathShow.addEventListener('click', function(e) {
                    if (status == 'private') {
                        e.target.innerHTML = "<input readonly id='pathCopy' value='" + baseUrl +
                            "/user_assets/image.php?v=" + encodeURIComponent(privElem) +
                            "' style='width:100%;height:100%'/>";
                    }

                    document.getElementById("pathCopy").focus();
                    document.getElementById("pathCopy").setSelectionRange(0, document.getElementById("pathCopy")
                        .value.length);
                });
            } else if (elem.getAttribute('status') == 'public') {
                document.getElementById('columnContents').innerHTML =
                    '<div style="display:flex;align-items:center;justify-content:center;height:100%;"><img class="imgView" src="' +
                    fullUrl +
                    '" style="width:auto;height:100%;"></div>';

            }

        } else if (isVideo(elemPath)) {
            if (elem.getAttribute('status') == 'private') {
                document.getElementById('columnContents').innerHTML = `<video style="width:100%;height:100%;" controls>
    <source src="./video.php?v=` + encodeURIComponent(privElem) + `" type="video/mp4">
</video>
`;
                document.getElementById('columnContents').style.overflowY = 'hidden';
                filePathShow.removeEventListener('click', function(e) {
                    if (status == 'public') {
                        e.target.innerHTML = "<input readonly id='pathCopy' value='" + fullUrl +
                            "' style='width:100%;height:100%'/>";
                    }

                    document.getElementById("pathCopy").focus();
                    document.getElementById("pathCopy").setSelectionRange(0, document.getElementById("pathCopy")
                        .value.length);
                });
                filePathShow.addEventListener('click', function(e) {
                    if (status == 'private') {
                        e.target.innerHTML = "<input readonly id='pathCopy' value='" + baseUrl +
                            "/user_assets/video.php?v=" + encodeURIComponent(privElem) +
                            "' style='width:100%;height:100%'/>";
                    }

                    document.getElementById("pathCopy").focus();
                    document.getElementById("pathCopy").setSelectionRange(0, document.getElementById("pathCopy")
                        .value.length);
                });
            } else if (elem.getAttribute('status') == 'public') {
                document.getElementById('columnContents').innerHTML = `<video style="width:100%;height:100%;" controls>
    <source src="` + fullUrl + `" type="video/mp4">
</video>`;
                document.getElementById('columnContents').style.overflowY = 'hidden';

            }

        } else {
            document.getElementById('columnContents').innerHTML = "Error: File type not supported";
        }
        exist = false;
        for (let j = 0; j < recents.length; j++) {
            path = `../scripts/<?php echo $_SESSION['uid']?>_assets_<?php echo $row['scripts_id']?>/` + privElem;

            if (recents[j]['path'] == path) {
                exist = true;
            }
        }
        for (let j = 0; j < recents.length; j++) {
            path = `../scripts/<?php echo $_SESSION['uid']?>_assets_<?php echo $row['scripts_id']?>/` + privElem;
            test = path.split("/");
            test = test.filter(Boolean);
            if (recents[j]['path'] == path) {
                recents[j]['atime'] = new Date().getTime() / 1000;
            } else if (test.length > 4 && !exist) {
                recents.pop();
                recents.push({
                    path: path,
                    atime: new Date().getTime() / 1000
                });
            }
        }
        recents.sort((a, b) => b.atime - a.atime);

        document.getElementsByClassName('loader')[0].remove();
        elem.open = !elem.open;
        items = [];
        elemsWithFullPath.forEach(elem1 => {
            if (elem1.getAttribute('full_path') === elemPath) {
                elem1.classList.add('activeFile');
                elem1.scrollIntoView({
                    behavior: 'smooth'
                });

            } else {
                elem1.classList.remove('activeFile');
            }

            if (checkPath(elemPath, elem1.getAttribute('full_path'))) {

                if (elem.open) {
                    items.push(elem1.getAttribute('full_path'));

                    elem1.style.display = 'block';
                } else {
                    elem1.open = false;
                    if (elem1.getAttribute('is_folder')) {

                        if (elem1.open) {

                            elem.innerHTML += '<p class="down">▼</p>';
                            var elems = elem.querySelectorAll('.up');
                            for (var i = 0; i < elems.length; i++) {
                                elems[i].style.display = 'none';
                            }
                        } else {
                            elem1.innerHTML += '<p class="up">▲</p>';
                            var elems = elem.querySelectorAll('.down');
                            for (var i = 0; i < elems.length; i++) {
                                elems[i].style.display = 'none';
                            }
                        }
                    }

                    elem1.style.display = 'none';
                }
            } else if (elem1.getAttribute('full_path').includes(elemPath) && elem1.getAttribute('full_path') !==
                elemPath) {
                elem1.style.display = 'none';
                elem1.open = false;
                if (elem1.getAttribute('is_folder')) {
                    if (elem1.open) {
                        elem1.innerHTML += '<p class="down">▼</p>';
                        var elems = elem.querySelectorAll('.up');
                        for (var i = 0; i < elems.length; i++) {
                            elems[i].style.display = 'none';
                        }
                    } else {
                        elem1.innerHTML += '<p class="up">▲</p>';
                        var elems = elem.querySelectorAll('.down');
                        for (var i = 0; i < elems.length; i++) {
                            elems[i].style.display = 'none';
                        }
                    }
                }

            }
        });
        if (elem.getAttribute('is_folder')) {

            if (elem.open) {
                elem.innerHTML += '<p class="down">▼</p>';
                var elems = elem.querySelectorAll('.up');
                for (var i = 0; i < elems.length; i++) {
                    elems[i].style.display = 'none';
                }
            } else {
                elem.innerHTML += '<p class="up">▲</p>';
                var elems = elem.querySelectorAll('.down');
                for (var i = 0; i < elems.length; i++) {
                    elems[i].style.display = 'none';
                }
            }
        }

        function getFileName(filePath) {
            // Use the lastIndexOf() function to find the last occurrence of a slash (/) or backslash (\) in the file path
            const lastSlashIndex = Math.max(filePath.lastIndexOf('/'), filePath.lastIndexOf('\\'));

            // If a slash or backslash is found, extract the filename by taking a substring of the path starting from the last slash/backslash position + 1
            if (lastSlashIndex > -1) {
                const fileName = filePath.substring(lastSlashIndex + 1);
                return fileName || filePath; // return fileName if it's not empty, or the entire path otherwise
            }

            // If no slash or backslash is found, the entire path is the filename
            return filePath;
        }

        if (items.length > 0) {
            document.getElementById('columnContents').style.overflowY = 'scroll';
            document.getElementById('columnContents').innerHTML = '<div id="folderGrid">';
            if (items.length > 32) {
                load = 32;
            } else {
                load = items.length;
            }
            for (var i = 0; i < load; i++) {
                fileName = items[i].slice(3);
                fileName = fileName.split('/');
                folder = false;
                for (var j = 0; j < fileName.length; j++) {

                    if (fileName[j] === '') {
                        folder = true;
                    }
                }
                fileName = fileName.filter((value) => Boolean(value));
                mainDirectory = url;
                mainDirectory = mainDirectory.split("/");
                renderFiles(folder, mainDirectory, fileName, items[i]);
            }
            document.getElementById('columnContents').innerHTML += '</div>';

            folderContents = document.querySelectorAll('.folderContents');

            folderContents.forEach((element) => {
                element.removeEventListener('click', () => {
                    activeIcon(element);
                });
                element.addEventListener('click', () => {
                    activeIcon(element);
                });


            });

            document.getElementById("columnContents").addEventListener('scroll', () => {
                setInterval(() => {
                    if (document.getElementById("columnContents").scrollTop + document.getElementById(
                            "columnContents").clientHeight >= document.getElementById("columnContents")
                        .scrollHeight - 200) {
                        amountLoaded = columnContents.querySelectorAll('.folderContents').length;
                        let load;
                        amountToLoad = 32;
                        if (items.length > amountLoaded + amountToLoad) {
                            load = amountLoaded + amountToLoad;
                        } else {
                            load = items.length;
                        }
                        for (let i = amountLoaded; i < load; i++) {
                            fileName = items[i].slice(3).split('/').filter((value) => Boolean(value));
                            folder = fileName.includes('');
                            mainDirectory = url.split('/');
                            renderFiles(folder, mainDirectory, fileName, items[i]);
                        }
                        folderContents = document.querySelectorAll('.folderContents');

                        folderContents.forEach((element) => {
                            element.removeEventListener('click', () => {
                                activeIcon(element);
                            });
                            element.addEventListener('click', () => {
                                activeIcon(element);
                            });


                        });



                    }
                }, 1000);
            });
        } else if (elem.getAttribute('is_folder')) {
            document.getElementById('columnContents').innerHTML = '<div id="folderGrid">';
            document.getElementById("sBox").querySelectorAll("input")[0].placeholder = "Search...";
            document.getElementById("searchPos").value = elemPath;

            for (var i = 0; i < recents.length; i++) {
                fileName = recents[i]['path'].slice(3);
                fileName = fileName.split('/');
                folder = false;
                for (var j = 0; j < fileName.length; j++) {
                    if (fileName[j] === '') {
                        folder = true;
                    }
                }
                fileName = fileName.filter((value) => Boolean(value));
                mainDirectory = recents[i]['path'];
                mainDirectory = mainDirectory.split("/");
                filePathShow = document.getElementById('filePath');
                document.getElementsByTagName("title")[0].innerHTML = "recent/ - CodeConnect";
                filePathShow.innerHTML = '';
                filePathShow.innerHTML +=
                    `<button is_folder="true" full_path="" onclick="event.stopPropagation();" class="filePathShow">recent <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" height="70%">
                <path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" fill="#fff"/></svg></button>
`;
                renderFiles(folder, mainDirectory, fileName, recents[i]['path'], true);
                document.getElementById("searchPos").value = "";

            }
            document.getElementById('columnContents').innerHTML += '</div>';
            folderContents = document.querySelectorAll('.folderContents');

            folderContents.forEach((element) => {
                element.removeEventListener('click', () => {
                    activeIcon(element);
                });
                element.addEventListener('click', () => {
                    activeIcon(element);
                });
            });
            document.getElementById('columnContents').style.overflowY = "scroll";


        }
        const folders = document.querySelectorAll('.folderContents');
        let numImagesLoaded = 0;
        let totalImages = 0;
        folders.forEach(folder => {
            const images = folder.querySelectorAll('img');
            totalImages += images.length;
            images.forEach(img => {
                if (img.complete) {
                    numImagesLoaded++;
                } else {
                    img.addEventListener('load', function() {
                        numImagesLoaded++;
                        const loaders = document.querySelectorAll('.loader');
                        if (numImagesLoaded === totalImages) {
                            loaders.forEach(loader => loader.remove());
                        }

                    });
                }
            });
        });
        if (elem.getAttribute('recent') == "true") {
            elem.remove();
        }
    }
    // Get a reference to the custom box

    // Add an event listener for the right-click event on the page
    document.addEventListener('click', function(event) {
        if (event.which === 1) {
            const differentBox = document.getElementById('custom-box');

            differentBox.style.display = 'none';
        }
    });

    window.onload = function() {
        document.body.innerHTML +=
            `<div id="first" class="columnItem activeFile" is_folder="true" open="false" full_path="../scripts/<?php echo $_SESSION['uid']?>_assets_<?php echo $row['scripts_id']?>/recent/" onclick="loading(this);" style="display: none;"></div>`
        document.getElementById("first").click();
    }
    // document.addEventListener('contextmenu', function(event) {
    //     // Prevent the default right-click menu from appearing
    //     event.preventDefault();

    //     // Get the right-clicked element and its position
    //     const clickedElement = event.target;
    //     const x = event.clientX;
    //     const y = event.clientY;

    //     // Check if the clicked element is the box element
    //     // Display a different box at the position of the right-click
    //     const differentBox = document.getElementById('custom-box');
    //     differentBox.style.position = 'fixed';
    //     differentBox.style.top = y + 'px';
    //     differentBox.style.left = x + 'px';
    //     differentBox.style.zIndex = '9999';
    //     differentBox.style.display = 'block';

    //     document.body.appendChild(differentBox);

    // });
    </script>
    <script>

    </script>
</body>

</html>