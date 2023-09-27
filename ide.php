<!DOCTYPE HTML>
<HTML>

<head>
    <title>Code Editor</title>
    <link rel="stylesheet" href="https://cdn.korzh.com/metroui/v4.5.1/css/metro-all.min.css">

    <style>
    body {
        font-family: sans-serif;
        font-size: 14px;
        margin: 0;
        padding: 0;
        background: #18181B !important;
    }

    #editor {
        width: 100%;
        height: fit-content;
        background-color: #444;
        padding: 20px;
        margin: 20px auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        border-radius: 5px;
    }

    #tags {}

    #editor textarea {
        width: 100%;
        height: 100%;
        font-size: 16px;
        color: #eee;
        background: none;
        padding: 10px;
        margin: 0;
        overflow-y: auto;
        border: none;
    }

    .CodeMirror {
        font-size: 14px;
    }

    #editor textarea:focus {
        outline: none;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .loadingScreen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 999;
        background-color: #000;
    }

    .loader {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    #loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: flex;
        align-items: center;
        justify-content: center;
        visibility: hidden;
    }

    .loading-gif {
        max-width: 100%;
        max-height: 100%;
    }

    #ide {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    #tabs {
        display: flex;
        flex-direction: row;
        background-color: #18181B;
        padding: 10px;
        padding-bottom: 0;
    }

    #tabs a {
        text-decoration: none;
        color: white;
        padding: 10px;
        margin-right: 10px;
        border-radius: 5px 5px 0 0;
        background-color: none;
        transition: background-color 0.2s ease-in-out;
        border-bottom: none;
    }

    #tabs a:hover {
        background-color: #282A36;
    }

    #tabs a.active {
        background-color: #282A36;
    }

    #code-viewer {
        flex: 1;
        padding: 10px;
        background-color: #18181B;
        overflow-y: auto;
        height: 100%;
        padding-top: 0;
    }

    #code-viewer pre {
        font-family: monospace;
        font-size: 14px;
        margin: 0;
        padding: 0;
    }

    #test-button-container {
        width: 100%;
    }

    #test-button {
        padding: 10px;
    }

    .CodeMirror-scroll {
        padding-bottom: 0;
    }

    .CodeMirror {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }

    .CodeMirror-focused .cm-matchhighlight {
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAIAAAACCAYAAABytg0kAAAAFklEQVQI12NgYGBgkKzc8x9CMDAwAAAmhwSbidEoSQAAAABJRU5ErkJggg==);
        background-position: bottom;
        background-repeat: repeat-x;
    }

    .cm-matchhighlight {
        background-color: #135564
    }

    .CodeMirror-selection-highlight-scrollbar {
        background-color: green
    }

    .CodeMirror {
        border-top: 1px solid black;
        border-bottom: 1px solid black;

    }

    .CodeMirror-scroll {
        overflow-x: hidden;
    }

    dt {
        font-family: monospace;
        color: #666;
    }

    #modal {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        height: fit-content;
        min-height: 300px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.4), 0 6px 20px 0 rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        background-color: white;
        overflow: hidden;
    }

    .list-item {
        display: inline-block;
        padding: 5px;
        margin: 5px;
        background-color: #ccc;
        border-radius: 5px;
    }

    #modalRun {
        width: 100vw;
        height: 100vh;

    }

    .slide-out {
        animation: slideOut 1s ease forwards;
    }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="./codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="./codemirror/addon/lint/lint.css">
    <link rel="stylesheet" href="./codemirror/addon/dialog/dialog.css">
    <link rel="stylesheet" href="./codemirror/addon/search/matchesonscrollbar.css">
    <link rel="stylesheet" href="./codemirror/theme/dracula.css">
    <script src="./codemirror/lib/codemirror.js"></script>
    <script src="./codemirror/mode/javascript/javascript.js"></script>
    <script src="./codemirror/mode/css/css.js"></script>
    <script src="https://unpkg.com/jshint@2.13.2/dist/jshint.js"></script>
    <script src="https://unpkg.com/jsonlint@1.6.3/web/jsonlint.js"></script>
    <script src="https://unpkg.com/csslint@1.0.5/dist/csslint.js"></script>
    <script src="./codemirror/addon/lint/lint.js"></script>
    <script src="./codemirror/addon/lint/javascript-lint.js"></script>
    <script src="./codemirror/addon/lint/json-lint.js"></script>
    <script src="./codemirror/addon/lint/css-lint.js"></script>
    <link rel="stylesheet" href="./codemirror/addon/scroll/simplescrollbars.css">
    <script src="./codemirror/addon/scroll/simplescrollbars.js"></script>
    <script src="./codemirror/addon/edit/closebrackets.js"></script>
    <script src="./codemirror/mode/javascript/javascript.js"></script>
    <link rel="stylesheet" href="./codemirror/addon/display/fullscreen.css">
    <script src="./codemirror/addon/display/fullscreen.js"></script>

    <!-- Includes the navbar.php file -->


<body>
    <div class="loadingScreen">
        <img class="loader" src="./assets/images/loading.gif" />
    </div> <?php 
    require "navbar.php";
    require "connect.php";

