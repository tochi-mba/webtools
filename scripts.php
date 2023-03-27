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

// Center
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
      .versionTags{
        width:fit-content;
        display:flex;
        height:fit-content;
        padding:3px;
        border-radius:3px;
      }
      .projectBtns{
        margin-top:10px;
      }
      .projectBtns form{
        display:inline-block;
      }
      .projectBtns form button{
        border-radius:3px;
        border:solid grey 1px;
      }
    </style>
</head>

<body>
    <?php require "connect.php";
    require "navbar.php";
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
   
    // Get the search term from the URL
    $search_term = strtolower($_GET['q']);

    // Initialize the project_temp array
    $project_temp = array();

    // Loop through the projects array
    foreach($projects['data'] as $project) {
        // Calculate the relevance of the project
        $relevance = 0;
        
        // Check if the search term is in the tags
        if(strpos(strtolower($project['tags']), $search_term) !== false) {
            $relevance += 10;
        }

        // Check if the search term is in the script_id
        if(strpos($project['script_id'], $search_term) !== false) {
          $relevance += 6;
        }
      
        // Check if the search term is in the title
        if(strpos(strtolower($project['title']), $search_term) !== false) {
            $relevance += 5;
        }

        // Check if the search term is in the status
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
        
        // Check if the search term is in the date_created
        if(strpos(strtolower($project['date_created']), $search_term) !== false) {
            $relevance += 3;
        }
        
        // Check if the search term is in the category
        if(strpos(strtolower($project['category']), $search_term) !== false) {
            $relevance += 2;
        }
        
        // Check if the search term is in the description
        if(strpos(strtolower($project['description']), $search_term) !== false) {
            $relevance += 1;
        }
        
        // Check if the search term is in the version
        if(strpos(strtolower($project['version']), $search_term) !== false) {
            $relevance += 1;
        }
        
        // Check if the search term is in the authorized users
        if(strpos($project['authorized_users'], $search_term) !== false) {
            $relevance += 1;
        }
        
        // Check if the search term is in the libraries
        if(strpos(strtolower($project['libraries']), $search_term) !== false ) {
            $relevance += 1;
        }
        
        // Check if the search term is in the collaborators
        if(strpos(strtolower($project['collaborators']), $search_term) !== false) {
            $relevance += 1;
        }
        
        // Check if the search term is in the authorized_websites
        if(strpos(strtolower($project['authorized_websites']), $search_term) !== false) {
            $relevance += 1;
        }
        
        // Add the relevance to the project
        $project['relevance'] = $relevance;
        
        // Add the project to the project_temp array
        $project_temp[] = $project;
    }

    // Sort the project_temp array by relevance
    usort($project_temp, function($a, $b) {
        return $b['relevance'] - $a['relevance'];
    });

    $filtered_projects = array_filter($project_temp, function($project) {
      return $project['relevance'] != 0;
    });
    $projects['data'] = $filtered_projects;
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
    // Sort the projects array by last edited
    usort($projects, function($a, $b) {
      return strtotime($b['last_edited']) - strtotime($a['last_edited']);
    });
  }elseif ($sort == "date_created") {
    // Sort the projects array by date created
    usort($projects, function($a, $b) {
      return strtotime($b['date_created']) - strtotime($a['date_created']);
    });
  }elseif ($sort == "name") {
    usort($projects, function($a, $b) {
      return strcmp(strtolower($a['title']), strtolower($b['title']));
    });
  }else{
    // Sort the projects array by last edited
    usort($projects, function($a, $b) {
      return strtotime($b['last_edited']) - strtotime($a['last_edited']);
    });

  }
  if ($reverse == 'true') {
    $projects = array_reverse($projects);
  }
}else{
    // Sort the projects array by last edited
    usort($projects, function($a, $b) {
      return strtotime($b['last_edited']) - strtotime($a['last_edited']);
    });
}
  ?>
    <!-- edit delete generate headcode. script id, title, version -->
    <form method="get">
    <center><input type="search" name="q" id="" value="<?php echo (isset($_GET['q']) ? $_GET['q'] : "")?>"></center>
    <select name="sort" id="">
      <option value="last_modified" <?php echo (isset($_GET['sort'])&&$_GET['sort']=="last_modified" ? "selected" : "")?>>Time Modified</option>
      <option value="date_created" <?php echo (isset($_GET['sort'])&&$_GET['sort']=="date_created" ? "selected" : "")?>>Time Created</option>
      <option value="name" <?php echo (isset($_GET['sort'])&&$_GET['sort']=="name" ? "selected" : "")?>>Name</option>
    </select>
    <select name="r" id="">
      <option value="false" <?php echo (isset($_GET['r'])&&$_GET['r']=="false" ? "selected" : "")?>>⬇</option>
      <option value="true" <?php echo (isset($_GET['r'])&&$_GET['r']=="true" ? "selected" : "")?>>⬆</option>
    </select>
    <input type="submit" value="Go">
    </form>
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
   ?>

    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
<script src="https://cdn.jsdelivr.net/npm/browser-scss@1.0.3/dist/browser-scss.min.js"></script>   
</body>

</html>