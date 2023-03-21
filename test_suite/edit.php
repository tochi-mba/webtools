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
    //echo success message
    echo 'Saved!';
}
?>
        <div id="container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <textarea id="code" name="code" cols="50" rows="10"><?php
                    //open the file in read mode
                    $fp = fopen('./users/'.$_SESSION['uid'].'.php', 'r');
                    //read the contents of the file
                    $contents = fread($fp, filesize('./users/'.$_SESSION['uid'].'.php'));
                    //close the file
                    fclose($fp);
                    //echo the contents
                    echo htmlspecialchars($contents);
                ?></textarea>
                <input type="submit" value="Save" name="submit">
            </form>
        </div>
    </body>
    <script>
        // create a codemirror instance
        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
          lineNumbers: true,
          mode:  "htmlmixed"
        });
    </script>
</html>

