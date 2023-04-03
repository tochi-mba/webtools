
 
  <div class="card" style="box-shadow: 0px var(--card-box-shadow-1-y) var(--card-box-shadow-1-blur) var(--card-box-shadow-1), 0px var(--card-box-shadow-2-y) var(--card-box-shadow-2-blur) var(--card-box-shadow-2), 0 0 0 1px rgba(<?php echo $color;?>, 0.5);">
   
    <h3 style="z-index:2"><?php echo $project['title']?></h3>

    <h4 style="font-size:15px"><?php echo $project['script_id']?></h4>

    <div style="width:100%;height:fit-content;z-index:2">
<?php
$dir = './assets/images/libraries/';
foreach ($libraries as $key => $value) {
    if (file_exists($dir . $libraries[$key].".png")) {
        echo '<img src="' . $dir . $libraries[$key].'.png" style="display: inline-block;height:50px" />';
    }
}


?>
    </div>
    <?php
    if ($project['tags'] != "") {
        ?>
            <p>Tags: <?php echo $project['tags']?></p>

        <?php
    }
    ?>

    <div class="projectBtns" style="width:100%;height:fit-content;z-index:2">
    <form action="edit.php" method="get">
        <input type="hidden" value="<?php echo $project['script_id']?>" name="script_id">
        <button>Edit</button>

    </form>
    <?php 
    if (file_exists('./scripts/'.$_SESSION['uid']."_private/".$project['script_id']."/".$version."/".$project['script_id'].".js")){
        $code=file_get_contents('./scripts/'.$_SESSION['uid']."_private/".$project['script_id']."/".$version."/".$project['script_id'].".js");
        require "./get_params.php";
    }
    ?>
    <form action="delete.php" method="post">
        <input type="hidden" value="<?php echo $project['script_id']?>" name="script_id">
        <input type="hidden" name="name" value="<?php echo $project['title']?>">
        <button>Delete</button>
    </form>
</div>
    <div style="position:absolute;top: 10px;right:10px;z-index:2" >
      <div class="versionTags" style="background-color:<?php echo $versionNumberColors[$version]?>"><?php echo $version?></div>
    </div>
    <div id="<?php echo $project['script_id']?>" style="position:absolute;bottom: 10px;right:10px;z-index:2;pointer:cursor" >
<img style="width:40px" src="./assets/images/embed.png" alt="" srcset="">   
 </div>
 <script>
    document.getElementById('<?php echo $project['script_id']?>').addEventListener('click', function(){
        embedModal(`<?php echo $project['active_files']?>`,`<?php echo $project['version']?>`,`<?php echo $project['script_id']?>`,`<?php echo $project['title']?>`,`<?php echo $_SESSION['uid']?>`,`<?php echo $project['libraries']?>`,`<?php echo $versionNumberColors[$version]?>`<?php echo (isset($resultParams) ? ",`".json_encode($resultParams)."`" : ",`"."[]"."`")?>);
    })
 </script>
    <div class="background">
      <div class="tiles">
        <div class="tile tile-1" style="background-color:rgba( <?php echo $color;?>,0.05)"></div>
        <div class="tile tile-2" style="background-color:rgba( <?php echo $color;?>,0.05)"></div>
        <div class="tile tile-3" style="background-color:rgba( <?php echo $color;?>,0.05)"></div>
        <div class="tile tile-4" style="background-color:rgba( <?php echo $color;?>,0.05)"></div>

        <div class="tile tile-5" style="background-color:rgba( <?php echo $color;?>,0.05)"></div>
        <div class="tile tile-6" style="background-color:rgba( <?php echo $color;?>,0.05)"></div>
        <div class="tile tile-7" style="background-color:rgba( <?php echo $color;?>,0.05)"></div>
        <div class="tile tile-8" style="background-color:rgba( <?php echo $color;?>,0.05)"></div>

        <div class="tile tile-9" style="background-color:rgba( <?php echo $color;?>,0.05)"></div>
        <div class="tile tile-10" style="background-color:rgba( <?php echo $color;?>,0.05)"></div>
      </div>

      <div class="line line-1"></div>
      <div class="line line-2"></div>
      <div class="line line-3"></div>
    </div>
  </div>
