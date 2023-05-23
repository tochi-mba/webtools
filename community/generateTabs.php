<?php

$sql = "SELECT tags, manifest FROM scripts";
$result = mysqli_query($conn, $sql);
$tags = [];

while ($row = mysqli_fetch_assoc($result)) {
    $manifest = json_decode($row['manifest'], true);

    if ($manifest === null) {
        continue;
    }

    $public = false;

    foreach ($manifest as $version => $details) {
        foreach ($details as $detail) {
            if ($detail['status'] === 'public') {
                $public = true;
                break 2; // Exit both inner and outer loops
            }
        }
    }

    if (!$public) {
        continue;
    }

    $tag = strtolower($row['tags']);
    $tag = explode(",", $tag);

    foreach ($tag as $t) {
        if ($t !== '') {
            if (isset($tags[$t])) {
                $tags[$t]++;
            } else {
                $tags[$t] = 1;
            }
        }
    }
}

arsort($tags);
$i = 0;

foreach ($tags as $key => $value) {
    if ($i === 13) {
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
