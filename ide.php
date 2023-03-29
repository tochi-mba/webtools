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
        background: #1E1F1F !important;
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
        background-color: #1E1F1F;
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
        background-color: #1E1F1F;
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
        padding-bottom: 0
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
        background: #1E1F1F;
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
    </style>
    <div class="modal" style="height:100%" id="modalRun">
        <div style="height:100%" class="modal-content">
            <div style="background-color:#1E1F1F;color:white">
                <span style="cursor:pointer;font-size:30px;padding:0;width:fit-content;height:fit-content"
                    class="close-modal">&times;</span>
                <div style="float:right; display:inline;margin:0;margin-right:20px;top:20%" id="variables"></div>

            </div>
            <iframe id="iframe" width="100%" height="100%"></iframe>

            </script>
            <div class="input-container" style="background-color:#1E1F1F">
                <button style="border-radius:5px;width:fit-content;padding:5px;margin-top:10px;margin-bottom:10px"
                    type="button" onclick='window.open("./test_suite/edit.php", "_blank");'>Edit Test Suite</button>
                <button style="border-radius:5px;width:fit-content;padding:5px" id="go">Go</button>
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
            <input style="" type="checkbox" <?php echo $jsIDE?> name="js" id="jsCheckbox">
            <label style="font-size:12px;color:white;margin-left:3px" for="js">Include JS?</label>
            <br>
            <br>
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
                type="button" onclick="document.getElementById('choiceBox').submit();">Next</button>

        </form>
    </div>
    <script>
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
            <h5 style="color:white;margin:0"><?php echo ucwords($_POST["title"]);?></h5>
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
        ?> <a href="#" data-tab="readme" id="readmeTab">README</a> # <div id="test-button-container">
                <button style="float:right !important;text-align:right;background:none;border:none"
                    onclick="openModal()"><img style="width:20px;padding:0px;" id="test-button"
                        src="./assets/images/play.png" alt="Play Icon" /></button>
                <button
                    style="float:right !important;margin-right:10px;border-radius:5px;border:solid grey 1px;color:white;background-color:#282A36;font-size:12px;font-weight:bold;width:60px;height:30px"
                    onclick="submitForm()" type="button"
                    id="codeButton"><?php echo ($page=="edit"? "Update": "Create")?></button>

            </div>
        </div>
        <div id="code-viewer">
            <pre><form id="codeForm" method="post"><input type="hidden" value="<?php echo (isset($_POST["librariesSave"]) ? $_POST["librariesSave"] : ''); ?>" id="editorLibraries" name="librarySave"><input type="hidden" name="projectTitle" value="<?php echo $_POST["title"]?>"><input type="hidden" name="tags" value="<?php echo $_POST["tags"]?>"><div id="js-code" ondrop="handleDrop(event)" ondragover="handleDragOver(event)"><textarea id="code" placeholder="Type your code here..."><?php echo $jsCodeIDE?></textarea></div><div id="css-code" ondrop="handleDrop(event)" ondragover="handleDragOver(event)"><textarea id="codeCss" placeholder="Type your code here..."><?php echo $cssCodeIDE?></textarea></div><div id="readme" ondrop="handleDrop(event)" ondragover="handleDragOver(event)"><textarea id="codeReadme" placeholder="Type your code here..."><?php echo $readmeCodeIDE?></textarea></div></form></pre>
        </div>

    </div> <?php
    if (isset($_POST["title"])) {
        ?> <script>
    document.getElementById("ide").style.display = "block";
    document.getElementById("modal").style.display = "none";
    </script> <?php
    }
    ?> <script>
    document.getElementById("title").onkeyup = function() {
        let title = document.getElementById("title").value;
        let titleShow = document.getElementById("titleShow");
        let words = title.split(" ");
        let capitalizedWords = words.map(word => word.charAt(0).toUpperCase() + word.slice(1));
        titleShow.innerHTML = capitalizedWords.join(" ");
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

    function handleDrop(e) {
        e.stopPropagation();
        e.preventDefault();
        var files = e.dataTransfer.files;
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("code").value = e.target.result;
        }
        reader.readAsText(files[0]);
    }

    function handleDragOver(e) {
        e.stopPropagation();
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
    }
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
    editorCss.setSize(null, 410);

    function handleDrop(e) {
        e.stopPropagation();
        e.preventDefault();
        var files = e.dataTransfer.files;
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("codeCss").value = e.target.result;
        }
        reader.readAsText(files[0]);
    }

    function handleDragOver(e) {
        e.stopPropagation();
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
    }
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
    editorReadme.setSize(null, 410);

    function handleDrop(e) {
        e.stopPropagation();
        e.preventDefault();
        var files = e.dataTransfer.files;
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("codeReadme").value = e.target.result;
        }
        reader.readAsText(files[0]);
    }

    function handleDragOver(e) {
        e.stopPropagation();
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
    }

    function submitForm() {
        var code = editor.getValue();
        var codeCss = editorCss.getValue();
        var codeReadme = editorReadme.getValue();
        var editorLibraries = document.getElementById("editorLibraries").value;
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
        var scriptString = editor.getValue();
        // Get the variables from the script string
        var variablesArray = scriptString.match(/\(\((.*?)\)\)/g);
        console.log(variablesArray);
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
        iframe.src = "./test_suite/index.php";
        var scriptString = editor.getValue();
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

        iframe.onload = () => {
            // Append the script tag to the iframe's innerHTML
            iframe.contentWindow.eval(scriptString);
            let css = document.createElement('style');
            css.innerHTML = editorCss.getValue();
            iframe.contentWindow.document.head.appendChild(css);
        };
        modal.style.display = 'block';
    }
    // Close the modal
    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
        document.getElementById('variables').innerHTML = '';
    });
    window.onload = function() {
        closeModal.click();
    };
    // Inject the script and CSS into the iframe
    go.addEventListener('click', () => {
        iframe.src = "./test_suite/index.php";
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
            iframe.contentWindow.eval(scriptString);
            const css = document.createElement('style');
            css.innerHTML = editorCss.getValue();
            iframe.contentWindow.document.head.appendChild(css);
        };
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
             'libraries' => $_POST["librarySave"]
         );
         $url=$website."/api/edit/";
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
                'libraries' => $_POST["librarySave"]
            );
            $url=$website."/api/create/";
            $response=CallAPI("POST", $url, $data);
            $response=json_decode($response,true);
            if ($response['success']=="true"){
                ?>
    <script>
    window.location.href = "scripts.php";
    </script>
    <?php
            }
                
            
            
        }
    }
       
?> <script>
    window.addEventListener("load", function() {
        document.querySelector(".loadingScreen").style.display = "none";
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.korzh.com/metroui/v4.5.1/js/metro.min.js"></script>
    <script>
        document.addEventListener('keydown', function(e) {
            if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
                e.preventDefault();
            }
        }, false);
    </script>
</body>

</html>