?> <style>
    .nvbar {
        position: relative;
        background: #18181B;
    }

    #ide {
        display: none;
    }

    .library {
        width: fit-content;
        margin: none;
        float: left !important;
        margin-left: 10px !important;
        color: white;
        font-size: 12px;
        border: solid grey 1px;
        padding: 5px;
        margin-top: 10px;

    }

    #libraryShow {
        margin-left: -10px !important;
        height: fit-content !important;
        width: 100% !important;
    }

    #addLibrary {
        width: 20px;
        height: 20px;
        background-color: #4C5053;
        border: solid grey 1px;
        line-height: 20px;
        color: grey;
        font-size: 12px;


    }

    a:hover {
        text-decoration: none !important;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 20px;
        margin-top: 5px;
    }

    .switch input {
        opacity: 0;
        width: fit-content;
        height: fit-content;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: -5px;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        height: 20px !important;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 15px;
        width: 15px;
        bottom: 0.11em;
        right: 32px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input+.slider {
        background-color: #282A36;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #282A36;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 10px;
        border: solid grey 1px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    #fileDetails {
        position: absolute;
        width: 300px;
        background: red;
    }

    /* Tooltip container */
    .tooltip {
        position: relative;
        display: inline-block;
        border-bottom: 1px dotted black;
        /* Add a dotted bottom border */
    }

    /* Tooltip text */
    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: white;
        text-align: center;
        padding: 5px 0;
        border-radius: 6px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -60px;
    }

    /* Show the tooltip text when you hover over the tooltip container */
    .tooltip:hover .tooltiptext {
        visibility: visible;
    }

    @keyframes slideOut {
        from {
            transform: translateX(0%);
        }

        to {
            transform: translateX(100%);
            display: none;
        }
    }

    .htmlDiv {
        float: left;
        width: 50%;
        height: 100%;
        box-sizing: border-box;
    }

    .iframeDiv {
        float: right;
        width: 50%;
        height: 100%;
        background-color: #ccc;
        box-sizing: border-box;
        text-align: center;
        overflow: auto;
        padding-left: 50px;
    }

    .sliderBar {
        position: absolute;
        top: 0;
        left: 50%;
        height: 100%;
        width: 10px;
        background-color: #18181B;
        cursor: ew-resize;
        z-index: 9999;
    }

    .expand-btn {
        position: fixed;
        top: 50px;
        left: 50px;
        height: 50px;
        width: 50px;
        background-color: red;
        cursor: pointer;
        z-index: 9999;
        visibility: hidden;
    }

    .htmlDivBtn {
        position: fixed;
        top: 50px;
        right: 50px;
        height: 40px;
        width: 40px;
        background: none;
        color: white;
        cursor: pointer;
        z-index: 9999;
        visibility: hidden;
    }

    .iframeDivBtn {
        position: fixed;
        top: 50px;
        right: 50px;
        height: 40px;
        width: 40px;
        background: none;
        color: white;
        cursor: pointer;
        z-index: 9999;
        visibility: hidden;

    }

    body {
        user-select: none;
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

    .columnItem {
        color: white;
        border-bottom: 1px solid grey;
        padding: 5px;
        cursor: pointer;
    }

    .columnItem:hover {
        background: #44475A;
    }

    .columnItem p {
        margin: 0;
        display: inline-block;
    }

    .up,
    .down {
        position: absolute;
        right: 0;
        opacity: 0.5;
    }
    </style>
    <div class="modal" style="height:100vh;overflow-y:none" id="modalRun">
        <div style="height:100%;" class="modal-content">
            <div style="background-color:#18181B;color:white;height:auto">
                <span style="cursor:pointer;font-size:30px;padding:0;width:fit-content;height:fit-content"
                    class="close-modal">&times;</span>
                <div style="float:right; display:inline;margin:0;margin-right:20px;top:20%;word-wrap: break-word;background-color:#18181B;"
                    id="modules"></div>

                <div style="float:right;margin:0;margin-right:20px;top:20%;" id="variables"></div>

            </div>
            <div style="width:100%;position:relative;height:100vh">
                <div class="htmlDivBtn" onclick="expandDiv1()"><svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 640 512">
                        <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M392.8 1.2c-17-4.9-34.7 5-39.6 22l-128 448c-4.9 17 5 34.7 22 39.6s34.7-5 39.6-22l128-448c4.9-17-5-34.7-22-39.6zm80.6 120.1c-12.5 12.5-12.5 32.8 0 45.3L562.7 256l-89.4 89.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l112-112c12.5-12.5 12.5-32.8 0-45.3l-112-112c-12.5-12.5-32.8-12.5-45.3 0zm-306.7 0c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3l112 112c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256l89.4-89.4c12.5-12.5 12.5-32.8 0-45.3z" />
                    </svg></div>
                <div class="iframeDivBtn" onclick="expandDiv2()"><svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 576 512">
                        <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                    </svg></div>
                <div class="htmlDiv">

                    <?php
                        $sql = "SELECT scripts_id FROM users WHERE uid = '".$_SESSION['uid']."' AND api_token = '".$_SESSION['api_token']."'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $security_id = $row['scripts_id'];
                        $html = file_get_contents("./scripts/".$_SESSION['uid']."_tests_".$row['scripts_id']."/".$_GET['script_id'].".html");
                    ?>
                    <textarea id="test_suite_editor">
                    <?php echo htmlspecialchars($html); ?>
                    </textarea>

                    <script>
                    var test_suite_editor = CodeMirror.fromTextArea(document.getElementById("test_suite_editor"), {
                        mode: "html",
                        theme: "dracula",
                        lint: {
                            options: {
                                esversion: 2021
                            }
                        },
                        scrollbarStyle: "simple",
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
                    test_suite_editor.setSize(null, 500);
                    </script>
                </div>
                <div class="sliderBar" onmousedown="dragSlider(event)"></div>
                <div class="iframeDiv">
                    <iframe id="iframe" width="100%" height="100%"></iframe>
                </div>

            </div>


            <div class="input-container" style="background-color:#18181B;height:auto">
                <button style="border-radius:5px;width:fit-content;padding:5px" id="go">Update Test Suite</button>

            </div>
        </div>
    </div>


    <input type="hidden" id="errorCreate">
    <div id="modal" style="width:260px">
        <div style="width:100%;min-height:25px;background-color:#494949;position: relative;" id="config_header">
            <h1 id="titleShow"
                style="font-size:12px;color:white;position: absolute; left: 5px; top: 50%; transform: translateY(-50%); width: 100%;overflow-wrap: break-word;padding-top:10px;padding-bottom:10px;height:fit-content">
                <?php echo ucwords($titleIDE)?></h1>

        </div>
        <form style="background-color:#3D3F41;  padding: 10px;-webkit-box-shadow: inset -3px 10px 12px -6px rgba(0,0,0,0.75);
-moz-box-shadow: inset -3px 10px 12px -6px rgba(0,0,0,0.75);
box-shadow: inset -3px 10px 12px -6px rgba(0,0,0,0.75);" id="choiceBox" method="post">
            <label style="margin-top:20px;font-size:12px;color:white" for="title">Title: </label>
            <input style="font-size:12px;width:80%" name="title" value="<?php echo $titleIDE?>" id="title" type="text">
            <br>
            <br>
            <input type="hidden" name="extraction" id="extraction">
            <input style="" type="checkbox" <?php echo $extractIDE?> id="extractionCheckbox">
            <label style="font-size:12px;color:white;margin-left:3px" for="extractionParams1">Enable (( ))
                extraction?</label>
            <div id="tooltip" style="display:inline-block"><img style="width:15px;cursor:pointer"
                    src="./assets/images/infoIcon.png" alt="" srcset=""></div>
            <br>
            <input style="" onchange="showjsTypes()" type="checkbox" <?php echo $jsIDE?> name="js" id="jsCheckbox">
            <label style="font-size:12px;color:white;margin-left:3px" for="js">Include JS?</label>
            <br>
            <div id="typeSelect">
                <input type="hidden" name="type" id="type">
                <input name="type1" style="" type="checkbox" <?php echo $moduleIDE?> id="typeCheckbox">
                <label style="font-size:12px;color:white;margin-left:3px" for="type1">JS Module?</label>
                <br>
            </div>

            <input style="" type="checkbox" <?php echo $cssIDE?> name="css" id="cssCheckbox">
            <label style="font-size:12px;color:white;margin-left:3px" for="css">Include CSS?</label>
            <br>
            <br>
            <label style="color:white;font-size: 12px" for="libraries">Libraries:</label>
            <input type="hidden" id="librariesSave" value="<?php echo $librariesIDE?>" name="librariesSave">
            <select style="font-size:12px;background-color:#4C5053; color:white;border:solid grey 1px;height:20px"
                name="libraries" id="libraries">
                <?php
                        $json = file_get_contents('./libraries/libraries.json');
                        $jsonArr = json_decode($json, true);
                        
                        foreach ($jsonArr as $key => $value) {
                            echo '<option value="'.$key.'">'.$value["name"].'</option>';
                        }
                    ?>
            </select>
            <button id="addLibrary" type="button">+</button>
            <div id="libraryShow"></div>
            <br>
            <br>
            <label style="font-size:12px;color:white;" for="tags">Tags: (seperate with a comma)</label>
            <input type="text" placeholder="Enter Tags..." name="tags" data-role="taginput"
                value="<?php echo $tagsIDE?>" data-tag-trigger="Comma">

            <br>
            <button
                style="border:solid grey 1px;color:white;font-weight:bold;background-color:#4C5053;border-radius:5px;width:40px;font-size:12px"
                type="button" onclick="next()">Next</button>

        </form>
    </div>
    <script>
    var startX = 0;
    var startY = 0;
    var startDiv1Width = 0;
    var startDiv2Width = 0;
    var sliderBar = document.querySelector(".sliderBar");
    var htmlDiv = document.querySelector(".htmlDiv");
    var iframeDiv = document.querySelector(".iframeDiv");
    var expandBtn1 = document.querySelector(".htmlDivBtn");
    var expandBtn2 = document.querySelector(".iframeDivBtn");
    var threshold = 50;

    function dragSlider(e) {
        startX = e.clientX;
        startDiv1Width = htmlDiv.offsetWidth;
        startDiv2Width = iframeDiv.offsetWidth;
        document.onmousemove = moveSlider;
        document.onmouseup = stopSlider;
    }

    function moveSlider(e) {
        var distance = e.clientX - startX;
        var newDiv1Width = startDiv1Width + distance;
        var newDiv2Width = startDiv2Width - distance;
        if (newDiv1Width < threshold || newDiv2Width < threshold) {
            if (newDiv1Width < threshold) {
                iframeDiv.style.paddingLeft = "0px";
                iframeDiv.style.paddingTop = "40px";
                htmlDiv.style.display = "none";
                expandBtn1.style.visibility = "visible";
                iframeDiv.style.width = "100%";
                sliderBar.style.visibility = "hidden";

            }
            if (newDiv2Width < threshold) {
                iframeDiv.style.display = "none";
                expandBtn2.style.visibility = "visible";
                htmlDiv.style.width = "100%";
                sliderBar.style.visibility = "hidden";
            }
            // Create a new mouseup event
            const mouseupEvent = new MouseEvent('mouseup', {
                bubbles: true,
                cancelable: true,
                view: window
            });
            // Trigger the mouseup event on the HTML element
            const htmlElement = document.documentElement;
            htmlElement.dispatchEvent(mouseupEvent);
            return;
        }
        htmlDiv.style.width = newDiv1Width + "px";
        iframeDiv.style.width = newDiv2Width + "px";
        sliderBar.style.left = (newDiv1Width + 5) + "px";
        expandBtn1.style.left = "5px";
        expandBtn2.style.right = "20px";

    }

    function stopSlider() {
        document.onmousemove = null;
        document.onmouseup = null;
        if (htmlDiv.offsetWidth < threshold) {
            sliderBar.style.visibility = "hidden";
            expandBtn1.style.visibility = "visible";
        }
    }

    function expandDiv1() {
        iframeDiv.style.paddingLeft = "50px";
        iframeDiv.style.paddingTop = "0px";

        expandBtn1.style.visibility = "hidden";
        if (htmlDiv.style.display == "none") {
            htmlDiv.style.width = "0%"

            // Animate the transition of htmlDiv
            htmlDiv.style.display = "block";
            let div1Width = 0;
            let intervalId = setInterval(function() {
                if (div1Width >= 50) {
                    clearInterval(intervalId);
                    sliderBar.style.visibility = "visible";
                    sliderBar.style.left = "50%";
                    return;
                }
                div1Width += 1;
                htmlDiv.style.width = div1Width + "%";
                iframeDiv.style.width = (100 - div1Width) + "%";
            }, 10);
        }
    }

    function expandDiv2() {
        iframeDiv.style.paddingLeft = "50px";
        iframeDiv.style.paddingTop = "0px";

        expandBtn2.style.visibility = "hidden";
        if (iframeDiv.style.display == "none") {
            // Animate the transition of iframeDiv
            iframeDiv.style.width = "0%"
            iframeDiv.style.display = "block";
            let div2Width = 0;
            let intervalId = setInterval(function() {
                if (div2Width >= 50) {
                    clearInterval(intervalId);
                    sliderBar.style.visibility = "visible";
                    sliderBar.style.left = "50%";
                    return;
                }
                div2Width += 1;
                iframeDiv.style.width = div2Width + "%";
                htmlDiv.style.width = (100 - div2Width) + "%";
            }, 10);
        }
    }
    // Get the tooltip element
    var tooltip = document.getElementById("tooltip");

    // Create a new tooltip text element
    var tooltipText = document.createElement("span");
    tooltipText.innerHTML =
        "Enable (( )) extraction to allow users to customize your script's behavior by passing parameters in the URL query. For example, you can use ((color)) in your script, and the user can set the color by modifying the URL. Our algorithm will extract the value and plug it into your code automatically.";
    tooltipText.style.display = "none";
    tooltipText.style.position = "absolute";
    tooltipText.style.backgroundColor = "black";
    tooltipText.style.color = "white";
    tooltipText.style.padding = "5px";
    tooltipText.style.borderRadius = "5px";
    tooltipText.style.zIndex = "9999";
    tooltipText.style.fontSize = "10px";
    tooltipText.style.width = "100px";

    // Append the tooltip text to the tooltip element
    tooltip.appendChild(tooltipText);

    // Add a mouseover event listener to show the tooltip
    tooltip.addEventListener("mouseover", function() {
        tooltipText.style.display = "block";
    });

    // Add a mouseout event listener to hide the tooltip
    tooltip.addEventListener("mouseout", function() {
        tooltipText.style.display = "none";
    });
    document.getElementById("title").onkeyup = function() {
        let title = document.getElementById("title").value;
        let titleShow = document.getElementById("titleShow");
        let words = title.split(" ");
        let capitalizedWords = words.map(word => word.charAt(0).toUpperCase() + word.slice(1));
        titleShow.innerHTML = capitalizedWords.join(" ");
        document.getElementsByTagName("title")[0].innerText = titleShow.innerHTML + " - CodeConnect Config";
    }

    function next() {
        error = [];
        js = document.getElementById('jsCheckbox').checked;
        css = document.getElementById('cssCheckbox').checked;
        title = document.getElementById('title').value;
        extraction = document.getElementById('extractionCheckbox');
        extractionVal = document.getElementById('extraction');
        type = document.getElementById('typeCheckbox');
        typeVal = document.getElementById('type');
        if (type.checked) {
            typeVal.value = "module";
        } else {
            typeVal.value = "";
        }
        if (extraction.checked) {
            extractionVal.value = "true";
        } else {
            extractionVal.value = "false";
        }
        if (title == "") {
            error.push('Title is required');
        }

        if (js == false && css == false) {
            error.push('At least one of JS or CSS must be selected');
        }

        if (error.length == 0) {
            document.getElementById('choiceBox').submit();

        }
    }

    librarySelect = document.getElementById('libraries');
    libraryValue = librarySelect.options[librarySelect.selectedIndex];
    libraryShowDiv = document.getElementById('libraryShow');
    librarySaveInput = document.getElementById('librariesSave');
    libraryList = librarySaveInput.value.split(',');
    for (let i = 0; i < libraryList.length; i++) {
        if (libraryList[i] != "") {
            let libraryDiv = document.createElement('div');
            libraryDiv.classList.add('library');
            libraryDiv.innerHTML = libraryList[i] +
                '<span style="cursor:pointer;color:grey" class="remove" onclick="removeLibrary(this)"> X</span>';
            libraryShowDiv.appendChild(libraryDiv);
        }


    }
    document.getElementById('addLibrary').addEventListener('click', function() {
        librarySelect = document.getElementById('libraries');
        libraryValue = librarySelect.options[librarySelect.selectedIndex];
        libraryShowDiv = document.getElementById('libraryShow');
        librarySaveInput = document.getElementById('librariesSave');
        libraryList = librarySaveInput.value.split(',');
        if (!libraryList.includes(libraryValue.value)) {
            libraryList.push(libraryValue.value);
            let libraryDiv = document.createElement('div');
            libraryDiv.classList.add('library');
            libraryDiv.innerHTML = libraryValue.text +
                '<span style="cursor:pointer;color:grey" class="remove" onclick="removeLibrary(this)"> X</span>';
            libraryShowDiv.appendChild(libraryDiv);
            librarySaveInput.value = libraryList.join(',');
        }
    });

    function removeLibrary(element) {
        let libraryShowDiv = document.getElementById('libraryShow');
        let librarySaveInput = document.getElementById('librariesSave');
        let libraryList = librarySaveInput.value.split(',');
        let libraryValue = element.parentNode.innerText.replace('X', '').trim();
        libraryList.splice(libraryList.indexOf(libraryValue), 1);
        librarySaveInput.value = libraryList.join(',');
        libraryShowDiv.removeChild(element.parentNode);
    }
    var sortable = function(selector) {
        var el = document.querySelector(selector);
        var sortable = Sortable.create(el, {
            handle: '.handle',
            onEnd: function(evt) {
                let librarySaveInput = document.getElementById('librariesSave');
                let libraryList = librarySaveInput.value.split(',');
                let newLibraryList = [];
                let libraryShowDiv = document.getElementById('libraryShow');
                for (let i = 0; i < libraryShowDiv.children.length; i++) {
                    newLibraryList.push(libraryShowDiv.children[i].innerText.replace('X', '').trim());
                }
                librarySaveInput.value = newLibraryList.join(',');
            }
        });
    }
    </script>
    <div id="ide">
        <center>
            <?php
            if (isset($_POST["title"])) {
?>
            <input type="hidden" id="extractionTrue" name="extraction" value="<?php echo $_POST['extraction']?>">

            <?php            } else {
                $titleIDE = "CodeConnect Config";
            }
            ?>
            <h5 id="fullTitle" style="color:white;margin:0">
                <?php echo ucwords($_POST["title"]);?><?php echo  ($page == "edit" ? " - ".$version : "")?></h5>
            <script>
            <?php 
                if (isset($_POST["title"])) {
                    ?>

            document.getElementsByTagName('title')[0].innerHTML = document.getElementById('fullTitle').innerText +
                " - CodeConnect Editor";

            <?php                
                } else {
                    ?>
            document.getElementsByTagName('title')[0].innerHTML = "<?php echo $titleIDE?> - CodeConnect Config";

            <?php
                }
                ?>
            </script>
            <?php
                //api for this
                if(isset($_POST['librariesSave'])){
                    $libraries = $_POST['librariesSave'];

                    // Turn the title into a list
                    $libraries_list1 = array_filter(array_map('trim', explode(',', $libraries)));
                    // Iterate through the list
                    $libraries_json = array();
                    $libraries_list=json_decode(file_get_contents('./libraries/libraries.json'), true);
                    foreach($libraries_list as $key => $value){
                        foreach($libraries_list1 as $key1 => $value1){
                            if($key==$value1){
                                $libraries_json[] = $value['name'];
                            }
                        }
                    }
                    
                    $listLib= implode(', ', $libraries_json); 
                    
                    ?>
            <p style="color:white;margin:0"><?php echo $listLib ?></p>
            <?php

                }
            ?>
            
        </center>
        <div class="directoryChoice">
                hhh
            </div>
        <?php
        if (!isset($_GET['script_id'])) {
            $id = "jj";
        }else{
            $id = $_GET['script_id'];
        }
        if (!isset($security_id)){
            $security_id = "";
        }
        ?>

        <style>
        .openSidebar {
            width: 20% !important;
            height: 76vh !important;
            background: #282A36;
            position: absolute;
            overflow: scroll !important;
            display: block;
        }

        .sidebarOpened {
            width: 80% !important;
            float: right;
        }

        .assetItem {
            width: 100%;
            background: #282A36;
            border-bottom: 1px solid grey;
            color: white;
        }

        .activeFile {
            background: #44475A;

        }

        .assetItem:hover {
            background: #44475A;
        }

        #sidebar {
            display: none;
            border-radius: 15px;
        }

        input:focus {
            outline: none;
        }
        </style>
        <script>
        function openSidebar() {
            if (document.getElementById('sidebar').style.display == 'block') {
                document.getElementById('sidebar').style.display = 'none';
            } else {
                document.getElementById('sidebar').style.display = 'block';
            }
            document.getElementById('sidebar').classList.toggle('openSidebar');
            document.getElementById('allIDE').classList.toggle('sidebarOpened');
        }

        function searching(elem) {
            if (elem.value.trim().length == 0) {
                document.getElementById('staticAssets').style.display = 'block';
                document.getElementById('sidebarItemsShow').innerHTML = '';

            } else {
                document.getElementById('staticAssets').style.display = 'none';
                //api call to search for asset and then return as json
                //then create a div for each asset
                document.getElementById('sidebarItemsShow').innerHTML = '';
                document.getElementById('sidebarItemsShow').innerHTML += `
                <div class="assetItem">
                <p>Test</p>
            </div>
                `;
            }
        }
        </script>

        <div id="sidebar">
            <div id="fileDetails"></div>

            <br>
            <center style="position:fixed;left:3%;z-index:999">
                <div style="width:100%;background:white;border-radius:50px;padding-top:5px;padding-bottom:5px"
                    id="sidebarSearch">
                    <input style="width:80%;border:none;background:none" role="search" name=""
                        onkeyup="searching(this)">
                </div>
            </center>
            <br>
            <br>

            <div id="staticAssets">
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
                                
                            } else {
                                echo '<div class="columnItem" is_folder="true" status="'.$mainDirectory[3].'" open="false" full_path="' . $dir . $file . '/" onclick="loading(this);" style="display: none;">';
                              
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
                            
                            } else {
                                echo '<div class="columnItem" open="false" status="'.$mainDirectory[3].'" full_path="' . $full_path . '" onclick="loading(this);" style="display: none;">';
                            
                            }
                            
                            for ($i = 0; $i < $depth; $i++) {
                                echo '<div class="verticalLine"></div>';
                            }
                            echo '<p style="padding-left: ' . ($depth * 20) . 'px">' . $file . '</p></div>';
                        }
                    }
                }
            }
            include "./securityCode.php";
            $mainDir = './scripts/'.$_SESSION['uid'].'_assets_' . $scripts_id . '/'; 
            $mainDir1 = 'scripts\/'.$_SESSION['uid'].'_assets_' . $scripts_id;

            outputDirectory($mainDir);
            ?>
            </div>
            <div id="sidebarItemsShow">

            </div>

        </div>
        <div id="allIDE">
            <button onclick="openSidebar()" style="background:none;border:none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                    style="fill: #fff; width: 20px; height: 20px;">
                    <path
                        d="M352 96l64 0c17.7 0 32 14.3 32 32l0 256c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l64 0c53 0 96-43 96-96l0-256c0-53-43-96-96-96l-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32zm-9.4 182.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L242.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z" />
                </svg>
            </button>

            <div id="tabs"> <?php 
            if (isset($_POST["css"])&&isset($_POST["js"])) {
                ?> <a href="#" class="active" id="jsTab" data-tab="js">JavaScript</a>
                <a href="#" data-tab="css" id="cssTab">CSS</a>
                <script>
                window.addEventListener('load', function() {
                    document.getElementById("jsTab").click();
                });
                </script> <?php
            }elseif(isset($_POST["css"])||isset($_POST["js"])){
                if (isset($_POST["js"])) {
                    ?> <a href="#" class="active" id="jsTab" data-tab="js">JavaScript</a>
                <script>
                window.addEventListener('load', function() {
                    document.getElementById("jsTab").click();
                });
                </script> <?php
                }elseif (isset($_POST["css"])){
                    ?> <a href="#" class="active" id="cssTab" data-tab="css">CSS</a>
                <script>
                window.addEventListener('load', function() {
                    document.getElementById("cssTab").click();
                });
                </script> <?php
                }
            }
        ?>
                <script>
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
                                    `API request failed with status ${xhr.status}: ${xhr.statusText}`
                                ));
                            }
                        };
                        xhr.onerror = function() {
                            reject(new Error('API request failed due to a network error.'));
                        };
                        xhr.send(JSON.stringify(data));
                    });
                }

                function autoSaveToggle(code = 0) {
                    // Use "const" instead of "var" for variables that don't need to be reassigned
                    const autoSave = document.getElementById("autoSave");
                    const script_idSave = document.getElementById("script_idSave");
                    if (autoSave.checked) {
                        document.getElementById("saveBtn").style.display = "none";
                        const method = "POST";
                        const baseUrl = window.location.protocol + "//" + window.location.hostname;
                        const url = baseUrl + "/api/private/save_project_js/";
                        const data = {
                            auto_save: "true",
                            api_token: "<?php echo $_SESSION['api_token']?>",
                            uid: "<?php echo $_SESSION['uid']?>",
                        };

                        if (script_idSave.value !== "") { // Check if the script ID is not empty
                            data.script_id = script_idSave.value;
                            data.title = "<?php echo $_POST['title']?>";
                            data.tags = '<?php echo $_POST['tags']?>';
                            data.description = "";
                            data.jsCode = editor.getValue();
                            data.cssCode = editorCss.getValue();
                            data.readme = editorReadme.getValue();
                            data.libraries = '<?php echo $_POST['librariesSave']?>';
                            data.extraction = '<?php echo $_POST['extraction']?>';
                            data.type = "<?php echo $_POST['type']?>";
                        } else {
                            data.title = "<?php echo $_POST['title']?>";
                            data.tags = '<?php echo $_POST['tags']?>';
                            data.description = "";
                            data.jsCode = editor.getValue();
                            data.cssCode = editorCss.getValue();
                            data.readme = editorReadme.getValue();
                            data.libraries = '<?php echo $_POST['librariesSave']?>';
                            data.extraction = '<?php echo $_POST['extraction']?>';
                            data.type = "<?php echo $_POST['type']?>";

                        }

                        function saveScriptId(response) {

                            response = JSON.parse(response);
                            script_idSave.value = response['script_id'];
                            if (<?php echo ($page == "new" ? "true" : "false")?>) {

                                if (code == 2) {
                                    autoSaveToggle(0);
                                } else {
                                    autoSaveToggle(2);
                                }

                                // Create a hidden form element
                                var form = document.createElement("form");
                                form.setAttribute("method", "post");
                                form.setAttribute("action", "edit.php?script_id=" + script_idSave.value);


                                <?php 
                                if (isset($_POST["js"])){
                                    ?>
                                // Add hidden input fields with the PHP values
                                var jsInput = document.createElement("input");
                                jsInput.setAttribute("type", "hidden");
                                jsInput.setAttribute("name", "js");
                                jsInput.setAttribute("value", "<?php echo $_POST["js"]; ?>");
                                form.appendChild(jsInput);
                                <?php
                                }
                                if (isset($_POST["css"])){
                                    ?>
                                // Add hidden input fields with the PHP values
                                var cssInput = document.createElement("input");
                                cssInput.setAttribute("type", "hidden");
                                cssInput.setAttribute("name", "css");
                                cssInput.setAttribute("value", "<?php echo $_POST["css"]; ?>");
                                form.appendChild(cssInput);
                                <?php
                                }

                                if (isset($_POST['title'])) {
                                    ?>
                                // Add hidden input fields with the PHP values
                                var titleInput = document.createElement("input");
                                titleInput.setAttribute("type", "hidden");
                                titleInput.setAttribute("name", "title");
                                titleInput.setAttribute("value", "<?php echo $_POST["title"]; ?>");
                                form.appendChild(titleInput);
                                <?php
                                }

                                if (isset($_POST['extraction'])) {
                                    ?>
                                // Add hidden input fields with the PHP values
                                var extractionInput = document.createElement("input");
                                extractionInput.setAttribute("type", "hidden");
                                extractionInput.setAttribute("name", "extraction");
                                extractionInput.setAttribute("value", "<?php echo $_POST["extraction"]; ?>");
                                form.appendChild(extractionInput);
                                <?php
                                }

                                if (isset($_POST['type'])) {
                                    ?>
                                // Add hidden input fields with the PHP values

                                var typeInput = document.createElement("input");
                                typeInput.setAttribute("type", "hidden");
                                typeInput.setAttribute("name", "type");
                                typeInput.setAttribute("value", "<?php echo $_POST["type"]; ?>");
                                form.appendChild(typeInput);
                                <?php
                                }

                                if (isset($_POST['tags'])) {
                                    ?>
                                // Add hidden input fields with the PHP values

                                var tags = document.createElement("input");
                                tags.setAttribute("type", "hidden");
                                tags.setAttribute("name", "tags");
                                tags.setAttribute("value", "<?php echo $_POST["tags"]; ?>");
                                form.appendChild(tags);
                                <?php
                                }

                                if (isset($_POST['librariesSave'])) {
                                    ?>
                                // Add hidden input fields with the PHP values
                                var libraries = document.createElement("input");
                                libraries.setAttribute("type", "hidden");
                                libraries.setAttribute("name", "librariesSave");
                                libraries.setAttribute("value", "<?php echo $_POST["librariesSave"]; ?>");
                                form.appendChild(libraries);
                                <?php
                                }
                            ?>


                                // Add the form to the page and submit it
                                document.body.appendChild(form);
                                form.submit();
                            }


                        }

                        makeApiRequest(method, url, data)
                            .then(saveScriptId)
                            .catch((error) => console.error(error)); // Removed extra semicolon

                        if (editor.getValue() !== "") {
                            updateScript("js", editor.getValue());
                        }
                        if (editorCss.getValue() !== "") {
                            updateScript("css", editorCss.getValue());
                        }

                        if (editorReadme.getValue() !== "") {
                            updateScript("readme", editorReadme.getValue());
                        }

                    } else {
                        document.getElementById("saveBtn").style.display = "block";
                        const method = "POST";
                        const baseUrl = window.location.protocol + "//" + window.location.hostname;
                        const url = baseUrl + "/api/private/save_project_js/";
                        const data = {
                            script_id: script_idSave.value,
                            auto_save: "false",
                            api_token: "<?php echo $_SESSION['api_token']?>",
                            uid: "<?php echo $_SESSION['uid']?>",
                        };
                        data.title = "<?php echo $_POST['title']?>";
                        data.tags = '<?php echo $_POST['tags']?>';
                        data.description = "";
                        data.jsCode = editor.getValue();
                        data.cssCode = editorCss.getValue();
                        data.readme = editorReadme.getValue();
                        data.libraries = '<?php echo $_POST['librariesSave']?>';
                        data.extraction = '<?php echo $_POST['extraction']?>';
                        data.type = "<?php echo $_POST['type']?>";


                        function saveScriptId(response) {
                            response = JSON.parse(response);
                            script_idSave.value = response['script_id'];
                        }

                        makeApiRequest(method, url, data)
                            .then(saveScriptId)
                            .catch((error) => console.error(error));
                        document.getElementById("saveStatus").innerHTML = "";

                    }
                }

                function updateScript(type, code, all = false) {
                    const autoSave = document.getElementById("autoSave");
                    if (autoSave.checked || all === true) {
                        const data = {
                            script_id: script_idSave.value,
                            auto_save: autoSave.checked.toString(),
                            api_token: "<?php echo $_SESSION['api_token']?>",
                            uid: "<?php echo $_SESSION['uid']?>",
                        };
                        data.all = all.toString();
                        data.title = "<?php echo $_POST['title']?>";
                        data.tags = '<?php echo $_POST['tags']?>';
                        data.description = "";
                        data.jsCode = editor.getValue();
                        data.cssCode = editorCss.getValue();
                        data.readme = editorReadme.getValue();
                        data.libraries = '<?php echo $_POST['librariesSave']?>';
                        data.extraction = '<?php echo $_POST['extraction']?>';
                        data.type = "<?php echo $_POST['type']?>";

                        if (type === "js") {
                            data.jsCode = code;
                        } else if (type === "css") {
                            data.cssCode = code;
                        } else if (type === "readme") {
                            data.readme = code;
                        }
                        const method = "POST";
                        const baseUrl = window.location.protocol + "//" + window.location.hostname;
                        const url = baseUrl + "/api/private/save_project_js/";
                        timeoutId = null

                        function status(response) {
                            response = JSON.parse(response);
                            clearTimeout(timeoutId);

                            if (response['success'] === true) {

                                timeoutId = setTimeout(function() {
                                    if (response['code'] == "1") {
                                        var codeButton = document.getElementById("codeButton");
                                        codeButton.parentNode.removeChild(codeButton);
                                    }
                                    document.getElementById("saveStatus").innerHTML = "Saved";

                                }, 1000);
                            } else {
                                timeoutId = setTimeout(function() {
                                    document.getElementById("saveStatus").innerHTML = "Error";
                                }, 1000);
                            }
                        }

                        document.getElementById("saveStatus").innerHTML = "Saving..."
                        makeApiRequest(method, url, data)
                            .then(status)
                            .catch((error) => console.error());
                    }

                }
                </script>
                <input value="<?php echo (isset($_GET['script_id']) ? $_GET['script_id'] : "")?>" type="hidden"
                    id="script_idSave">
                <?php
                if ($page == "edit"){
                   if ($moduleIDE == "checked"){
                    $moduleIDE = "true";// Refreshes the page immediately
                   }else{
                    $moduleIDE = "false";
                   }
                }elseif($page == "new"){
                    if ($_POST['type'] == "module"){
                        $moduleIDE = "true";
                       }else{
                        $moduleIDE = "false";
                       }
                }
                ?>

                <a href="#" data-tab="readme" id="readmeTab">README.txt</a>
                <div id="test-button-container">
                    <button style="float:right !important;text-align:right;background:none;border:none"
                        onclick="openModal()"><img style="width:20px;padding:0px;" id="test-button"
                            src="./assets/images/play.png" alt="Play Icon" /></button>

                    <button
                        style="float:right !important;margin-right:10px;border-radius:5px;border:solid grey 1px;color:white;background-color:#282A36;font-size:12px;font-weight:bold;width:fit-content;height:30px;padding:5px"
                        onclick="submitForm()" type="button"
                        id="codeButton"><?php echo ($page=="edit"? "Create $versionNew": "Create v1")?></button>
                    <label style="float:right !important; margin-right:10px" class="switch">
                        <input <?php echo $autosaveIDE; ?> id="autoSave" onchange="autoSaveToggle()" type="checkbox">
                        <span class="slider round"></span>
                    </label>
                    <div style="float:right !important; margin-right:10px; color:white">Auto Save:</div>
                    <button id="saveBtn" onclick="saveAll()"
                        style="float:right !important;margin-right:10px;border-radius:5px;border:solid grey 1px;color:white;background-color:#282A36;font-size:12px;font-weight:bold;width:fit-content;height:30px;padding:5px">
                        Save
                    </button>
                    <div style="float:right !important; margin-right:20px; color:white" id="saveStatus"></div>


                </div>
            </div>


            <div id="code-viewer">


                <pre><form id="codeForm" method="post"><input type="hidden" value="<?php echo (isset($_POST["librariesSave"]) ? $_POST["librariesSave"] : ''); ?>" id="editorLibraries" name="librarySave"><input type="hidden" name="projectTitle" value="<?php echo $_POST["title"]?>"><input type="hidden" name="tags" value="<?php echo $_POST["tags"]?>"><div id="js-code" ><textarea id="code" placeholder="Type your code here..."><?php echo $jsCodeIDE?></textarea></div><div id="css-code"><textarea id="codeCss" placeholder="Type your code here..."><?php echo $cssCodeIDE?></textarea></div><div id="readme" ><textarea id="codeReadme" placeholder="Type your code here..."><?php echo $readmeCodeIDE?></textarea></div></form></pre>
            </div>
        </div>

    </div>
    <?php
    if (isset($_POST["title"])) {
        ?> <script>
    document.getElementById("modal").style.display = "none";
    document.getElementById("ide").style.display = "block";
    </script> <?php
    }
    ?> <script>
    function uploadFile(e) {
        e.preventDefault();
        e.stopPropagation();
        const files = e.dataTransfer.files;
        const formData = new FormData();
        const scriptId = document.getElementById('script_idSave').value;
        formData.append('file', files[0]);
        formData.append('api_token', '<?php echo $_SESSION['api_token']; ?>');
        formData.append('uid', '<?php echo $_SESSION['uid']; ?>');
        formData.append('script_id', scriptId);
        formData.append('version', '<?php echo $version ?>');
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/private/drop_file_js/', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                response = JSON.parse(xhr.responseText);
                if (response.success == true) {
                    if (response.type == 'css') {
                        const css = document.getElementById('cssTab');
                        if (css) {

                            location.reload();
                        } else {
                            <?php 
                                if($page == "edit") {
                                ?>
                            window.history.back();
                            <?php
                                }elseif($page == "new"){
                                    ?>
                            window.location.href = 'edit.php?script_id=' + scriptId;
                            <?php
                                }
                                ?>
                        }
                    } else if (response.type == 'js') {
                        const js = document.getElementById('jsTab');
                        if (js) {
                            location.reload();
                        } else {
                            <?php 
                                if($page == "edit") {
                                ?>
                            window.history.back();
                            <?php
                                }elseif($page == "new"){
                                    ?>
                            window.location.href = 'edit.php?script_id=' + scriptId;
                            <?php
                                }
                                ?>
                        }
                    } else {
                        location.reload();
                    }



                }
                // Handle the response from the API
            } else {
                failedUpload(xhr.responseText);
            }
        };

        xhr.send(formData);
    }

    function dragOver(e) {
        e.preventDefault();
        e.stopPropagation();
        e.dataTransfer.dropEffect = 'upload';
    }

    window.onload = function() {


        document.getElementById("css-code").style.display = "none";
    }
    // Get the tabs
    const tabs = document.querySelectorAll('#tabs a');
    // Get the code viewers
    const jsCodeViewer = document.querySelector('#js-code');
    const cssCodeViewer = document.querySelector('#css-code');
    const readmeViewer = document.querySelector('#readme');
    // Add click event listener to tabs
    tabs.forEach(tab => {
        tab.addEventListener('click', e => {
            e.preventDefault();
            // Remove active class from all tabs
            tabs.forEach(tab => tab.classList.remove('active'));
            // Add active class to clicked tab
            tab.classList.add('active');
            // Show the code for the clicked tab
            switch (tab.dataset.tab) {
                case 'js':
                    jsCodeViewer.style.display = 'block';
                    cssCodeViewer.style.display = 'none';
                    readmeViewer.style.display = 'none';
                    break;
                case 'css':
                    jsCodeViewer.style.display = 'none';
                    cssCodeViewer.style.display = 'block';
                    readmeViewer.style.display = 'none';
                    break;
                case 'readme':
                    jsCodeViewer.style.display = 'none';
                    cssCodeViewer.style.display = 'none';
                    readmeViewer.style.display = 'block';
                    break;
            }
        });
    });
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        mode: "javascript",
        theme: "dracula",
        gutters: ["CodeMirror-lint-markers"],
        lint: {
            options: {
                esversion: 2021
            }
        },
        scrollbarStyle: "simple",
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
    editor.setSize(null, 410);
    let timeout = null;

    editor.on("keyup", function(cm) {
        if (timeout) {
            clearTimeout(timeout);
        }
        if (document.getElementById("autoSave").checked) {
            document.getElementById("saveStatus").innerHTML = "Saving...";
            timeout = setTimeout(function() {
                var updatedCode = cm.getValue();
                updateScript("js", updatedCode);
            }, 1000);
        }

    });
    editor.on("dragover", (editor, e) => {
        dragOver(e);
    });

    editor.on("drop", (editor, e) => {
        uploadFile(e);

    });

    //CSS ide
    var editorCss = CodeMirror.fromTextArea(document.getElementById("codeCss"), {
        lineNumbers: true,
        mode: "text/css",
        gutters: ["CodeMirror-lint-markers"],
        lint: {
            options: {
                esversion: 2021
            }
        },
        theme: "dracula",
        scrollbarStyle: "simple",
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
    editorCss.setSize("100%", 400);
    editorCss.on("keyup", function(cm) {
        if (timeout) {
            clearTimeout(timeout);
        }
        if (document.getElementById("autoSave").checked) {
            document.getElementById("saveStatus").innerHTML = "Saving...";
            timeout = setTimeout(function() {
                var updatedCode = cm.getValue();
                updateScript("css", updatedCode);
            }, 1000);
        }

    });

    editorCss.on("dragover", (editorCss, e) => {
        dragOver(e);
    });

    editorCss.on("drop", (editorCss, e) => {
        uploadFile(e);

    });
    //readme ide
    var editorReadme = CodeMirror.fromTextArea(document.getElementById("codeReadme"), {
        lineNumbers: true,
        mode: "text",
        theme: "dracula",
        scrollbarStyle: "simple",
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
    editorReadme.setSize("100%", 400);
    editorReadme.on("keyup", function(cm) {
        if (timeout) {
            clearTimeout(timeout);
        }
        if (document.getElementById("autoSave").checked) {
            document.getElementById("saveStatus").innerHTML = "Saving...";
            timeout = setTimeout(function() {
                var updatedCode = cm.getValue();
                updateScript("readme", updatedCode);
            }, 1000);
        }

    });

    editorReadme.on("dragover", (editorReadme, e) => {
        dragOver(e);
    });

    editorReadme.on("drop", (editorReadme, e) => {
        uploadFile(e);

    });

    function copyToClipboard(text, button, buttonOriginalText = 'Copy') {
        // Create a new hidden textarea element
        const tempInput = document.createElement('textarea');
        tempInput.style.opacity = "0";
        tempInput.style.position = "absolute";
        tempInput.style.left = "-9999px";

        // Set the value of the temporary textarea element to the text to be copied
        tempInput.value = text;

        // Append the temporary textarea element to the document body
        document.body.appendChild(tempInput);

        // Select the text in the temporary textarea element
        tempInput.select();

        // Copy the selected text to the clipboard
        const copySuccessful = document.execCommand('copy');

        // Remove the temporary textarea element from the document body
        document.body.removeChild(tempInput);

        // Change the button text to "code copied"
        button.innerHTML =
            `<svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><polyline points="20 6 9 17 4 12"></polyline></svg> Copied!`;

        // Delay changing the button text back to "copy" by 1 second
        setTimeout(() => {
            button.innerHTML =
                `<svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg> ${buttonOriginalText}`;
        }, 2000);

        // Return true if the copy was successful, false otherwise
        return copySuccessful;
    }

    function submitForm() {
        var code = editor.getValue();
        var codeCss = editorCss.getValue();
        var codeReadme = editorReadme.getValue();
        var editorLibraries = document.getElementById("editorLibraries").value;
        var extraction = document.getElementById("extractionTrue").value
        //Create hidden inputs
        var form = document.getElementById('codeForm');
        var hiddenInput1 = document.createElement("input");
        hiddenInput1.setAttribute("type", "hidden");
        hiddenInput1.setAttribute("name", "code");
        hiddenInput1.setAttribute("value", code);
        form.appendChild(hiddenInput1);
        var hiddenInput2 = document.createElement("input");
        hiddenInput2.setAttribute("type", "hidden");
        hiddenInput2.setAttribute("name", "codeCss");
        hiddenInput2.setAttribute("value", codeCss);
        form.appendChild(hiddenInput2);
        var hiddenInput3 = document.createElement("input");
        hiddenInput3.setAttribute("type", "hidden");
        hiddenInput3.setAttribute("name", "codeReadme");
        hiddenInput3.setAttribute("value", codeReadme);
        form.appendChild(hiddenInput3);
        var hiddenInput3 = document.createElement("input");
        hiddenInput3.setAttribute("type", "hidden");
        hiddenInput3.setAttribute("name", "extraction");
        hiddenInput3.setAttribute("value", extraction);
        form.appendChild(hiddenInput3);
        //Submit the form
        form.submit();
    }
    const modal = document.getElementById('modalRun');
    const closeModal = document.querySelector('.close-modal');

    const iframe = document.getElementById('iframe');
    const link = document.getElementById('link');
    const variables = document.getElementById('variables');
    const go = document.getElementById('go');
    const libraries = document.getElementById('editorLibraries').value;

    function getIframeColor(iframe, iframeDiv1 = iframeDiv) {
        // Access the document inside the iframe
        var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;

        // Get the computed style of the body element inside the iframe
        var bodyStyle = iframeDocument.body.style;
        var backgroundColor = bodyStyle.backgroundColor;

        iframeDiv1.style.backgroundColor = backgroundColor;
    };
    
    let splitValues = [];
    // Split the comma separated list
    let list1 = libraries.split(",");

    // Loop through the list
    for (let i = 0; i < list1.length; i++) {
        // Check if the value is not empty
        if (list1[i] !== "") {
            // Push the value to the array
            splitValues.push(list1[i]);
        }
    }
    // Get the script string
    // Create the inputs for the variables
    // Open the modal
    function openModal() {
        document.getElementById("go").click();
        document.getElementById("modalRun").classList.remove('slide-out');;
        var scriptString = editor.getValue();

        <?php
        if (isset($_POST['extraction']) && $_POST['extraction'] == "true" or $_POST['extraction'] == "1") {
            ?>
        var variablesArray = scriptString.match(/\(\((.*?)\)\)/g);
        if (variablesArray != null) {
            let i = 0;
            variablesArray.forEach(variable => {
                i++;
                var variableName = variable.replace(/[\(\)]/g, '');
                var input = document.createElement('input');
                input.type = 'text';
                input.id = "variable" + i;
                input.classList.add(variableName);
                input.style.marginLeft = "10px";
                input.style.marginRight = "20px";
                variableName = variableName.charAt(0).toUpperCase() + variableName.slice(1) + ": "
                var label = document.createElement('label');
                label.for = variableName;
                label.style.color = "white";
                label.innerText = variableName;
                variables.appendChild(label);
                variables.appendChild(input);
            });
        }
        iframe.src =
            "<?php echo './scripts/' . $_SESSION['uid'] . '_tests_' . $security_id . '/' . $id . '.html'; ?>" +
            '?rand=' + Math.random();;
        let regex = /\(\(([\w\s]+)\)\)/;
        scriptString = scriptString.replace(regex, "$1");
        let i = 1;
        let string = '';
        while (document.getElementById(`variable${i}`)) {
            let element = document.getElementById(`variable${i}`);
            let type = element.className;
            let value = element.value;
            string += `const ${type}='${value}';\n`;
            i++;
        }
        scriptString = string + scriptString;
        <?php
        }else{
            ?>
        iframe.src =
            "<?php echo './scripts/' . $_SESSION['uid'] . '_tests_' . $security_id . '/' . $id . '.html'; ?>" +
            '?rand=' + Math.random();;
        var scriptString = editor.getValue();
        <?php
        }
        ?>

        reloaded = false;
        iframe.onload = () => {

            // Append the script tag to the iframe's innerHTML
            //module
            scriptId = document.getElementById('script_idSave').value;

            moduleSelect = <?php echo $moduleIDE?>;
            if (moduleSelect && scriptId != "") {
                const baseUrl = window.location.protocol + "//" + window.location.hostname;
                const url = baseUrl + "/api/private/module_handle_js/";
                // Set the input parameters
                const apiToken = '<?php echo $_SESSION['api_token']; ?>';
                const uid = '<?php echo $_SESSION['uid']; ?>';
                scriptId = scriptId;
                const moduleOpen = true;
                const jsCode = scriptString;
                // Create the request body JSON object
                const data = {
                    api_token: apiToken,
                    uid: uid,
                    script_id: scriptId,
                    moduleOpen: moduleOpen,
                    jsCode: jsCode
                };
                makeApiRequest("POST", url, data)
                    .then((response) => {})
                    .catch((error) => console.error(error));
                document.getElementById('modules').innerHTML =
                    `<button style="z-index:2;background:none;border:none;color:white" onclick="copyToClipboard(\`` +
                    `import <> from '` +
                    baseUrl +
                    `/scripts/<?php echo $_SESSION['uid']; ?>_private/<?php echo $script_id; ?>/<?php echo $version?>/<?php echo $script_id; ?>.js'` +
                    `\`,this)"><svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg> Copy </button>   <div style="border:solid grey 1px;display:inline-block">import <> from '` +
                    baseUrl +
                    `/scripts/<?php echo $_SESSION['uid']; ?>_private/<?php echo $script_id; ?>/<?php echo $version?>/<?php echo $script_id; ?>.js'</div>`;
                script = document.createElement("script");
                script.type = "module";
                script.textContent = scriptString;
                iframe.contentDocument.body.appendChild(script);

            } else {
                script = document.createElement("script");
                script.textContent = scriptString;
                iframe.contentDocument.body.appendChild(script);
            }

            let css = document.createElement('style');
            css.innerHTML = editorCss.getValue();
            iframe.contentWindow.document.head.appendChild(css);
            getIframeColor(iframe)
        };
        modal.style.display = 'flex';
    }
    // Close the modal
    closeModal.addEventListener('click', () => {
        document.getElementById("modalRun").classList.add('slide-out');
        document.getElementById('variables').innerHTML = '';
        const baseUrl = window.location.protocol + "//" + window.location.hostname;
        const url = baseUrl + "/api/private/module_handle_js/";
        // Set the input parameters
        const apiToken = '<?php echo $_SESSION['api_token']; ?>';
        const uid = '<?php echo $_SESSION['uid']; ?>';
        scriptId = scriptId;
        const moduleOpen = false;

        // Create the request body JSON object
        const data = {
            api_token: apiToken,
            uid: uid,
            script_id: scriptId,
            moduleOpen: moduleOpen
        };
        makeApiRequest("POST", url, data)
            .then((response) => {})
            .catch((error) => console.error(error));
    });
    window.onload = function() {
        document.querySelectorAll("textarea").each(function(el) {
            el.click();
        });
        closeModal.click();
    };
    // Inject the script and CSS into the iframe




    go.addEventListener('click', () => {
        html = test_suite_editor.getValue();
        html = html.replace(/\\/g, "\\\\");
        data = {
            "uid": "<?php echo htmlspecialchars($_SESSION['uid'], ENT_QUOTES) ?>",
            "api_token": "<?php echo htmlspecialchars($_SESSION['api_token'], ENT_QUOTES) ?>",
            "scripts_id": "<?php echo htmlspecialchars($security_id, ENT_QUOTES) ?>",
            "script_id": "<?php echo htmlspecialchars($id, ENT_QUOTES) ?>",
            "html": html
        };
        const baseUrl = window.location.protocol + "//" + window.location.hostname;
        const url = baseUrl + "/api/private/edit_test_suite_js/";
        makeApiRequest("POST", url, data)
            .then((response) => {})
            .catch((error) => console.error(error));
        setTimeout(function() {

            iframe.src =
                "<?php echo './scripts/' . $_SESSION['uid'] . '_tests_' . $security_id . '/' . $id . '.html'; ?>" +
                '?rand=' + Math.random();;
            var scriptString = editor.getValue();
            let regex = /\(\(([\w\s]+)\)\)/;
            scriptString = scriptString.replace(regex, "$1");
            let i = 1;
            let string = '';
            while (document.getElementById(`variable${i}`)) {
                const element = document.getElementById(`variable${i}`);
                const type = element.className;
                const value = element.value;
                string += `const ${type}='${value}';\n`;
                i++;
            }
            scriptString = string + scriptString;

            iframe.onload = () => {
                // Append the script tag to the iframe's innerHTML
                //module
                scriptId = document.getElementById('script_idSave').value;
                moduleSelect = <?php echo $moduleIDE?>;
                if (moduleSelect && scriptId != "") {


                    document.getElementById('modules').innerHTML =
                        `<button style="z-index:2;background:none;border:none;color:white" onclick="copyToClipboard(\`` +
                        `import <> from '` +
                        baseUrl +
                        `/scripts/<?php echo $_SESSION['uid']; ?>_private/<?php echo $script_id; ?>/<?php echo $version?>/<?php echo $script_id; ?>.js'` +
                        `\`,this)"><svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg> Copy </button>   <div style="border:solid grey 1px;display:inline-block">import <> from '` +
                        baseUrl +
                        `/scripts/<?php echo $_SESSION['uid']; ?>_private/<?php echo $script_id; ?>/<?php echo $version?>/<?php echo $script_id; ?>.js'</div>`;

                    script = document.createElement("script");
                    script.type = "module";
                    script.textContent = scriptString;
                    iframe.contentDocument.body.appendChild(script);
                } else {
                    script = document.createElement("script");
                    script.textContent = scriptString;
                    iframe.contentDocument.body.appendChild(script);
                }
                const css = document.createElement('style');
                css.innerHTML = editorCss.getValue();
                iframe.contentWindow.document.head.appendChild(css);
                getIframeColor(iframe)
            };
        }, 1000);
    });
    </script>
    <!-- A loading screen that appears when the form is submitted -->
    <div id="loading-screen">
        <img class="loading-gif" src="./assets/images/loading.gif" alt="Loading...">
    </div>
    <!-- PHP code to handle the form submission -->
    <script>
    window.onload = function() {
        document.querySelector('.loadingScreen').style.display = 'none';
    };
    </script> <?php
 function CallAPI($method, $url, $data = false)
 {
     $curl = curl_init();

     switch ($method)
     {
         case "POST":
             curl_setopt($curl, CURLOPT_POST, 1);

             if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
             break;
         case "PUT":
             curl_setopt($curl, CURLOPT_PUT, 1);
             break;
         default:
             if ($data)
                 $url = sprintf("%s?%s", $url, http_build_query($data));
     }

     // Optional Authentication:
     curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
     curl_setopt($curl, CURLOPT_USERPWD, "username:password");

     curl_setopt($curl, CURLOPT_URL, $url);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

     $result = curl_exec($curl);

     curl_close($curl);

     return $result;
 }
// Check to see if all of $_POST["code"], $_POST["codeCss"], and $_POST["codeReadme"] are set
    // Check that all required POST variables are set
    if ($page=="edit") {
        if (isset($_POST["code"], $_POST["codeCss"], $_POST["codeReadme"], $_POST["projectTitle"], $_POST["tags"], $_POST["librarySave"])) {

         // Set API token
         $api_token = $_SESSION['api_token'];
         // Set script ID
         $script_id = $_GET['script_id'];
         echo $_POST["librarySave"];
         // Set data array
         $data = array(
             'api_token' => $api_token,
             'script_id' => $script_id,
             'js_code' => $_POST["code"],
             'css_code' => $_POST["codeCss"],
             'readme' => $_POST["codeReadme"],
             'title' => $_POST["projectTitle"],
             'description' => "",
             'tags' => $_POST["tags"],
             'libraries' => $_POST["librarySave"],
             'extraction' => $_POST["extraction"],
         );
         $url=$website."/api/update/";
         // Call API
         $response = CallAPI('POST', $url, $data);
         $response=json_decode($response,true);
            if ($response['success']=="true"){
                ?>
    <script>
    window.location.href = "./edit.php?script_id=<?php echo $script_id; ?>";
    </script>
    <?php
            }
                
        }
    }elseif ($page=="new") {
        if (isset($_POST["code"], $_POST["codeCss"], $_POST["codeReadme"], $_POST["projectTitle"], $_POST["tags"], $_POST["librarySave"])) {
           
            $api_token = $_SESSION['api_token'];
            $data = array(
                'api_token' => $api_token,
                'title' => $_POST["projectTitle"],
                'tags' => $_POST["tags"],
                'description' => '',
                'js_code' => $_POST["code"],
                'css_code' => $_POST["codeCss"],
                'readme' => $_POST["codeReadme"],
                'libraries' => $_POST["librarySave"],
                'extraction' => $_POST["extraction"],
            );
            $url=$website."/api/create/";
            $response=CallAPI("POST", $url, $data);
            $response=json_decode($response,true);
            if ($response['success']=="true"){
                ?>
    <script>
    window.location.href = "./scripts.php";
    </script>
    <?php
            }
                
            
            
        }
    }
       
?> <script>
    function saveAll() {
        updateScript("readme", editorReadme.getValue(), true);

    }
    window.addEventListener("load", function() {
        <?php

        if ($page=="edit"){
            ?>
        autoSaveToggle();
        document.querySelector(".loadingScreen").style.display = "none";

        <?php
        }elseif ($page=="new"){
            ?>

        autoSaveToggle(1);
        document.querySelector(".loadingScreen").style.display = "block";

        <?php
        }
        ?>

    });
    </script>
    <?php
            if (isset($_POST['title'])){
                ?>
    <script>
    updateScript("readme", editorReadme.getValue());
    </script>

    <?php
            }
            ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.korzh.com/metroui/v4.5.1/js/metro.min.js"></script>
    <script>
    document.addEventListener('keydown', function(e) {
        if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
            e.preventDefault();
        }
        if (e.ctrlKey && e.key === "s") {
            e.preventDefault();
            saveAll();
        }
    }, false);

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
        consoleLogPath(elem);

    }


    function consoleLogPath(elem) {
        status = elem.getAttribute('status');
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
        paths = []
        for (let i = 0; i < pathInf.length; i++) {
            if (i == 0) {
                paths[i] = pathInf[i];
            } else {
                paths[i] = paths[i - 1] + "/" + pathInf[i];
            }
        }



        for (let i = 0; i < pathInf.length; i++) {

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

            } else {

                fileName = fileName[fileName.length - 1];
                ext = fileName.split('.');
                ext = ext[ext.length - 1];



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

        } else if (status == 'private') {


        }




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
                if (contents['success'] && contents['ext'] === 'pdf') {} else if (contents['success']) {

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
                    editor.setSize("100%", 400);
                } else {}
            };
            makeApiRequest(method, url, data)
                .then(contents)
                .catch((error) => console.error(error));
        } else if (isImage(elemPath)) {
            if (elem.getAttribute('status') == 'private') {


            } else if (elem.getAttribute('status') == 'public') {

            }

        } else if (isVideo(elemPath)) {
            if (elem.getAttribute('status') == 'private') {

            } else if (elem.getAttribute('status') == 'public') {

            }

        } else {}
        exist = false;
        elem.open = !elem.open;
        items = [];
        elemsWithFullPath.forEach(elem1 => {
            if (elem1.getAttribute('full_path') === elemPath) {
                elem1.classList.add('activeFile');

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

            folderContents = document.querySelectorAll('.folderContents');

            folderContents.forEach((element) => {
                element.removeEventListener('click', () => {
                    activeIcon(element);
                });
                element.addEventListener('click', () => {
                    activeIcon(element);
                });


            });

        } else if (elem.getAttribute('is_folder')) {


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


                    });
                }
            });
        });
        if (elem.getAttribute('recent') == "true") {
            elem.remove();
        }
    }
    // Get the necessary elements
    const columnItems = document.querySelectorAll('.columnItem');
    const fileDetails = document.querySelector('#fileDetails');

    // Add event listeners to each columnItem
    columnItems.forEach(columnItem => {
        columnItem.addEventListener('click', () => {
            fileDetails.innerHTML = '';
            // Set the position of the fileDetails div to be next to the hovered columnItem
            fileDetails.style.position = 'fixed';
            fileDetails.style.left = `${columnItem.offsetLeft + columnItem.offsetWidth + 5}px`;
            fileDetails.style.top = 150 + 'px';
            fileDetails.style.width = '300px';
            fileDetails.style.maxHeight = '75vh';
            fileDetails.style.backgroundColor = '#282A36';
            fileDetails.style.border = '1px solid black';
            fileDetails.style.borderRadius = '15px';
            fileDetails.style.padding = '10px';
            fileDetails.style.zIndex = '999';
            fileDetails.style.color = 'white';
            fileDetails.style.overflowX = 'hidden';
            fileDetails.style.overflowY = 'scroll';
            baseUrl = window.location.protocol + "//" + window.location.hostname;
            linkCopy = "";
            status = privElem.split("/")[0];
            fileName = columnItem.innerText;
            loadingIcon = document.createElement('img');
            loadingIcon.marginTop = 50 + 'px';
            loadingIcon.src = baseUrl + '/assets/images/miniLoader.gif';
            loadingIcon.style.width = '100%';
            fileDetails.appendChild(loadingIcon);
            show = document.createElement('div');
            show.style.width = '100%';
            show.style.margin = 'auto';
            show.style.display = 'none';
            fileDetails.appendChild(show);
            if (status == "private") {
                if (isImage(privElem)) {
                    imgDiv = document.createElement('div');
                    imgDiv.style.width = '100%';
                    imgDiv.style.margin = 'auto';
                    img = document.createElement('img');
                    img.style.borderRadius = '15px';
                    img.style.maxWidth = '100%';
                    img.style.maxHeight = '50vh';
                    img.src = baseUrl + '/user_assets/image.php?v=' + encodeURIComponent(privElem);
                    imgDiv.appendChild(img);
                    imgDiv.style.display = 'none';
                    linkCopy = img.src;
                    img.addEventListener('load', () => {
                        fileDetails.removeChild(loadingIcon);
                        imgDiv.style.display = 'block';

                    });
                    fileDetails.appendChild(imgDiv);


                } else if (isVideo(privElem)) {
                    vid = document.createElement('video');
                    vid.style.borderRadius = '15px';
                    vid.style.maxWidth = '100%';
                    vid.style.maxHeight = '50vh';
                    vid.src = baseUrl + '/user_assets/video.php?v=' + encodeURIComponent(privElem);
                    linkCopy = vid.src;
                    vid.controls = true;
                    fileDetails.appendChild(vid);
                    fileDetails.removeChild(loadingIcon);

                } else {
                    fileDetails.removeChild(loadingIcon);
                }
            } else {
                if (isImage(privElem)) {
                    imgDiv = document.createElement('div');
                    imgDiv.style.width = '100%';
                    imgDiv.style.margin = 'auto';
                    img = document.createElement('img');
                    img.style.borderRadius = '15px';
                    img.style.maxWidth = '100%';
                    img.style.maxHeight = '50vh';
                    img.src = baseUrl +
                        '/scripts/<?php echo $_SESSION['uid']?>_assets_<?php echo $scripts_id?>/' +
                        privElem;
                    imgDiv.appendChild(img);
                    imgDiv.style.display = 'none';
                    linkCopy = img.src;
                    img.addEventListener('load', () => {
                        fileDetails.removeChild(loadingIcon);
                        imgDiv.style.display = 'block';

                    });
                    fileDetails.appendChild(imgDiv);


                } else if (isVideo(privElem)) {
                    vid = document.createElement('video');
                    vid.style.borderRadius = '15px';
                    vid.style.maxWidth = '100%';
                    vid.style.maxHeight = '50vh';
                    vid.src = baseUrl +
                        '/scripts/<?php echo $_SESSION['uid']?>_assets_<?php echo $scripts_id?>/' +
                        privElem;
                    linkCopy = vid.src;
                    vid.controls = true;
                    fileDetails.appendChild(vid);
                    fileDetails.removeChild(loadingIcon);

                } else {
                    fileDetails.removeChild(loadingIcon);
                }
            }
            button = document.createElement('button');
            button.innerHTML =
                `<svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg> Copy Link`;
            button.style.backgroundColor = '#44475A';
            button.style.color = 'white';
            button.style.border = 'solid 1px grey';
            button.style.borderRadius = '5px';
            button.style.padding = '5px';
            button.style.margin = '5px';
            button.style.fontSize = '15px';
            button.addEventListener('click', () => {
                copyToClipboard(linkCopy, button, "Copy Link")
            });
            fileDetails.insertBefore(button, fileDetails
                .firstChild); // Add the button as the first child

            // Set the innerHTML of the fileDetails div to be the innerHTML of the hovered columnItem
            p = document.createElement('p');
            p.innerHTML = fileName;
            p.style.fontSize = '20px';
            p.style.fontWeight = 'bold';
            p.style.margin = '5px';
            p.style.wordBreak = 'break-all';
            fileDetails.appendChild(p);
            fileDetails.style.display = 'block';

        });

    });


    // Get the sidebar element
    const sidebar = document.querySelector('#sidebar');

    // Add a click event listener to the document
    document.addEventListener('click', (event) => {
        // Check if the clicked element is inside the sidebar element
        if (!sidebar.contains(event.target) && !event.target.classList.contains('activeFile')) {
            // The clicked element is not inside the sidebar, so do something
            // For example, you can hide the sidebar:
            fileDetails.innerHTML = '';
            if (document.querySelector('.activeFile')) {
                document.querySelector('.activeFile').classList.remove('activeFile');
            }
            fileDetails.style.display = 'none';
        } else if (event.target.getAttribute('is_folder')) {
            // The clicked element is not inside the sidebar, so do something
            // For example, you can hide the sidebar:
            fileDetails.innerHTML = '';
            if (document.querySelector('.activeFile')) {
                document.querySelector('.activeFile').classList.remove('activeFile');
            }
            fileDetails.style.display = 'none';
        }
    });
    </script>

</body>

</html>