<?php 

require "head.php"; 
require "is_logged.php";

?>
<html>
<head>
<title>Scripts by Title</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<style>
body {
  background-color: #444;
  color: #eee;
  font-family: sans-serif;
  font-size: 1rem;
  margin: 0;
  padding: 0;
  overflow-x: hidden;

}

div.userinfo {
  background-color: #777;
  padding: 1rem;
  text-align: center;
}

div.userinfo h1 {
  font-size: 1rem;
  font-weight: 300;
  margin: 0;
  padding: 0;
}

div.userinfo h2 {
  font-size: 0.9rem;
  font-weight: 300;
  margin: 0;
  padding: 0;
}

div.scriptlist {
  display: flex;
  flex-wrap: wrap;
}

div.scriptlist div {
  background-color: #555;
  border: 1px solid #999;
  padding: 1rem;
  margin: 0.5rem;
  width: 100%;
  min-width: 200px;
  box-sizing: border-box;
}

div.scriptlist div h1 {
  color: #eee;
  font-size: 1rem;
  font-weight: 300;
  margin: 0;
  padding: 0;
}

div.scriptlist div p {
  color: #eee;
  font-size: 0.9rem;
  font-weight: 300;
  margin: 0;
  padding: 0;
}

div.scriptlist div form {
  display: flex;
  justify-content: space-between;
  margin: 0.5rem 0 0 0;
  padding: 0;
}

div.scriptlist div form input {
  background-color: #999;
  border: none;
  color: #eee;
  font-size: 0.8rem;
  padding: 0.2rem;
}
</style>
</head>
<body>
<?php require "connect.php";
    require "navbar.php";
    if (isset($_GET["delete"],$_GET["id"])) {
      if ($_GET["delete"]==="1") {
        ?>
        <center><h3>Succesfully Deleted: <?php echo $_GET["name"];?></h3></center>
        <center><p>Id: <?php echo $_GET["id"];?></p></center>

        <?php
      }
    }
    $uid=$_SESSION["uid"];
    $sql = "SELECT username FROM users WHERE uid = '$uid'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username= $row['username'];
    } else {
    }
    ?>
   <style>
  .nvbar {
          position:relative;
        }
</style>
  <div class="userinfo">
    <h1>User: <?php echo  $username;?></h1>
    <h2>Scripts By Title</h2>
  </div>
    <?php 
    $sql = "SELECT * FROM scripts WHERE uid = '$uid'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      ?>
      <div class="row">
      <?php
        while($row = $result->fetch_assoc()) {
            $title = $row['title'];
            $script_id = $row['script_id'];
            $json = $row['active_files'];
            $array = json_decode($json, true);

            if ($array['code'] == 'active' && $array['codeCss'] == 'active') {
                $contains= "Js and Css";
            } elseif ($array['code'] == 'empty' && $array['codeCss'] == 'active') {
              $contains= "Css only";
            } elseif ($array['code'] == 'active' && $array['codeCss'] == 'empty') {
              $contains= "Js only";
            }
            ?>
            <div class="scriptlist col-6">
            <div>
            <h1><?php echo ucwords($title); ?></h1>
            <p>Script ID: <?php echo $script_id; ?></p>
            <p><?php echo $contains ?></p>

            <form action="edit.php" method="GET">
                <input type="hidden" name="script_id" value="<?php echo $script_id; ?>">
                <input type="submit" value="Edit">
            </form>
            <form action="delete.php" method="POST">
                <input type="hidden" name="script_id" value="<?php echo $script_id; ?>">
                <input type="hidden" name="name" value="<?php echo ucwords($title); ?>">
                <input type="submit" value="Delete">
            </form>
            <form action="headcode.php" method="POST">
                <input type="hidden" name="script_id" value="<?php echo $script_id; ?>">
                <input type="hidden" name="user" value="<?php echo $_SESSION['uid']; ?>">

                <input type="submit" value="Generate Headcode">
            </form>
            </div>
            </div>
            <?php
        }
    } else {
        ?>
        <div style="display: flex; justify-content: center; align-items: center; height: 100vh; font-family: 'Roboto Mono', monospace;">You have 0 scripts. Start creating!</div>

        <?php
    }
    
    ?>
    
  </div>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>