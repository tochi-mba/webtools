<?php
session_start(); 
?>
<html>
    <head>
        <title>My Page</title>    
        <script src="../codemirror/lib/codemirror.js"></script>
        <link rel="stylesheet" href="../codemirror/lib/codemirror.css">
    </head>
    <body>
    <?php
//check if form is submitted
if(isset($_POST['submit'])){
    //open file in write mode
    $fp = fopen('./users/'.$_SESSION['uid'].'.php', 'w');
    //write the contents of the form
    fwrite($fp, $_POST['code']);
    //close the file
    fclose($fp);
}
?>
        <div style="margin:20px;position:relative" id="container">
            <form style="width:50% !important;margin:none !important;" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <textarea onkeyup="change()" id="code" name="code" cols="50" rows="10"><?php
                    //open the file in read mode
                    $fp = fopen('./users/'.$_SESSION['uid'].'.php', 'r');
                    //read the contents of the file
                    $contents = fread($fp, filesize('./users/'.$_SESSION['uid'].'.php'));
                    //close the file
                    fclose($fp);
                    //echo the contents
                    echo htmlspecialchars($contents);
                ?></textarea>
                <input style="visibility:hidden" id="updateBtn" type="submit" value="Save" name="submit">
            </form>
            <div style="border:solid black 1px;width:45%;position:absolute;top:0;right:0;height:100%">
<iframe id="iframe" src="./index.php" style="width:100%;height:100%" frameborder="0"></iframe>
            </div>
        </div>
    </body>
    <script>
        // create a codemirror instance
        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
          lineNumbers: true,
          mode:  "htmlmixed"
        });
        editor.setSize(null, 510);
        document.addEventListener("keyup", function(event) {
            console.log("hi mary murphy")
            document.getElementById("iframe").contentWindow.document.body.innerHTML = editor.getValue();
            document.getElementById("updateBtn").style.visibility = "visible";
        });
    </script>
</html>

