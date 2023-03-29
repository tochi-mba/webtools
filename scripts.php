<?php 

require "head.php"; 
require "is_logged.php";

?>
<html>

<head>
    <title>Scripts by Title</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
    body {
        background: #1E1F1F !important;
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
    <!-- Search bar -->
    <style>

    </style>
    <!-- cards css -->
    <style type="text/scss">
        body {
  --background-color: #18181B;
  --text-color: #A1A1AA;

  --card-background-color: rgba(255, 255, 255, .015);
  --card-border-color: rgba(255, 255, 255, 0.1);
  --card-box-shadow-1: rgba(0, 0, 0, 0.05);
  --card-box-shadow-1-y: 3px;
  --card-box-shadow-1-blur: 6px;
  --card-box-shadow-2: rgba(0, 0, 0, 0.1);
  --card-box-shadow-2-y: 8px;
  --card-box-shadow-2-blur: 15px;
  --card-label-color: #FFFFFF;
  --card-icon-color: #D4D4D8;
  --card-icon-background-color: rgba(255, 255, 255, 0.08);
  --card-icon-border-color: rgba(255, 255, 255, 0.12);
  --card-shine-opacity: .1;
  --card-shine-gradient: conic-gradient(from 205deg at 50% 50%, rgba(128, 128, 128, 0) 0deg, #10B981 25deg, rgba(52, 211, 153, 0.18) 295deg, rgba(128, 128, 128, 0) 360deg);
  --card-line-color: #2A2B2C;
  --card-tile-color: rgba(128, 128, 128, 0.05);

  --card-hover-border-color: rgba(255, 255, 255, 0.2);
  --card-hover-box-shadow-1: rgba(0, 0, 0, 0.04);
  --card-hover-box-shadow-1-y: 5px;
  --card-hover-box-shadow-1-blur: 10px;
  --card-hover-box-shadow-2: rgba(0, 0, 0, 0.3);
  --card-hover-box-shadow-2-y: 15px;
  --card-hover-box-shadow-2-blur: 25px;
  --card-hover-icon-color: #34D399;
  --card-hover-icon-background-color: rgba(52, 211, 153, 0.1);
  --card-hover-icon-border-color: rgba(52, 211, 153, 0.2);

  --blur-opacity: .01;

  &.light {
    --background-color: #FAFAFA;
    --text-color: #52525B;

    --card-background-color: transparent;
    --card-border-color: rgba(24, 24, 27, 0.08);
    --card-box-shadow-1: rgba(24, 24, 27, 0.02);
    --card-box-shadow-1-y: 3px;
    --card-box-shadow-1-blur: 6px;
    --card-box-shadow-2: rgba(24, 24, 27, 0.04);
    --card-box-shadow-2-y: 2px;
    --card-box-shadow-2-blur: 7px;
    --card-label-color: #18181B;
    --card-icon-color: #18181B;
    --card-icon-background-color: rgba(24, 24, 27, 0.04);
    --card-icon-border-color: rgba(24, 24, 27, 0.1);
    --card-shine-opacity: .3;
    --card-shine-gradient: conic-gradient(from 225deg at 50% 50%, rgba(128, 128, 128, 0) 0deg, #10B981 25deg, #EDFAF6 285deg, #FFFFFF 345deg, rgba(128, 128, 128, 0) 360deg);
    --card-line-color: #E9E9E7;
    --card-tile-color: rgba(128, 128, 128, 0.08);

    --card-hover-border-color: rgba(24, 24, 27, 0.15);
    --card-hover-box-shadow-1: rgba(24, 24, 27, 0.05);
    --card-hover-box-shadow-1-y: 3px;
    --card-hover-box-shadow-1-blur: 6px;
    --card-hover-box-shadow-2: rgba(24, 24, 27, 0.1);
    --card-hover-box-shadow-2-y: 8px;
    --card-hover-box-shadow-2-blur: 15px;
    --card-hover-icon-color: #18181B;
    --card-hover-icon-background-color: rgba(24, 24, 27, 0.04);
    --card-hover-icon-border-color: rgba(24, 24, 27, 0.34);

    --blur-opacity: .1;
  }

  &.toggle .grid * {
    transition-duration: 0s !important;
  }
}

.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  grid-gap: 32px;
  position: relative;
  z-index: 1;
  margin-top:50px;
}

.card {
  background-color: var(--background-color);
  padding: 56px 16px 16px 16px;
  border-radius: 15px;
  cursor: pointer;
  position: relative;
  transition: box-shadow .25s;

  &::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 15px;
    background-color: var(--card-background-color);
  }

 

  h4 {
    z-index: 2;
    position: relative;
    margin: 12px 0 4px 0;
    font-family: inherit;
    font-weight: 600;
    font-size: 14px;
    line-height: 2;
    color: var(--card-label-color);
  }

  p {
    z-index: 2;
    position: relative;
    margin: 0;
    font-size: 14px;
    line-height: 1.7;
    color: var(--text-color);
  }

  

  .background {
    border-radius: inherit;
    position: absolute;
    inset: 0;
    overflow: hidden;

    .tiles {
      opacity: 0;
      transition: opacity .25s;

      .tile {
        position: absolute;
        animation-duration: 8s;
        animation-iteration-count: infinite;
        opacity: 0;

        &.tile-4,
        &.tile-6,
        &.tile-10 {
          animation-delay: -2s;
        }

        &.tile-3,
        &.tile-5,
        &.tile-8 {
          animation-delay: -4s;
        }

        &.tile-2,
        &.tile-9 {
          animation-delay: -6s;
        }

        &.tile-1 {
          top: 0;
          left: 0;
          height: 10%;
          width: 22.5%;
        }

        &.tile-2 {
          top: 0;
          left: 22.5%;
          height: 10%;
          width: 27.5%;
        }

        &.tile-3 {
          top: 0;
          left: 50%;
          height: 10%;
          width: 27.5%;
        }

        &.tile-4 {
          top: 0;
          left: 77.5%;
          height: 10%;
          width: 22.5%;
        }

        &.tile-5 {
          top: 10%;
          left: 0;
          height: 22.5%;
          width: 22.5%;
        }

        &.tile-6 {
          top: 10%;
          left: 22.5%;
          height: 22.5%;
          width: 27.5%;
        }

        &.tile-7 {
          top: 10%;
          left: 50%;
          height: 22.5%;
          width: 27.5%;
        }

        &.tile-8 {
          top: 10%;
          left: 77.5%;
          height: 22.5%;
          width: 22.5%;
        }

        &.tile-9 {
          top: 32.5%;
          left: 50%;
          height: 22.5%;
          width: 27.5%;
        }

        &.tile-10 {
          top: 32.5%;
          left: 77.5%;
          height: 22.5%;
          width: 22.5%;
        }
      }
    }

    @keyframes tile {

      0%,
      12.5%,
      100% {
        opacity: 1;
      }

      25%,
      82.5% {
        opacity: 0;
      }
    }

    .line {
      position: absolute;
      inset: 0;
      opacity: 0;
      transition: opacity .35s;

      &:before,
      &:after {
        content: '';
        position: absolute;
        background-color: var(--card-line-color);
        transition: transform .35s;
      }

      &:before {
        left: 0;
        right: 0;
        height: 1px;
        transform-origin: 0 50%;
        transform: scaleX(0);
      }

      &:after {
        top: 0;
        bottom: 0;
        width: 1px;
        transform-origin: 50% 0;
        transform: scaleY(0);
      }

      &.line-1 {
        &:before {
          top: 10%;
        }

        &:after {
          left: 22.5%;
        }

        &:before,
        &:after {
          transition-delay: .3s;
        }
      }

      &.line-2 {
        &:before {
          top: 32.5%;
        }

        &:after {
          left: 50%;
        }

        &:before,
        &:after {
          transition-delay: .15s;
        }
      }

      &.line-3 {
        &:before {
          top: 55%;
        }

        &:after {
          right: 22.5%;
        }
      }
    }
  }

  &:hover {
    box-shadow: 0px 3px 6px var(--card-hover-box-shadow-1), 0px var(--card-hover-box-shadow-2-y) var(--card-hover-box-shadow-2-blur) var(--card-hover-box-shadow-2), 0 0 0 1px var(--card-hover-border-color);

   


    .background {

      .tiles {
        opacity: 1;
        transition-delay: .25s;

        .tile {
          animation-name: tile;
        }
      }

      .line {
        opacity: 1;
        transition-duration: .15s;

        &:before {
          transform: scaleX(1);
        }

        &:after {
          transform: scaleY(1);
        }

        &.line-1 {

          &:before,
          &:after {
            transition-delay: .0s;
          }
        }

        &.line-2 {

          &:before,
          &:after {
            transition-delay: .15s;
          }
        }

        &.line-3 {

          &:before,
          &:after {
            transition-delay: .3s;
          }
        }
      }
    }
  }
}


html {
  box-sizing: border-box;
  -webkit-font-smoothing: antialiased;
}

* {
  box-sizing: inherit;
  &:before,
  &:after {
    box-sizing: inherit;
  }
}


body {
  min-height: 100vh;
  font-family: 'Inter', Arial;
  background-color: var(--background-color);
  min-width: 100vw;
  padding-left: 20px;
  padding-right: 40px;

}
    </style>
    <style>
    .versionTags {
        width: fit-content;
        display: flex;
        height: fit-content;
        padding: 3px;
        border-radius: 3px;
    }

    .projectBtns {
        margin-top: 10px;
    }

    .projectBtns form {
        display: inline-block;
    }

    .projectBtns form button {
        border-radius: 3px;
        border: solid grey 1px;
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

    code {
        font-family: Consolas, "courier new";
        color: white;
        padding: 2px;
        font-size: 105%;
    }
    </style>
</head>

<body>
    <?php require "connect.php";
    require "navbar.php";
    ?>
    <style>
    .nvbar {
        background-color: #1e1e1e;
    }
    </style>
    <?php
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

     
     curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
     curl_setopt($curl, CURLOPT_USERPWD, "username:password");

     curl_setopt($curl, CURLOPT_URL, $url);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

     $result = curl_exec($curl);

     curl_close($curl);

     return $result;
 }
$uid=$_SESSION["uid"];
$api_token = $_SESSION["api_token"];
$data= array(
  "api_token" => $api_token,
  "mode" => "3"
);
$response = CallAPI("GET", $website."/api/get_projects/", $data);
$projects = json_decode($response, true);
$versions = array();
foreach ($projects['data'] as $key => $value) {
  $versions[] = $projects['data'][$key]['version'];
}
if(isset($_GET['q'])&&trim($_GET['q'])!=""){
   
    
    $search_term = strtolower($_GET['q']);

    
    $project_temp = array();

    foreach($projects['data'] as $project) {
      if($project['status'] == '1') {
        $status="unlisted";
      }elseif($project['status'] == '2') {
        $status="private";
      }elseif($project['status'] == '3') {
        $status="public";
      }elseif($project['status'] == '4') {
        $status="monetized";
      }elseif($project['status'] == null) {
        $status="private";
      }
      if($search_term == "status:".$status.""){
        if($status == "private") {
            $project_temp[] = $project;
        } else if($status == "monetized") {
            $project_temp[] = $project;
        } else if($status == "public") {
            $project_temp[] = $project;
        } else if($status == "unlisted") {
            $project_temp[] = $project;
        }
        
      }
    }
    if (count($project_temp) == 0) {
      foreach($projects['data'] as $project) {
          
          $relevance = 0;
          
          
          if(strpos(strtolower($project['tags']), $search_term) !== false) {
              $relevance += 10;
          }

          
          if(strpos($project['script_id'], $search_term) !== false) {
            $relevance += 6;
          }
        
          
          if(strpos(strtolower($project['title']), $search_term) !== false) {
              $relevance += 5;
          }

          
          if($project['status'] == '1') {
            $status="unlisted";
          }elseif($project['status'] == '2') {
            $status="private";
          }elseif($project['status'] == '3') {
            $status="public";
          }elseif($project['status'] == '4') {
            $status="monetized";
          }elseif($project['status'] == null) {
            $status="private";
          }
          if(strpos($status, $search_term) !== false) {
            $relevance += 5;
          }
          
          
          if(strpos(strtolower($project['date_created']), $search_term) !== false) {
              $relevance += 3;
          }
          
          
          if(strpos(strtolower($project['category']), $search_term) !== false) {
              $relevance += 2;
          }
          
          
          if(strpos(strtolower($project['description']), $search_term) !== false) {
              $relevance += 1;
          }
          
          
          if(strpos(strtolower($project['version']), $search_term) !== false) {
              $relevance += 1;
          }
          
          
          if(strpos($project['authorized_users'], $search_term) !== false) {
              $relevance += 1;
          }
          
          
          if(strpos(strtolower($project['libraries']), $search_term) !== false ) {
              $relevance += 1;
          }
          
          
          if(strpos(strtolower($project['collaborators']), $search_term) !== false) {
              $relevance += 1;
          }
          
          
          if(strpos(strtolower($project['authorized_websites']), $search_term) !== false) {
              $relevance += 1;
          }
          
          
          $project['relevance'] = $relevance;
          
          
          $project_temp[] = $project;
      }
      usort($project_temp, function($a, $b) {
        return $b['relevance'] - $a['relevance'];
      });

      $project_temp = array_filter($project_temp, function($project) {
        return $project['relevance'] != 0;
      });
    }
    
   

    
    
    $projects['data'] = $project_temp;
}
$projects=$projects['data'];

if (isset($_GET['sort'])) {
  $sort = $_GET['sort'];
  if (isset($_GET['r'])) {
    $reverse = $_GET['r'];
  }else{
    $reverse = 'false';
  }
  if ($sort == "last_modified") {
    
    usort($projects, function($a, $b) {
      return strtotime($b['last_edited']) - strtotime($a['last_edited']);
    });
  }elseif ($sort == "date_created") {
    
    usort($projects, function($a, $b) {
      return strtotime($b['date_created']) - strtotime($a['date_created']);
    });
  }elseif ($sort == "name") {
    usort($projects, function($a, $b) {
      return strcmp(strtolower($a['title']), strtolower($b['title']));
    });
  }else{
    
    usort($projects, function($a, $b) {
      return strtotime($b['last_edited']) - strtotime($a['last_edited']);
    });

  }
  if ($reverse == 'true') {
    $projects = array_reverse($projects);
  }
}else{
    
    usort($projects, function($a, $b) {
      return strtotime($b['last_edited']) - strtotime($a['last_edited']);
    });
}
  ?>
    <!-- edit delete generate headcode. script id, title, version -->

    <form style="padding-top:30px" method="get">
        <center><input type="search" name="q" id="" value="<?php echo (isset($_GET['q']) ? $_GET['q'] : "")?>"></center>
        <select name="sort" id="">
            <option value="last_modified"
                <?php echo (isset($_GET['sort'])&&$_GET['sort']=="last_modified" ? "selected" : "")?>>Time Modified
            </option>
            <option value="date_created"
                <?php echo (isset($_GET['sort'])&&$_GET['sort']=="date_created" ? "selected" : "")?>>Time Created
            </option>
            <option value="name" <?php echo (isset($_GET['sort'])&&$_GET['sort']=="name" ? "selected" : "")?>>Name
            </option>
        </select>
        <select name="r" id="">
            <option value="false" <?php echo (isset($_GET['r'])&&$_GET['r']=="false" ? "selected" : "")?>>⬇</option>
            <option value="true" <?php echo (isset($_GET['r'])&&$_GET['r']=="true" ? "selected" : "")?>>⬆</option>
        </select>
        <input type="submit" value="Go">
    </form>
    <?php

$dir = './scripts/'.$_SESSION['uid']."/";
function getMbsValue($value) {
  return $value / 1048576;
}
function mbToBytes($mbs) {
  return $mbs * 1024 * 1024;
}
if (is_dir($dir)) {
    $size = 0;
    $dir_iterator = new RecursiveDirectoryIterator($dir);
    $iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
    foreach ($iterator as $file) {
        $size += $file->getSize();
    }
    

    $alotted_storage=file_get_contents("./config.json");
    $alotted_storage=json_decode($alotted_storage, true);
    $alotted_storage=$alotted_storage['free_alotted_space'];
    $percentage = ($size / mbToBytes($alotted_storage)) * 100;
    
    ?>
    <p>Storage (<span id="percentage">0</span>% full)</p>
    <?php
    echo '<div style="width:250;background-color:grey;height:4px;border-radius:10px;overflow:hidden">';
    echo '<div id="loadingBar" style="width: 0%; background-color: red;height:100%;border-radius:10px"></div>';
    echo '</div>';
    ?>
    <p><?php echo number_format((float)getMbsValue($size), 2, '.', ''); ?> MB of <?php echo $alotted_storage; ?> MB Used
    </p>
    <script>
    function loadingColor(percentage, loadingBar) {

        const startColor = [0, 255, 0];
        const endColor = [255, 0, 0];


        const colorIncrement = [
            (endColor[0] - startColor[0]) / 100,
            (endColor[1] - startColor[1]) / 100,
            (endColor[2] - startColor[2]) / 100,
        ];


        const loadingColors = [];
        for (let i = 0; i <= 100; i++) {
            const color = [
                Math.round(startColor[0] + colorIncrement[0] * i),
                Math.round(startColor[1] + colorIncrement[1] * i),
                Math.round(startColor[2] + colorIncrement[2] * i),
            ];

            const hexColor = "#" + color.map(c => c.toString(16).padStart(2, "0")).join("");
            loadingColors.push(hexColor);
        }


        loadingBar.style.backgroundColor = loadingColors[percentage];
    }

    window.onload = function() {

        const loadingBar = document.getElementById('loadingBar');
        const percentage = document.getElementById('percentage');


        let width = 0;


        const interval = setInterval(function() {

            if (width >= <?php echo $percentage; ?>) {
                clearInterval(interval);
            } else {

                width++;
                loadingColor(width, loadingBar);
                loadingBar.style.width = width + '%';
                percentage.innerHTML = width;
            }
        }, 20);
    }
    </script>
    <?php
}

?>
    <?php
   $versionNumbers=$versions;
    require "versionTagColors.php";
    ?>
    <div class="grid">
        <?php
    foreach($projects as $project) {
      $libraries = explode(',', $project['libraries']);
      $libraries = array_filter($libraries);
      
      if($project['status'] == '1') {
        $color="128, 128, 128";
      }elseif($project['status'] == '2') {
        $color="255, 0, 0";
      }elseif($project['status'] == '3') {
        $color="0, 128, 0";
      }elseif($project['status'] == '4') {
        $color="255, 215, 0";
      }elseif($project['status'] == null) {
        $color="255, 0, 0";
      }
      $version=$project['version'];
      require "modules.php";
     
    }
    ?>
    </div>
    <?php
    if(count($projects) == 0) {
      ?>
    <center>
        <p>No projects found.</p>
    </center>
    <?php
    }
    function encodeScriptTags($html) {
      
      $html = str_replace('<script', '&lt;script', $html);
      $html = str_replace('</script>', '&lt;/script&gt;', $html);
    
      return $html;
    }
    
   ?>
    <?php
if (file_exists("./libraries/libraries.json")) {
    $librariesJson = file_get_contents("./libraries/libraries.json");
    $librariesArray = json_decode($librariesJson, true);
    $librariesList = array();
    
    
    foreach ($librariesArray as $index => $library) {
        $librariesList[$library['name']] = ["./libraries/".$library['file'], $index];
    }
    
    
    foreach ($librariesList as $libraryName => $libraryDetails) {
        $libraryFilePath = $libraryDetails[0];
        if (file_exists($libraryFilePath)) {
            $libraryContents = file_get_contents($libraryFilePath);
            $libraryContents = explode("\n", $libraryContents);
            
            
            $libraryContents = array_filter($libraryContents, function($value) {
                return !empty(trim($value));
            });
            
            
            foreach ($libraryContents as $key => $value) {
                $libraryContents[$key] = encodeScriptTags($value);
                $libraryContents[$key] = str_replace('"', "'", $libraryContents[$key]);
            }
            
            
            $librariesList[$libraryName] = [$libraryContents, $libraryDetails[1]];
        }
    }
    
    $librariesListJson = json_encode($librariesList);
    $librariesListJson = str_replace('"', "`", $librariesListJson);
?>
    <input id="librariesLink" type="hidden" value="<?php echo $librariesListJson; ?>">
    <?php } ?>

    </div>
    <div class="embedModal"
        style="padding:5px;border-radius:15px;background-color: #1e1e1e;visibility:hidden;width:50%;height:70%;border:solid grey 2px;position:fixed;top:25%;right:25%;z-index:12">
        <span id="closeEmbedModal"
            style="position:absolute;top:10px;right:10px;float:right;font-size:30px;cursor:pointer;z-index:999;color:white;">&times;</span>
        <div class="instructions" style="position:absolute;top:5px;overflow-y:scroll;width:99%;height:98%;padding:20px">

        </div>

    </div>
    <script>
    const elements = document.querySelectorAll("*");

    function encodeHTMLTags(html) {
        const element = document.createElement('div');
        element.textContent = html;
        return element.innerHTML;
    }

    function changeTextToDiv(text) {
        const regex = /'([^']+)'/g;
        const newText = text.replace(regex, `<div style='display:inline-block;color: #00A67D'>"$1"</div>`);
        return newText;
    }

    function replaceSrcWithDiv(text) {
        return text.replace(/src/g, "<div style='display:inline-block;color:#DF3079'>src</div>");
    }



    function embedModal(active, version, scriptId, title, uid, libraries = "") {
        let instructionAmount = 0;


        let instructions = document.getElementsByClassName("instructions")[0];
        let librariesLinks = document.getElementById("librariesLink").value;


        libraries = libraries.split(",");
        libraries = libraries.filter(Boolean);


        librariesLinks = librariesLinks.replace(/`/g, '"');
        librariesLinks = JSON.parse(librariesLinks);


        let htmlLibs = "";
        instructions.innerHTML = "";


        if (libraries.length != 0) {
            instructionAmount++;
            htmlLibs += ` <div class="libraries-instruction" style="width:100%;height:fit-content;"> 
                  <div style="position:relative;display:inline-block;top: 30px;px;padding:5px;background-color:grey;color:white;font-weight:bold;font-size:15px;width:25px;height:25px;line-height:15px;border-radius:50%"> 
                    <center>` + instructionAmount + `</center> 
                  </div> 
                  <div style="display:inline-block;margin-left:40px"> 
                    <p>Put these Libraries just before the <code>&lt;/body&gt;</code> tag of your page:</p>`;


            for (let librariesLink in librariesLinks) {
                for (let i = 0; i < libraries.length; i++) {

                    if (libraries[i] == librariesLinks[librariesLink][1]) {
                        htmlLibs += ` <p> ` + librariesLink + ` </p> `;


                        for (let j = 0; j < librariesLinks[librariesLink][0].length; j++) {
                            htmlLibs += ` <div style="width:fit-content;background-color:#40414F;height:fit-content;padding:10px;border-radius:15px"> 
                          <code style="word-break:break-word"> ` + replaceSrcWithDiv(changeTextToDiv(encodeHTMLTags(
                                librariesLinks[librariesLink][0][j]))) + ` </code> 
                        </div> 
                        </br> `;
                        }
                    }
                }
            }


            htmlLibs += ` </div> 
                </div> `;
            instructions.innerHTML += htmlLibs;
        }

        const host = window.location.host;
        const protocol = window.location.protocol;
        const baseUrl = protocol + "//" + host;
        active = JSON.parse(active);

        if (active['codeCss'] === "active") {
            instructionAmount++;
            cssLink =
                `&lt;script <div style="color:#DF3079;display:inline-block">src</div>=<div style="color:#00A67D;display:inline-block">"` +
                baseUrl + `/webtools/?p=` + scriptId + `&u=` + uid +
                `&lang=css"</div>&gt;&lt;/script&gt;`;
            htmlCss = "";
            htmlCss += ` <div class="css-instruction" style="width:100%;height:fit-content;"> 
                  <div style="position:relative;display:inline-block;top: 30px;px;padding:5px;background-color:grey;color:white;font-weight:bold;font-size:15px;width:25px;height:25px;line-height:15px;border-radius:50%"> 
                    <center>` + instructionAmount + `</center> 
                  </div> 
                  <div style="display:inline-block;margin-left:40px"> 
                    <p>Put this code inbetween the <code>&lt;head&gt;&lt;/head&gt;</code> tag of your page:</p> 
                    <div style="width:fit-content;background-color:#40414F;height:fit-content;padding:10px;border-radius:15px"> 
                      <code style="word-wrap:break-word"> ` + cssLink + ` </code> 
                    </div> 
                    </br> 
                  </div> 
                </div> `;
            instructions.innerHTML += htmlCss;
        }

        if (active['code'] === "active") {
            instructionAmount++;
            jsLink =
                `&lt;script <div style="color:#DF3079;display:inline-block">src</div>=<div style="color:#00A67D;display:inline-block">"` +
                baseUrl + `/webtools/?p=` + scriptId + `&u=` + uid +
                `&lang=js"</div>&gt;&lt;/script&gt;`;
            htmlJs = "";
            htmlJs += ` <div class="js-instruction" style="width:100%;height:fit-content;"> 
                  <div style="position:relative;display:inline-block;top: 30px;px;padding:5px;background-color:grey;color:white;font-weight:bold;font-size:15px;width:25px;height:25px;line-height:15px;border-radius:50%"> 
                    <center>` + instructionAmount + `</center> 
                  </div> 
                  <div style="display:inline-block;margin-left:40px"> 
                    <p>Put this code just before the <code>&lt;/body&gt;</code> tag of your page:</p> 
                    <div style="width:fit-content;background-color:#40414F;height:fit-content;padding:10px;border-radius:15px"> 
                      <code style="word-break:break-word"> ` + jsLink + ` </code> 
                    </div> 
                    </br> 
                  </div> 
                </div> `;
            instructions.innerHTML += htmlJs;
        }


        document.getElementsByClassName('embedModal')[0].style.visibility = "visible";
    }

    document.getElementById("closeEmbedModal").addEventListener("click", function() {
        document.getElementsByClassName('embedModal')[0].style.visibility = "hidden";
    });
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/browser-scss@1.0.3/dist/browser-scss.min.js"></script>

</body>

</html>