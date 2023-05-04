<style>
  .nvbar {
  position: fixed;
  top: 0;
  left: 0;
  width: 99%;
  background: none;
  color: white;
  padding: 10px;
  z-index: 200;
  font-family: 'Roboto Mono', monospace;
  margin-bottom: 10px;
}

.nvbar a {
  float: left;
  color: white;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  line-height: 25px;
  border-radius: 4px;
}

.nvbar a.right {
  float: right !important;
}

.nvbar a:hover {
  background-color: #ddd;
  color: black;
}
</style>

<nav class="nvbar">
        <a href="../">Home</a>
        <?php if(isset($_SESSION['uid'])) { ?>
          <a href="../new_script.php">New Project</a>
          <a href="../scripts.php">My Projects</a>
          <a href="../docs/">Docs</a>
          <a href="../profile.php" class="right">Profile</a>
          <a href="../logout.php" class="right">Logout</a>
        <?php } else { ?>
          <a href="../docs/">Docs</a>
        <a href="../login.php" class="right">Login</a>
        <a href="../register.php" class="right">Register</a>
        <?php }?>
        
        </nav>





<div style="margin-bottom:55px" ></div> 
<script>
  document.head.innerHTML += '<link rel="icon" type="image/png" href="../assets/images/logo.png">';
</script>


