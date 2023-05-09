<?php 

$sql = "SELECT tags FROM scripts";
$result = mysqli_query($conn, $sql);
$tags = array();
while($row = mysqli_fetch_assoc($result)){
    $tag = strtolower($row['tags']);
    $tag = explode(",", $tag);
    foreach($tag as $t){
            if($t == $tag ){
                $tags[$t] = $tags[$t] + 1;
            }
            else if ($t != ""){
                $tags[$t] = 1;
            }
        
    }
}
arsort($tags);
$i = 0;
foreach ($tags as $key => $value) {
    if($i == 13){
        break;
    }
    ?>
<div class="tab">
    <?php echo ucwords($key); ?>
</div>
<?php
    $i++;
}


?>