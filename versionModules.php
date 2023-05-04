<div class="card"
    style="position:relative;box-shadow: 0px var(--card-box-shadow-1-y) var(--card-box-shadow-1-blur) var(--card-box-shadow-1), 0px var(--card-box-shadow-2-y) var(--card-box-shadow-2-blur) var(--card-box-shadow-2), 0 0 0 1px rgba(<?php echo $colorBorder;?>, 0.5);">

    <?php
    if (!$current){
        ?>
    <span
        style="position:absolute;top:0px;right:10px;float:right;font-size:30px;cursor:pointer;z-index:999;color:white;">&#8942;</span>

    <?php
    }
        $libraries=$detail['libraries'];
        $libraries=explode(",",$libraries);
        $libraries=array_filter($libraries);

    ?>
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
    <p>
        Created: <?php echo formatDate($detail['creation_date']) ?>
    </p>
    <?php
        if ($current){
            ?>
    <p class="neon">Currently in development</p>

    <?php
        }else{
            ?>
    <p>
        Last Edited: <?php echo formatDate($detail['last_edited']) ?>
    </p>
    <?php
        }

?>

    <div style="position:absolute;top: 10px;left:10px;z-index:2">
        <div class="versionTags" style="background-color:<?php echo $color?>">
            <?php echo $version?></div>
    </div>
    <div class="shine" ></div>
    <div class="background">
        <div class="tiles">
            <div class="tile tile-1" style="background-color:rgba( <?php echo $colorBorder;?>,0.05)"></div>
            <div class="tile tile-2" style="background-color:rgba( <?php echo $colorBorder;?>,0.05)"></div>
            <div class="tile tile-3" style="background-color:rgba( <?php echo $colorBorder;?>,0.05)"></div>
            <div class="tile tile-4" style="background-color:rgba( <?php echo $colorBorder;?>,0.05)"></div>

            <div class="tile tile-5" style="background-color:rgba( <?php echo $colorBorder;?>,0.05)"></div>
            <div class="tile tile-6" style="background-color:rgba( <?php echo $colorBorder;?>,0.05)"></div>
            <div class="tile tile-7" style="background-color:rgba( <?php echo $colorBorder;?>,0.05)"></div>
            <div class="tile tile-8" style="background-color:rgba( <?php echo $colorBorder;?>,0.05)"></div>

            <div class="tile tile-9" style="background-color:rgba( <?php echo $colorBorder;?>,0.05)"></div>
            <div class="tile tile-10" style="background-color:rgba( <?php echo $colorBorder;?>,0.05)"></div>
        </div>

        <div class="line line-1"></div>
        <div class="line line-2"></div>
        <div class="line line-3"></div>
    </div>
</div>