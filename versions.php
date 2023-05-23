<?php 

require "head.php"; 
require "is_logged.php";
if (!isset($_GET['script_id'])){
	header("No project id provided");
	exit;
}else{
	require "connect.php";
	require "user_verification.php";
	$script_id = $_GET['script_id'];
	$sql = "SELECT * FROM scripts WHERE script_id = '$script_id' AND uid = '".$_SESSION['uid']."'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$manifest = $row['manifest'];
		$manifest = json_decode($manifest, true);
    $notifications = 0;
    $published = 0;
    $publishImage = 0;
    foreach ($manifest as $version => $details) {
      foreach ($details as $detail) {
        if ($detail['status'] == 'public' or $detail['status'] == 'monetized') {
          if ($row['publish_manifest'] == "" or $row['publish_manifest'] == "[]") {
            $published++;
            break;

          }
          if ($row['publish_image'] == "" or strpos($row['publish_image'], 'image.php') !== false){
            $publishImage++;
            $published++;
            break;
          }
        }
      }
		}
    if ($published > 0){
      $notifications++;
    }
    $sql1 = "SELECT * FROM users WHERE uid = '".$_SESSION['uid']."' AND api_token = '".$_SESSION['api_token']."'";
    $result1 = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($result1) > 0) {
      $user_details = mysqli_fetch_assoc($result1);
    }
	}else{
		header("Script does not exist");
		exit;
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/scss">
        body {
  --background-color: #18181B;
  --text-color: #A1A1AA;

  --card-background-color: rgba(255, 255, 255, .015);
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
  --card-shine-gradient: conic-gradient(from 205deg at 50% 50%, rgba(255, 0, 0, 0) 0deg, #FF0000 25deg, rgba(255, 0, 0, 0.18) 295deg, rgba(255, 0, 0, 0) 360deg);
  --card-line-color: #2A2B2C;
  --card-tile-color: rgba(255, 0, 0, 0.05);

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
    --card-shine-gradient: conic-gradient(from 225deg at 50% 50%, rgba(16, 185, 129, 0) 0deg, #10B981 25deg, #EDFAF6 285deg, #FFFFFF 345deg, rgba(16, 185, 129, 0) 360deg);
    --card-line-color: #E9E9E7;
    --card-tile-color: rgba(16, 185, 129, 0.08);

    --card-hover-border-color: rgba(24, 24, 27, 0.15);
    --card-hover-box-shadow-1: rgba(255, 24, 27, 0.05);
    --card-hover-box-shadow-1-y: 3px;
    --card-hover-box-shadow-1-blur: 6px;
    --card-hover-box-shadow-2: rgba(255, 24, 27, 0.1);
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
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  grid-auto-rows: minmax(0, auto);
  grid-gap: 10px;
  z-index: 1;
  width:77%;


}

.card {
  background-color: var(--background-color);
  box-shadow: 0px var(--card-box-shadow-1-y) var(--card-box-shadow-1-blur) var(--card-box-shadow-1), 0px var(--card-box-shadow-2-y) var(--card-box-shadow-2-blur) var(--card-box-shadow-2), 0 0 0 1px var(--card-border-color);
  padding: 56px 16px 16px 16px;
  border-radius: 15px;
  cursor: pointer;
  position: relative;
  transition: box-shadow .25s;
	height:fit-content;
	
  &::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 15px;
    background-color: var(--card-background-color);
  }

  .icon {
    z-index: 2;
    position: relative;
    display: table;
    padding: 8px;

    &::after {
      content: '';
      position: absolute;
      inset: 4.5px;
      border-radius: 50%;
      background-color: var(--card-icon-background-color);
      border: 1px solid var(--card-icon-border-color);
      backdrop-filter: blur(2px);
      transition: background-color .25s, border-color .25s;
    }

    svg {
      position: relative;
      z-index: 1;
      display: block;
      width: 24px;
      height: 24px;
      transform: translateZ(0);
      color: var(--card-icon-color);
      transition: color .25s;
    }
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
        background-color: var(--card-tile-color);
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

    .icon {
      &::after {
        background-color: var(--card-hover-icon-background-color);
        border-color: var(--card-hover-icon-border-color);
      }

      svg {
        color: var(--card-hover-icon-color);
      }
    }

    .shine {
      opacity: 1;
      transition-duration: .5s;
      transition-delay: 0s;
    }

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

.day-night {
  cursor: pointer;
  position: absolute;
  right: 20px;
  top: 20px;
  opacity: .3;

  input {
    display: none;

    &+div {
      border-radius: 50%;
      width: 20px;
      height: 20px;
      position: relative;
      box-shadow: inset 8px -8px 0 0 var(--text-color);
      transform: scale(1) rotate(-2deg);
      transition: box-shadow .5s ease 0s, transform .4s ease .1s;

      &:before {
        content: '';
        width: inherit;
        height: inherit;
        border-radius: inherit;
        position: absolute;
        left: 0;
        top: 0;
        transition: background-color .3s ease;
      }

      &:after {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        margin: -3px 0 0 -3px;
        position: absolute;
        top: 50%;
        left: 50%;
        box-shadow: 0 -23px 0 var(--text-color), 0 23px 0 var(--text-color), 23px 0 0 var(--text-color), -23px 0 0 var(--text-color), 15px 15px 0 var(--text-color), -15px 15px 0 var(--text-color), 15px -15px 0 var(--text-color), -15px -15px 0 var(--text-color);
        transform: scale(0);
        transition: all .3s ease;
      }
    }

    &:checked+div {
      box-shadow: inset 20px -20px 0 0 var(--text-color);
      transform: scale(.5) rotate(0deg);
      transition: transform .3s ease .1s, box-shadow .2s ease 0s;

      &:before {
        background: var(--text-color);
        transition: background-color .3s ease .1s;
      }

      &:after {
        transform: scale(1);
        transition: transform .5s ease .15s;
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
  display: flex;
  font-family: 'Inter', Arial;
  justify-content: center;
  padding-top:150px;
  background-color: var(--background-color);
overflow-x: hidden !important;
  &:before {
    content: '';
    position: absolute;
    inset: 0 -60% 65% -60%;
    background-image: radial-gradient(ellipse at top, #10B981 0%, var(--background-color) 50%);
    opacity: var(--blur-opacity);
  }

  .twitter {
    position: fixed;
    display: block;
    right: 12px;
    bottom: 12px;
    svg {
      width: 32px;
      height: 32px;
      fill: #fff;
    }
  }
}
	</style>
    <style>
    .versionTags {
        width: fit-content;
        display: flex;
        height: fit-content;
        padding: 3px;
        border-radius: 3px;
        color: white;

    }

    .neon {
        display: inline-block;
        border-radius: 5px;
        border: solid grey 1px;
        color: white;
        background-color: #282A36;
        font-size: 12px;
        font-weight: bold;
        width: fit-content;
        padding: 5px;
        line-height: 1.2;
        text-align: center;
        text-transform: uppercase;
    }

    #loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index: 999;
        display: flex;
        align-items: center;
        justify-content: center;
        visibility: visible;
        z-index: 9999;
    }

    .loading-gif {
        max-width: 100%;
        max-height: 100%;
    }

    #versionOptions {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(24, 24, 27, 0.9);
    }

    #versionOptionsBox {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50vw;
        height: 70vh;
        background-color: #18181B;
        border-radius: 15px;
        color: white;
        padding: 20px;
        border: solid 1px grey;
        overflow-y: scroll;
        overflow-x: hidden;
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

    .info {
        color: grey;
        font-size: 12px;
    }

    #statusOptions {
        width: 100%;
        height: 30px;
        cursor: pointer;
    }

    .authorizedWebsite {
        width: 93%;
        height: 30px;
    }

    #authAdd {
        width: 6%;
        height: 30px;
        cursor: pointer;
    }

    #confirmation {
        display: none;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999999;
    }

    #confirmationBox {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 30vw;
        max-height: 70vh;
        background-color: #18181B;
        border-radius: 15px;
        color: white;
        padding: 20px;
        border: solid 1px grey;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    .showChanges p {
        font-size: 12px;
        color: grey;
    }

    button {
        cursor: pointer;
    }

    .notificationIcon {
        display: none;

        <?php if ($published > 0) {
            echo "display: block;";
        }

        ?>
    }

    .filler {
        visibility: hidden;
    }

    .publishEditorBox {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(24, 24, 27, 0.9);
        justify-content: center;
        align-items: center;

    }

    .publishEditor {
        width: 50vw;
        height: 80vh;
        background-color: #18181B;
        border-radius: 15px;
        color: white;
        padding: 20px;
        border: solid 1px grey;
        overflow-y: scroll;
        overflow-x: hidden;
        display: inline-block;
        margin: 20px;
        position: relative;
    }

    .publishEditor h1 {
        position: absolute;
        top: 5%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin: 0;
        padding: 0;
        font-size: 20px;
    }

    .toolBar {
        position: fixed;
        top: 20%;
        left: 55%;
        transform: translate(-50%, -50%);
        width: 100%;
        z-index: 1;

    }

    .toolBar label {
        background-color: #18181B;
        padding: 5px;
        border-radius: 5px;
    }

    .toolBar button,
    .saveCardBtn {
        background-color: #18181B;
        border-radius: 5px;
        border: solid 1px grey;
        color: white;
    }

    .toolBar button:hover,
    .saveCardBtn:hover {
        transform: scale(1.1);
        transition: 0.2s ease-in-out;
    }

    .sectionInput,
    .subSectionInput {
        border-radius: 5px;
        border: 1px solid grey;
        padding: 5px;
        background-color: #18181B;
        color: white;
        margin-left: 5px;
        margin-right: 5px;

    }

    .section {
        margin-bottom: 10px !important;
    }

    .subSection {
        margin-bottom: 10px !important;
    }

    .publishShowBox {
        color: white;

    }

    .renderedPublish {
        font-family: 'Roboto Mono', monospace;

    }

    .publishImageBox {
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 9999;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .publishImageShow {
        width: 30%;
        height: fit-content;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 15px;
        background-color: #18181B;
        border: solid 1px grey;
        padding: 20px;
    }

    .publishImageShow input {
        width: 100%;
        height: 30px;
        border-radius: 15px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        padding: 10px;

    }

    .publishImageShow textarea {
        width: 100%;
        max-width: 100%;
        min-width: 100%;
        max-height: 40vh;
        border-radius: 15px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        padding: 10px;

    }

    .cards {
        position: absolute;
        top: 0;
        left: 130%;
        transform: translate(-50%, -50%);
        display: grid !important;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)) !important;
        margin: 9rem 5vw !important;
        padding: 0 !important;
        list-style-type: none !important;
        min-width: 250px !important;
    }

    .code {
        border-radius: 15px;
        padding: 10px;
        width: 100%;
        background-color: #282a36;
        word-break: break-all;
        word-wrap: break-word;
    }

    .code code {
        color: white;
    }

    .cardAlerts,
    .cardDescriptionAlerts {
        color: red;
    }

    label {
        color: white;
        font-size: 13px;
    }

    .subSection {
        display: flex;
        align-items: center;
    }

    .typeBtn {
        width: 21px;
        height: 25px;
        border-radius: 5px;
        border: solid 1px grey;
        background-color: #18181B;
        color: white;
        margin: auto;
        margin-left: 5px;
    }

    .typeBtn svg path {
        fill: white;
        width: 10px;
    }

    .subSectionType {
        height: 25px;
        background-color: #18181B;
        color: white;
        border-radius: 5px;
        border: solid 1px grey;
        margin-left: 5px;
        cursor: pointer;

    }

    .htmlInput,
    .codeInput,
    .textInput {
        padding-left: 35px;
        background-color: #282A36;
        color: white;
        border: none;
        border-radius: 15px;

    }

    .CodeMirror {
        border-radius: 15px;
    }

    .code {
        overflow-x: scroll;
    }

    .description {
        border-radius: 10px !important;
        border: solid 1px grey !important;
        background-color: #181818 !important;
        color: white !important;
    }

    .imageURL {
        border-radius: 10px !important;
        border: solid 1px grey !important;
        background-color: #181818 !important;
        color: white !important;
    }
    </style>

    <link rel="stylesheet" href="./codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="./codemirror/addon/lint/lint.css">
    <link rel="stylesheet" href="./codemirror/addon/dialog/dialog.css">
    <link rel="stylesheet" href="./codemirror/addon/search/matchesonscrollbar.css">
    <link rel="stylesheet" href="./codemirror/theme/dracula.css">
    <script src="./codemirror/lib/codemirror.js"></script>
    <script src="./codemirror/mode/javascript/javascript.js"></script>
    <script src="./codemirror/mode/css/css.js"></script>
    <script src="https://unpkg.com/jshint@2.13.2/dist/jshint.js"></script>
    <script src="https://unpkg.com/jsonlint@1.6.3/web/jsonlint.js"></script>
    <script src="https://unpkg.com/csslint@1.0.5/dist/csslint.js"></script>
    <script src="./codemirror/addon/lint/lint.js"></script>
    <script src="./codemirror/addon/lint/javascript-lint.js"></script>
    <script src="./codemirror/addon/lint/json-lint.js"></script>
    <script src="./codemirror/addon/lint/css-lint.js"></script>
    <link rel="stylesheet" href="./codemirror/addon/scroll/simplescrollbars.css">
    <script src="./codemirror/addon/scroll/simplescrollbars.js"></script>
    <script src="./codemirror/addon/edit/closebrackets.js"></script>
    <script src="./codemirror/mode/javascript/javascript.js"></script>
    <link rel="stylesheet" href="./codemirror/addon/display/fullscreen.css">
    <script src="./codemirror/addon/display/fullscreen.js"></script>
</head>

<body>

    <?php 
    require "navbar.php";
    ?>
    <style>
    .nvbar {
        background-color: #18181B;
        width: 100vw;
        z-index: 9991;
    }
    </style>
    <div id="loading-screen">
        <img class="loading-gif" src="./assets/images/loading.gif" alt="Loading...">


        <p id="loading-label" style="color:white">Loading Versions for '<?php echo $row['title']?>'</p>

    </div>
    <?php

function getMbsValue($value) {
  return $value / 1048576;
}
function mbToBytes($mbs) {
  return $mbs * 1024 * 1024;
}
    $size = 0;
    $dir = './scripts/'.$_SESSION['uid']."_private/".$_GET['script_id']."/";

    if (is_dir($dir)) {

    $dir_iterator = new RecursiveDirectoryIterator($dir);
    $iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
    foreach ($iterator as $file) {
        $size += $file->getSize();
    }
}
    $dir="./scripts/".$_SESSION['uid']."_public/". $_GET['script_id']."/";
	if (is_dir($dir)) {
        ?>
        <script>
            console.log("public")
        </script>
        <?php
		$dir_iterator = new RecursiveDirectoryIterator($dir);
		$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
		foreach ($iterator as $file) {
			$size += $file->getSize();
		}
	}
    $sql = "SELECT scripts_id FROM users WHERE uid = '" . $_SESSION['uid'] . "' AND api_token = '" . $_SESSION['api_token']."'";
    $result = $conn->query($sql);
    $row1 = $result->fetch_assoc();
    $dir="./scripts/".$_SESSION['uid']."_unlisted_".$row1['scripts_id']."/". $_GET['script_id']."/";
	if (is_dir($dir)) {
		$dir_iterator = new RecursiveDirectoryIterator($dir);
		$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
		foreach ($iterator as $file) {
			$size += $file->getSize();
		}
	}

    $dir="./scripts/".$_SESSION['uid']."_monetized_".$row1['scripts_id']."/". $_GET['script_id']."/";
	if (is_dir($dir)) {
		$dir_iterator = new RecursiveDirectoryIterator($dir);
		$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
		foreach ($iterator as $file) {
			$size += $file->getSize();
		}
	}

    ?>
    <div
        style="position:fixed;top:7%;z-index:999;width:100%;background:none;text-align:center;padding-bottom:10px;color:white">

        <h1 style="display:inline-block"><?php echo $row['title'];?></h1>
        <p
            style="background-color:#18181B;display:inline-block;border:solid grey 1px;border-radius:5px;padding:5px;font-size:14px">
            <?php echo count($manifest);?> <?php echo (count($manifest) == 1 ? "version" : "versions")?> found</p>
        <p
            style="background-color:#18181B;display:inline-block;border:solid grey 1px;border-radius:5px;padding:5px;font-size:14px">
            Size:
            <?php echo number_format((float)getMbsValue($size), 2, '.', '');?>MB</p>
        <button onclick="publishDetailsUpdate();"
            style="padding:5px;display:inline-block;position:relative;background-color: #18181B;border:1px solid grey;border-radius:5px">
            <svg style="width:12px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <path fill="white"
                    d="M246.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 109.3V320c0 17.7 14.3 32 32 32s32-14.3 32-32V109.3l73.4 73.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-128-128zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64c0 53 43 96 96 96H352c53 0 96-43 96-96V352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V352z" />
            </svg>
            <div class="notificationIcon"
                style="width:10px;height:10px;border-radius:50%;background-color:#FF69B4;position:absolute;bottom:-5px;right:-5px"
                class="publish"></div>
        </button>
    </div>
    <div class="publishEditorBox">
        <div class="publishImageBox"
            onclick="event.stopPropagation();this.style.display='none';document.querySelector('.cards').innerHTML=''">
            <div class="publishImageShow" onclick="event.stopPropagation()">
                <input class="imageURL" type="link">
                <div style="position: relative;">
                    <span class="counter" style="position: absolute; top: 0; right: 10px; font-size: 12px;color:white">0
                        / 250</span>
                    <textarea name="" class="description" cols="30" rows="10"></textarea>
                </div>
                <ul class="cards"></ul>
                <button class="saveCardBtn" onclick="updateCard()">Save</button>
                <div class="cardAlerts"></div>
                <div class="cardDescriptionAlerts"></div>

            </div>
        </div>
        <div onclick="event.stopPropagation()" class="publishEditor">
            <h1>Editor</h1>
            <div class="publishCustomizationBox" style="position:relative">
                <div class="spaceCustomization"></div>
                <br>
                <br>
                <br>
                <div class="toolBar">
                    <button onclick="resetPublish()" type="reset">Reset</button>
                    <label for="">New section:</label>
                    <button onclick="addSection()">+</button>
                    <label for="">New subsection:</label>
                    <button onclick="addSubSection()">+</button>
                    <button id="savePublish" onclick="savePublishResponse(this)">Save</button>
                    <label for="">Update Card:</label>
                    <button onclick="document.querySelector('.publishImageBox').style.display='block';renderCard()"
                        style="position: relative;">
                        <span>+</span>
                        <?php
                        if ($publishImage > 0){
                            ?>
                        <span
                            style="width:10px;height:10px;border-radius:50%;background-color:#FF69B4;position:absolute;bottom:-5px;right:-5px"></span>
                        <?php
                        }
                       ?>
                    </button>


                </div>
            </div>
            <?php
              $json = $row['publish_manifest'];
              if (json_decode($json) === null or $json == "") {
                $json = "[]";
            }
            ?>
            <input type="hidden" id="publishJSON" value='<?php  echo $json ;?>'>
        </div>
        <div onclick="event.stopPropagation()" class="publishEditor renderedPublish">
            <h1>Render</h1>
            <br>
            <br>
            <div class="publishShowBox" style="width:100%">
                <h2>Getting Started</h2>
                <h3>Implementation</h3>
                <p>JS Code</p>
                <pre>
  <code>
document.addEventListener("DOMContentLoaded", function(event) {
    var script = document.createElement('script');
    document.body.appendChild(script);
});
  </code>
</pre>

            </div>
        </div>
    </div>
    <br>
    <script>
    function updateCard() {
        var data = {};
        console.log("Saving changes");
        method = "POST";
        baseUrl = window.location.protocol + "//" + window.location.hostname;
        url = baseUrl + "/api/private/update_card/";
        data.uid = '<?php echo $_SESSION['uid']; ?>';
        data.script_id = '<?php echo $_GET['script_id']; ?>';
        data.description = document.querySelector('.description').value;
        data.image = document.querySelector('.imageURL').value;

        function saveScriptId(response) {
            console.log(response);
            
            if (!JSON.parse(response)){
                document.querySelector(".cardAlerts").innerHTML =
                    "<p style='color:red;font-size:13px'>Error</p>";
                setTimeout(() => {
                    document.querySelector(".cardAlerts").innerHTML = "";
                }, 2000);
                saveCardBtn = document.querySelector(".saveCardBtn");

                previousText = saveCardBtn.innerText;

                saveCardBtn.innerText = "Error...";

                setTimeout(() => {
                    saveCardBtn.innerText = previousText;
                }, 2000);
            }else{
                response = JSON.parse(response);
            }
            if (response.success) {
                document.querySelector(".cardAlerts").innerHTML = "<p style='color:white;font-size:13px'>Changes saved.</p>";
                setTimeout(() => {
                    document.querySelector(".cardAlerts").innerHTML = "";
                }, 2000);
                saveCardBtn = document.querySelector(".saveCardBtn");

                previousText = saveCardBtn.innerText;

                saveCardBtn.innerText = "Saved";

                setTimeout(() => {
                    saveCardBtn.innerText = previousText;
                }, 2000);
            } else {
                document.querySelector(".cardAlerts").innerHTML =
                    "<p style='color:red;font-size:13px'>"+response.message+"</p>";
                setTimeout(() => {
                    document.querySelector(".cardAlerts").innerHTML = "";
                }, 2000);
                saveCardBtn = document.querySelector(".saveCardBtn");

                previousText = saveCardBtn.innerText;

                saveCardBtn.innerText = "Error...";

                setTimeout(() => {
                    saveCardBtn.innerText = previousText;
                }, 2000);
            }
        }
        makeApiRequest(method, url, data)
            .then(saveScriptId)
            .catch((error) => console.error(error));
    }
    var description = document.querySelector('.description');
    var counter = description.parentElement.querySelector('.counter');

    description.addEventListener('input', function() {
        var count = this.value.length;
        counter.textContent = count + ' / 250';

        if (count > 250) {
            counter.style.color = 'red';
            this.style.color = 'grey';
            document.querySelector('.cardDescriptionAlerts').innerText = `Description is too long`;
        } else {
            counter.style.color = 'white';
            this.style.color = 'white';
            document.querySelector('.cardDescriptionAlerts').innerText = ``;
        }
    });

    function getImageSize(url) {
        // create a new image element
        const img = new Image();

        // set the src attribute to the provided url
        img.src = url;

        // wait for the image to load
        return new Promise((resolve, reject) => {
            img.onload = () => {
                // get the size of the image
                const size = {
                    width: img.width,
                    height: img.height
                };
                // resolve the promise with the size
                resolve(size);
            };
            // reject the promise if there was an error loading the image
            img.onerror = (err) => {
                reject(err);
            };
        });
    }
    card = `
        <li>
    <div  class="card">
    <div class="card__open">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path fill="grey" d="M32 32C14.3 32 0 46.3 0 64v96c0 17.7 14.3 32 32 32s32-14.3 32-32V96h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H32zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7 14.3 32 32 32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H64V352zM320 32c-17.7 0-32 14.3-32 32s14.3 32 32 32h64v64c0 17.7 14.3 32 32 32s32-14.3 32-32V64c0-17.7-14.3-32-32-32H320zM448 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64H320c-17.7 0-32 14.3-32 32s14.3 32 32 32h96c17.7 0 32-14.3 32-32V352z"/></svg>
    </div>
    <img id="card__image" onload="cardImg=this;cardImg.style.display = 'block';parent = cardImg.parentNode;parent.querySelector('div.card__image').style.display = 'none';" style="display:none;" loop src="" class="card__image" alt="" loop/>

        <div class="card__image" style="background-color:grey;min-height:300px"></div>
        <div class="card__overlay">
            <div class="card__header">
                <svg class="card__arc" xmlns="http://www.w3.org/2000/svg">
                    <path />
                </svg>
                <img class="card__thumb" src="dp.php?u=<?php echo $user_details['username']?>" alt="" />
                <div class="card__header-text">
                    <h3 class="card__title"><?php echo $row['title']?></h3>
                    <a target="_blank" style="text-decoration: none;" href=""><span style="text-decoration:none" class="card__status">@<?php echo $user_details['username']?></span></a>
                </div>
            </div>
            <p id="card__description" class="card__description">Pears are a type of fruit that
                are enjoyed all over the world for their sweet and juicy flavor, as well as their many health
                benefits. They come in a variety of colors, shapes, and sizes, and can be eaten raw, cooked, or
                used in a variety of rsssssss
            </p>
        </div>
    </div>
</li>
        `;
    filler = `
        <li>
            <a href="" class="card filler" style="visibility:none">
               
            </a>
        </li>
        <li>
            <a href="" class="card filler" style="visibility:none">
              
            </a>
        </li>
        <li>
            <a href="" class="card filler" style="visibility:none">
              
            </a>
        </li>
        <li>
            <a href="" class="card filler">
             
            </a>
        </li>
        `;
    css = ` 
    
        <style>
        :root {
    --surface-color: rgba(43, 43, 45, 0.8) !important;
    --curve: 15 !important;
}

* {
    box-sizing: border-box !important;
}

body {
  font-family: 'Roboto Mono', monospace;
}




.card {
    position: relative !important;
    display: block !important;
    height: 100% !important;
    border-radius: calc(var(--curve) * 1px) !important;
    overflow: hidden !important;
    text-decoration: none !important;
    cursor: pointer !important;
    padding: 0 !important;
    margin: 0 !important;
}

.card__image {
    width: 100% !important;
    height: auto !important;
}

.card__overlay {
    position: absolute !important;
    bottom: 0 !important;
    left: 0 !important;
    right: 0 !important;
    z-index: 1 !important;
    border-radius: calc(var(--curve) * 1px) !important;
    background-color: var(--surface-color) !important;
    transform: translateY(100%) !important;
    transition: .2s ease-in-out !important;
}

.card:hover .card__overlay {
    transform: translateY(0) !important;
}

.card:hover .card__open {
    transform: scale(1.5) !important;

}

.card:hover .card__open svg path {
    fill: #fff !important;

}


.card__header {
    position: relative !important;
    display: flex !important;
    align-items: center !important;
    gap: 2em !important;
    padding: 0.25em !important;
    border-top-left-radius: calc(var(--curve) * 1px) !important;
    border-top-right-radius: calc(var(--curve) * 1px) !important;
    background-color: rgba(43, 43, 45, 0.5) !important;
    transform: translateY(-100%) !important;
    transition: .2s ease-in-out !important;
    backdrop-filter: blur(10px) opacity(80%) !important;
    -webkit-backdrop-filter: blur(5px) opacity(80%) !important;
    z-index: 50 !important;
}

.card__arc {
    width: 80px !important;
    height: 80px !important;
    position: absolute !important;
    bottom: 100% !important;
    right: 0 !important;
    z-index: 1 !important;
    display: none !important;
}

.card__arc path {
    fill: var(--surface-color) !important;
    d: path("M 40 80 c 22 0 40 -22 40 -40 v 40 Z") !important;
    backdrop-filter: blur(10px) opacity(80%) !important;
    -webkit-backdrop-filter: blur(5px) opacity(80%) !important;
}


.card:hover .card__header {
    transform: translateY(0) !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
    background-color: rgba(43, 43, 45, 1) !important;
}

.card__thumb {
    flex-shrink: 0 !important;
    width: 50px !important;
    height: 50px !important;
    border-radius: 15px !important;
}

.card__title {
    font-size: 1em !important;
    margin: 0 0 .3em !important;
    color: white !important;
}

.card__tagline {
    display: block !important;
    margin: 1em 0 !important;
    font-family: "MockFlowFont" !important;
    font-size: .8em !important;
    color: white !important;
}

.card__status {
    font-size: .8em !important;
    color: white !important;
}
.card__description {
    padding: 5px !important;
    padding-bottom: 5px !important;
    padding-left: 5px !important;
    margin: 0 !important;
    color: white !important;
    font-size: 10px !important;
    width: 100% !important;
    display: -webkit-box !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    word-wrap: break-word !important;
    hyphens: auto !important;
    border-bottom-left-radius: calc(var(--curve) * 1px) !important;
    border-bottom-right-radius: calc(var(--curve) * 1px) !important;
    backdrop-filter: blur(10px) opacity(80%) !important;
    -webkit-backdrop-filter: blur(5px) opacity(80%) !important;
}


.filler {
    display: none !important;
}

.projectDetailsBox {
    position: fixed !important;
    width: 100% !important;
    height: 100% !important;
    background-color: rgba(24, 24, 27, 0.8) !important;
    z-index: 101 !important;
    top: 0 !important;
    display: none !important;
    backdrop-filter: blur(10px) !important;
}

::-webkit-scrollbar {
    width: 10px !important;
}

::-webkit-scrollbar-track {
    background-color: #f1f1f1 !important;
}

::-webkit-scrollbar-thumb {
    background-color: #ccc !important;
    border-radius: 5px !important;
}

* {
    scrollbar-width: thin !important;
    scrollbar-color: #ccc #f1f1f1 !important;
}

*::-webkit-scrollbar-track {
    background-color: #f1f1f1 !important;
}

*::-webkit-scrollbar-thumb {
    background-color: #ccc !important;
    border-radius: 5px !important;
}

*::-webkit-scrollbar-thumb:hover {
    background-color: #aaa !important;
}

.projectDetails {
    width: 80% !important;
    height: 80% !important;
    position: absolute !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    background-color: #2B2B2D !important;
    border-radius: 10px !important;
}
.cardSearch {
    cursor: pointer;
    transition: transform 0.3s ease;
}

.topBar {
    height: 60px;
    width: 100vw;
    background-color: none;
    position: fixed;
    top: 10px;
    left: 0;
    z-index: 100;
}

body {
    margin: 0;
    padding: 0;
    font-family: 'Roboto Mono', monospace;

}

.tabs {
    width: 30%;
    background-color: none;
    display: flex;
    overflow-x: hidden;
    left: 50%;
    transform: translateX(-50%);
    position: absolute;
}

.mainBar {
    width: 100%;
    background-color: none;
    justify-content: center;
    display: flex;
}

.tab {
    padding: 7px;
    width: fit-content;
    display: inline-block;
    border-radius: 5px;
    background-color: #2B2B2D;
    backdrop-filter: blur(10px) opacity(80%);
    -webkit-backdrop-filter: blur(5px) opacity(80%);
    color: white;
    font-size: 13px;
    cursor: pointer;
    font-weight: bold;
    margin: 5px;
    border: solid 1px black;
    display: flex;
    flex-wrap: nowrap;
    white-space: nowrap;
}

.scroll-button {
    position: absolute;
    padding: 7px;
    font-size: 17px;
    background-color: #2B2B2D;
    border: none;
    cursor: pointer;
    z-index: 100;
    border-radius: 10px;
    padding-left: 15px;
    padding-right: 15px;
    transition: transform 0.3s ease;
    color: white;
    border: 1px solid black;
}

.scroll-button:hover {
    transform: scale(1.1);
}

.left {
    left: 31.5%;
    display: none;
}

.right {
    right: 31.5%;
}

.tabContainer {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    background-color: none;
    display: flex;
    left: 50%;
    transform: translateX(-50%);
    position: absolute;
    top: 110px;
}

.tab:hover {
    background-color: #3B3B3D;
    color: white;
}

.free {
    background-color: rgba(0, 128, 0, 0.8);
}

.monetized {
    background-color: rgba(255, 215, 0, 0.8);
}

.active {
    background-color: white;
    border: 1px solid #2B2B2D;
    color: black;
}

div .card__image {
    background-color: #2b2b2d;
    animation: colorSwitch 2s ease-in-out infinite;
}

@keyframes colorSwitch {
    0% {
        background-color: #2b2b2d;
    }

    50% {
        background-color: #333333;
    }

    100% {
        background-color: #2b2b2d;
    }
}

.card__open {
    background-color: #2b2b2d;
    width: 30px;
    height: 30px;
    border-radius: 10px;
    position: absolute;
    top: 20px;
    right: 20px;
    cursor: pointer;
    transition: transform 0.3s ease;
    padding: 8px;
    justify-content: center;
    display: flex;
}
        </style>
        `;

    function renderCard() {
        display = document.querySelector('.cards');
        display.innerHTML = "";
        display.innerHTML += css;
        display.innerHTML += card;
        display.innerHTML += filler;
        document.querySelector(".cardAlerts").innerHTML = ""

        var image = document.querySelector('.imageURL').value;
        if (isValidUrl(image) == true) {
            getImageSize(image)
                .then((size) => {
                    errors = [];
                    if (size['width'] == 600 && size['height'] == 500) {

                    } else {
                        errors.push('Image must be 600x500');
                    }
                    if (!image.includes('/user_assets/image.php?v=private%2F')) {

                    } else {
                        errors.push('Image must be public');
                    }
                    if (errors.length > 0) {} else {
                        var imageDisplay = document.querySelector('#card__image');
                        imageDisplay.src = image;
                    }


                })
                .catch((err) => {
                    console.error(err);
                });
        }
        var description = document.querySelector('.description').value;
        description = htmlEncode(description);
        var descriptionDisplay = document.querySelector('#card__description');
        descriptionDisplay.innerHTML = description;
    }
    description = document.querySelector('.description');
    description.addEventListener("keyup", function(event) {
        var description = document.querySelector('.description').value;
        description = htmlEncode(description);
        var descriptionDisplay = document.querySelector('#card__description');
        descriptionDisplay.innerHTML = description;
    });
    description.addEventListener("input", function(event) {
        var description = document.querySelector('.description').value;
        description = htmlEncode(description);
        var descriptionDisplay = document.querySelector('#card__description');
        descriptionDisplay.innerHTML = description;
    });
    imageURL = document.querySelector('.imageURL');
    imageURL.addEventListener("input", function(event) {
        document.querySelector(".cardAlerts").innerHTML = ""
        var image = document.querySelector('.imageURL').value;
        image1 = image.replace(/\s/g, "");
        image1 = image.trim();

        if (isValidUrl(image) == true) {
            getImageSize(image)
                .then((size) => {
                    errors = [];
                    if (size['width'] == 600 && size['height'] == 500) {

                    } else {
                        errors.push('Image must be 600x500');
                    }
                    if (!image1.includes('/user_assets/image.php?v=private%2F')) {

                    } else {
                        errors.push('Image must be public');
                    }
                    if (errors.length > 0) {
                        document.querySelector(".cardAlerts").innerText = errors.join('\n')
                    } else {
                        var imageDisplay = document.querySelector('#card__image');
                        imageDisplay.src = image;
                    }

                })
                .catch((err) => {
                    console.error(err);
                });
        }
    });
    imageURL.addEventListener("keyup", function(event) {
        document.querySelector(".cardAlerts").innerHTML = ""
        var image = document.querySelector('.imageURL').value;
        image1 = image.replace(/\s/g, "");
        image1 = image.trim();
        if (isValidUrl(image) == true) {
            getImageSize(image)
                .then((size) => {
                    errors = [];
                    if (size['width'] == 600 && size['height'] == 500) {

                    } else {
                        errors.push('Image must be 600x500');
                    }
                    if (!image1.includes('/user_assets/image.php?v=private%2F')) {

                    } else {
                        errors.push('Image must be public');
                    }
                    if (errors.length > 0) {
                        document.querySelector(".cardAlerts").innerText = errors.join('\n')
                    } else {
                        var imageDisplay = document.querySelector('#card__image');
                        imageDisplay.src = image;
                    }

                })
                .catch((err) => {
                    console.error(err);
                });
        }
    });

    function resetPublish() {
        var publishJSON = document.getElementById('publishJSON');
        publishJSON.value = "[]";
        renderPublish();
        savePublishResponse();
        publishCustomizationBox = document.querySelector('.publishCustomizationBox');
        publishCustomizationBox.innerHTML = `
        <div class="spaceCustomization"></div>
                <br>
                <br>
                <br>
                <div class="toolBar">
                    <button onclick="resetPublish()" type="reset">Reset</button>
                    <label for="">New section:</label>
                    <button onclick="addSection()">+</button>
                    <label for="">New subsection:</label>
                    <button onclick="addSubSection()">+</button>
                    <button id="savePublish" onclick="savePublishResponse(this)">Save</button>
                    <label for="">Update Card:</label>
                    <button
                        onclick="document.querySelector('.publishImageBox').style.display='block';renderCard()">+</button>
                </div>
        `;

    }

    function htmlEncode1(str) {
        var el = document.createElement("div");
        el.innerText = el.textContent = str;
        str = el.innerHTML;
        return str;
    }

    function htmlDecode1(str) {
        var el = document.createElement("div");
        el.innerHTML = str;
        str = el.innerText;
        return str;
    }

    function htmlEncode(str) {
        var el = document.createElement("div");
        el.innerText = el.textContent = str;
        str = el.innerHTML;
        str = str.replace(/\{/g, '&#123;').replace(/\}/g, '&#125;'); // Replace { and } with HTML entities
        str = str.replace(/\[/g, '&#91;').replace(/\]/g, '&#93;'); // Replace [ and ] with HTML entities
        str = str.replace(/\'/g, '&#39;'); // Replace ' with HTML entity
        str = str.replace(/\"/g, '&quot;'); // Replace " with HTML entity
        return str;
    }

    function htmlDecode(str) {
        var el = document.createElement("div");
        el.innerHTML = str;
        str = el.innerText;
        str = str.replace(/&#123;/g, '{').replace(/&#125;/g, '}'); // Replace HTML entities with { and }
        str = str.replace(/&#91;/g, '[').replace(/&#93;/g, ']'); // Replace HTML entities with [ and ]
        str = str.replace(/&#39;/g, '\''); // Replace HTML entity with '
        str = str.replace(/&quot;/g, '"'); // Replace HTML entity with "
        return str;
    }



    function loadPublishSettingsFromJSON() {
        stuff = document.querySelector('.publishCustomizationBox')
        data1 = JSON.parse(document.querySelector('#publishJSON').value);
        for (let i = 0; i < data1.length; i++) {
            // Define the event handler function
            sectionInput = (event) => {
                publishJSON = JSON.parse(document.getElementById("publishJSON").value);
                var position = event.target.getAttribute("position");
                var encodedValue = htmlEncode(event.target.value.replace(/"/g, '\"'));
                var escapedValue = htmlEncode(encodedValue)
                publishJSON[position]['title'] = escapedValue;
                document.getElementById("publishJSON").value = JSON.stringify(publishJSON);
                renderPublish();
            }
            debouncedSectionInput = debounce(sectionInput, 1000);

            stuff.innerHTML += `<div class="sectionBox" style="margin-bottom:10px" id="section` + i +
                `"><label>Section ` + (i + 1) +
                `:</label><input  placeholder="Enter title..." class="sectionInput" oninput="debouncedSectionInput(event)" onkeyup="debouncedSectionInput(event)" value="` +
                data1[i]['title'] + `" id="section` + i +
                `Input" position="` +
                i + `"/></div>`;


            for (let j = 0; j < data1[i].subSections.length; j++) {
                // Define publishJSONInputHandler and debouncedPublishJSONInputHandler
                publishJSONInputHandler = (event) => {
                    console.log("hi");
                    publishJSONElement = document.getElementById("publishJSON");
                    publishJSON = JSON.parse(publishJSONElement.value);
                    position = event.target.getAttribute("position");
                    position1 = event.target.getAttribute("position1");
                    var encodedValue = htmlEncode(event.target.value.replace(/"/g, '\"'));
                    escapedValue = htmlEncode(encodedValue);
                    publishJSON[position1 - 1].subSections[position].title = escapedValue;
                    publishJSONElement.value = JSON.stringify(publishJSON);
                    renderPublish();
                };

                debouncedPublishJSONInputHandler = debounce(publishJSONInputHandler, 1000);
                if (data1[i].subSections[j].info[0].type == "text") {
                    text = "selected";
                    html = "";
                    code = "";
                } else if (data1[i].subSections[j].info[0].type == "html") {
                    text = "";
                    html = "selected";
                    code = "";
                } else if (data1[i].subSections[j].info[0].type == "code") {
                    text = "";
                    html = "";
                    code = "selected";
                }
                stuff1 = `<div style="margin-bottom:10px" class="subSectionBox" id="subSection` + (i + 1) + j +
                    `"><label>Subsection ` + (j + 1) +
                    `:</label><input class="subSectionInput" placeholder="Enter subtitle..." oninput="debouncedPublishJSONInputHandler(event)" onkeyup="debouncedPublishJSONInputHandler(event)" value="` +
                    htmlDecode1(data1[i].subSections[j][
                        'title'
                    ]) + `" id="subSection` + (i + 1) +
                    j + `Input" position1="` + (i + 1) + `" position="` + j + `"/> 
            <label>Type:</label>
            <select class="subSectionType" id="subSectionType` + (i + 1) + j + `" position="` + i + `" position1="` +
                    j + `"> 
            <option ` + text + ` value="text">Text</option>
            <option ` + html + ` value="html">HTML</option>
            <option ` + code + ` value="code">Code</option>
            </select>
            `;
                stuff1 += '<button class="typeBtn" style="width:30px" onclick="addInfo(`' +
                    (i + 1) + '`,`' + j +
                    '`,document.getElementById(`' + "subSectionType" + (i + 1) + j +
                    '`).value);"><svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path fill="black" d="M105.1 202.6c7.7-21.8 20.2-42.3 37.8-59.8c62.5-62.5 163.8-62.5 226.3 0L386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H463.5c0 0 0 0 0 0h.4c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0C73.2 122 55.6 150.7 44.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5zM39 289.3c-5 1.5-9.8 4.2-13.7 8.2c-4 4-6.7 8.8-8.1 14c-.3 1.2-.6 2.5-.8 3.8c-.3 1.7-.4 3.4-.4 5.1V448c0 17.7 14.3 32 32 32s32-14.3 32-32V396.9l17.6 17.5 0 0c87.5 87.4 229.3 87.4 316.7 0c24.4-24.4 42.1-53.1 52.9-83.7c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.5 62.5-163.8 62.5-226.3 0l-.1-.1L125.6 352H176c17.7 0 32-14.3 32-32s-14.3-32-32-32H48.4c-1.6 0-3.2 .1-4.8 .3s-3.1 .5-4.6 1z"/></svg></button></div>';
                stuff.innerHTML += stuff1;
                input1 = document.getElementById(`subSection${i + 1}${j}Input`);


                for (let k = 0; k < data1[i].subSections[j].info.length; k++) {
                    // Define publishJSONInputHandler and debouncedPublishJSONInputHandler
                    textareaFunc = (event) => {
                        var publishJSON = document.getElementById("publishJSON");
                        publishJSON = JSON.parse(publishJSON.value);
                        var encodedValue = htmlEncode(event.target.value.replace(/"/g, '\"'));
                        var escapedValue = htmlEncode(encodedValue)
                        var position = event.target.getAttribute("position");
                        var position1 = event.target.getAttribute("position1");
                        publishJSON[position]['subSections'][position1]['info'][0]['content'] =
                            escapedValue
                        document.getElementById("publishJSON").value = JSON.stringify(publishJSON);
                        renderPublish();
                    };

                    debouncedTextareaFunc = debounce(textareaFunc, 1000);
                    if (data1[i].subSections[j].info[k].type == 'html') {
                        content = data1[i].subSections[j].info[0].content.replace(/<br>/g, '\n');
                        content = htmlDecode1(content);
                        stuff.innerHTML += `<textarea position1="` + j + `" position="` + i +
                            `" oninput="debouncedTextareaFunc(event)" onkeyup="debouncedTextareaFunc(event)" class="htmlInput" id="info` +
                            (i + 1) + j +
                            `" style="width:100%;height:100px">` + content + `</textarea>`;

                    } else if (data1[i].subSections[j].info[
                            k].type == 'text') {
                        content = data1[i].subSections[j].info[0].content.replace(/<br>/g, '\n');
                        content = htmlDecode1(content);
                        stuff.innerHTML += `<textarea position1="` + j + `" position="` + i +
                            `" oninput="debouncedTextareaFunc(event)"  onkeyup="debouncedTextareaFunc(event)" class="textInput" id="info` +
                            (i + 1) + j +
                            `" style="width:100%;height:100px">` + content + `</textarea>`;
                    } else if (data1[i].subSections[j].info[k].type == 'code') {
                        content = data1[i].subSections[j].info[0].content.replace(/<br>/g, '\n');
                        content = htmlDecode1(content);
                        stuff.innerHTML += `<textarea position1="` + j + `" position="` + i +
                            `"  oninput="debouncedTextareaFunc(event)" onkeyup="debouncedTextareaFunc(event)" class="codeInput" id="info` +
                            (i + 1) + j +
                            `" style="width:100%;height:100px">` + content + `</textarea>`;
                    }


                }
            }
        }
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                timeout = null;
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }


    function keyup() {
        var publishJSON = document.getElementById("publishJSON");
        publishJSON = JSON.parse(publishJSON.value);
        var encodedValue = htmlEncode(editor.getValue().replace(/"/g, '\"'));
        var escapedValue = htmlEncode(encodedValue)

        publishJSON[i]['subSections'][j]['info'][k]['content'] =
            escapedValue
        document.getElementById("publishJSON").value = JSON.stringify(publishJSON);
        renderPublish();
    };


    function renderPublish() {

        var publishJSON = document.getElementById("publishJSON");
        publishJSON = JSON.parse(publishJSON.value);
        var publishShowBox = document.querySelector(".publishShowBox");
        publishShowBox.style.wordWrap = "break-word";
        publishShowBox.style.overflowWrap = "break-word";
        publishShowBox.innerHTML = "<h2>Getting Started</h2>";
        for (var i = 0; i < publishJSON.length; i++) {
            var section = document.createElement("div");
            section.classList.add("sectionRendered");
            section.innerHTML = "<h2>" + htmlDecode(publishJSON[i]['title']) + "</h2>";
            for (var j = 0; j < publishJSON[i]['subSections'].length; j++) {
                var subSection = document.createElement("div");
                subSection.classList.add("subSectionRendered");
                subSection.innerHTML = "<h3>" + htmlDecode(publishJSON[i]['subSections'][j]['title']) + "</h3>";
                for (var k = 0; k < publishJSON[i]['subSections'][j]['info'].length; k++) {
                    var info = document.createElement("div");
                    info.style.width = "100%";
                    info.style.position = "relative";
                    info.classList.add("infoRendered");
                    if (publishJSON[i]['subSections'][j]['info'][k]['type'] == "text") {
                        info.innerHTML += "<p class='text'>" + htmlDecode(publishJSON[i]['subSections'][j]['info'][k][
                                'content'
                            ]) +
                            "</p>";
                    } else if (publishJSON[i]['subSections'][j]['info'][k]['type'] == "code") {
                        info.innerHTML += "<pre class='code'><code>" + htmlDecode(publishJSON[i]['subSections'][j][
                                'info'
                            ][k][
                                'content'
                            ]) +
                            "</code></pre>";
                    } else if (publishJSON[i]['subSections'][j]['info'][k]['type'] == "html") {
                        info.innerHTML +=
                            "<pre class='html' style=''>" +
                            htmlDecode(htmlDecode1(publishJSON[i]['subSections'][j]['info'][k]['content'])) + "</pre>";
                    }
                    subSection.appendChild(info);
                }
                section.appendChild(subSection);
            }
            publishShowBox.appendChild(section);
        }

        // Get all elements with class code
        const codeElements = document.querySelectorAll('.code');

        // Loop through each code element
        codeElements.forEach((codeElement) => {
            // Create a button
            const copyButton = document.createElement('button');
            copyButton.innerHTML =
                '<svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1.25em" width="1.25em" xmlns="http://www.w3.org/2000/svg"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>';
            copyButton.style.position = 'absolute';
            copyButton.style.top = '10px';
            copyButton.style.right = '10px';
            copyButton.style.border = 'none';
            copyButton.style.background = 'none';
            copyButton.style.cursor = 'pointer';
            copyButton.querySelector('svg').style.stroke = 'white';

            // Add click event listener to button
            copyButton.addEventListener('click', () => {
                // Get the code content
                const codeContent = codeElement.querySelector('code').innerText;

                // Create a textarea element and set its value to the code content
                const textarea = document.createElement('textarea');
                textarea.value = codeContent;

                // Append the textarea to the body
                document.body.appendChild(textarea);

                // Select the textarea and copy its content
                textarea.select();
                document.execCommand('copy');

                // Remove the textarea from the body
                document.body.removeChild(textarea);

                // Change button text to "Copied" for 2 seconds
                copyButton.innerHTML =
                    '<svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1.25em" width="1.25em" xmlns="http://www.w3.org/2000/svg"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                copyButton.querySelector('svg').style.stroke = 'white';
                setTimeout(() => {
                    copyButton.innerHTML =
                        '<svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1.25em" width="1.25em" xmlns="http://www.w3.org/2000/svg"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>';
                    copyButton.querySelector('svg').style.stroke = 'white';
                }, 2000);
            });

            // Append the button to the code element
            codeElement.appendChild(copyButton);
        });

        // Disable all links

        var allLinks = publishShowBox.getElementsByTagName('a');
        for (var i = 0; i < allLinks.length; i++) {
            allLinks[i].href = '';
        }

        // Disable all forms
        var allForms = publishShowBox.getElementsByTagName('form');
        for (var i = 0; i < allForms.length; i++) {
            allForms[i].addEventListener('submit', function(event) {
                event.preventDefault();
                event.stopPropagation();
            });
        }

        // Disable all buttons and input[type="submit"]
        var allButtons = publishShowBox.getElementsByTagName('button');
        var allInputSubmits = publishShowBox.querySelectorAll('input[type="submit"]');
        var allSubmitters = Array.prototype.slice.call(allButtons).concat(Array.prototype.slice.call(allInputSubmits));

        for (var i = 0; i < allSubmitters.length; i++) {
            allSubmitters[i].addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
            });
        }
        // Get all JavaScript elements within the div
        jsElements = publishShowBox.querySelectorAll('script');

        // Loop through each JavaScript element and disable it
        jsElements.forEach(jsElement => {
            jsElement.disabled = true;
        });
        // Get all elements within the div
        allElements = publishShowBox.getElementsByTagName('*');

        // List of all trigger attributes to remove
        var triggerAttrs = ['onclick', 'ondblclick', 'onmousedown', 'onmouseup', 'onmouseover', 'onmousemove',
            'onmouseout', 'onmouseenter', 'onmouseleave', 'onkeydown', 'onkeypress', 'onkeyup', 'onabort',
            'onerror', 'onload', 'onresize', 'onscroll', 'onunload', 'onblur', 'onchange', 'onfocus', 'onreset',
            'onsubmit'
        ];


        // Loop through each element and remove the trigger attributes
        for (let i = 0; i < allElements.length; i++) {
            const element = allElements[i];
            for (let j = 0; j < triggerAttrs.length; j++) {
                element.removeAttribute(triggerAttrs[j]);
            }
        }
        // Get all <a> tags within the div
        allATags = publishShowBox.getElementsByTagName('a');

        for (let i = 0; i < allATags.length; i++) {
            const aTag = allATags[i];
            const divTag = document.createElement('div');
            divTag.innerHTML = aTag.innerHTML;
            const computedStyle = window.getComputedStyle(aTag);
            for (let j = 0; j < computedStyle.length; j++) {
                const cssPropName = computedStyle[j];
                divTag.style[cssPropName] = computedStyle.getPropertyValue(cssPropName);
            }
            aTag.parentNode.replaceChild(divTag, aTag);
        }
        styles = publishShowBox.querySelectorAll('style');
        styles.forEach(style => {
            publishShowBox.style.cssText += style.innerHTML;
            style.remove();
        });
        links = publishShowBox.querySelectorAll('link'); // select all link elements inside the div

        links.forEach(link => {
            link.remove(); // remove the link element from the div
        });
        var elements = publishShowBox.getElementsByTagName("*");
        for (var i = 0; i < elements.length; i++) {
            if (elements[i].style.position == "fixed") {
                elements[i].style.position = "absolute";
            }
        }
        allowedWebsites = ['https://spankbang.com', 'https://cdpn.io', '<?php echo $website;?>',
            'https://codepen.io'
        ]; // list of allowed websites

        iframes = publishShowBox.querySelectorAll('iframe'); // select all iframe elements inside the div

        iframes.forEach(iframe => {
            const src = iframe.getAttribute('src');
            if (!allowedWebsites.some(url => src.startsWith(url))) {
                iframe.remove();
            }
        });


    }

    function addSection() {
        var publishJSON = document.getElementById("publishJSON");
        var publishCustomizationBox = document.querySelector(".publishCustomizationBox");
        publishJSON = JSON.parse(publishJSON.value);
        console.log(publishJSON);
        if (publishJSON.length != 0) {
            if (publishJSON[publishJSON.length - 1]['subSections'].length == 0) {
                return;
            }
            if (publishJSON[publishJSON.length - 1]['subSections'][publishJSON[publishJSON.length - 1]['subSections']
                    .length - 1
                ]['info'].length == 0) {
                return;
            }
        }
        var newSection = document.createElement("div");
        newSection.id = "section" + publishJSON.length;
        newSection.classList.add("section");
        newSection.innerHTML = '<label for="">Section ' + (publishJSON.length + 1) +
            ':</label><input type="text" position="' + publishJSON.length +
            '" class="sectionInput"  placeholder="Enter title..." id="section' +
            publishJSON.length + 'Input">';

        publishCustomizationBox.appendChild(newSection);
        // Get the input element
        input = document.getElementById("section" + publishJSON.length + "Input");

        // Define the event handler function
        function handleKeyUp(event) {
            var publishJSON = document.getElementById("publishJSON");
            publishJSON = JSON.parse(publishJSON.value);
            var position = event.target.getAttribute("position");
            var encodedValue = htmlEncode(event.target.value.replace(/"/g, '\"'));
            var escapedValue = htmlEncode(encodedValue)
            publishJSON[position]['title'] = escapedValue;
            publishJSON = JSON.stringify(publishJSON);
            document.getElementById("publishJSON").value = publishJSON;
            renderPublish();
        }

        // Add a debounced keyup event listener to the input element
        input.addEventListener("keyup", debounce(handleKeyUp, 1000));
        input.addEventListener("input", debounce(handleKeyUp, 1000));

        publishJSON.push({
            "title": "",
            "subSections": []
        });

        publishJSON = JSON.stringify(publishJSON);

        document.getElementById("publishJSON").value = publishJSON;

        renderPublish();
    }

    function addSubSection() {
        var publishJSON = document.getElementById("publishJSON");
        var publishCustomizationBox = document.querySelector(".publishCustomizationBox");
        publishJSON = JSON.parse(publishJSON.value);
        console.log(publishJSON);
        if (publishJSON[publishJSON.length - 1]['subSections'].length != 0) {

            if (publishJSON[publishJSON.length - 1]['subSections'][publishJSON[publishJSON.length - 1]['subSections']
                    .length - 1
                ]['info'].length == 0) {
                return;
            }
        }
        var newSubSection = document.createElement("div");
        newSubSection.id = "subSection" + publishJSON.length + publishJSON[publishJSON.length - 1]['subSections']
            .length;
        newSubSection.classList.add("subSection");
        newSubSection.innerHTML = '<label for="">Subsection ' + (publishJSON[publishJSON.length - 1]['subSections']
                .length + 1) + ':</label><input type="text" position="' + publishJSON[publishJSON.length - 1][
                'subSections'
            ]
            .length + '" position1="' + publishJSON.length +
            '"   placeholder="Enter subtitle..." class="subSectionInput" id="subSection' + publishJSON
            .length + publishJSON[publishJSON.length - 1]['subSections'].length +
            'Input"><label for="">Type:</label><select class="subSectionType" name="" id="' + "subSectionType" +
            publishJSON.length +
            publishJSON[publishJSON.length - 1]['subSections']
            .length +
            '"><option value="text">Text</option> <option value="html">HTML</option><option value="code">Code</option></select><button style="width:30px" onclick="addInfo(`' +
            publishJSON.length + '`,`' + publishJSON[publishJSON.length - 1]['subSections'].length +
            '`,document.getElementById(`' + "subSectionType" + publishJSON.length + publishJSON[publishJSON.length - 1][
                'subSections'
            ]
            .length +
            '`).value);" class="typeBtn"><svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path fill="black" d="M105.1 202.6c7.7-21.8 20.2-42.3 37.8-59.8c62.5-62.5 163.8-62.5 226.3 0L386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H463.5c0 0 0 0 0 0h.4c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0C73.2 122 55.6 150.7 44.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5zM39 289.3c-5 1.5-9.8 4.2-13.7 8.2c-4 4-6.7 8.8-8.1 14c-.3 1.2-.6 2.5-.8 3.8c-.3 1.7-.4 3.4-.4 5.1V448c0 17.7 14.3 32 32 32s32-14.3 32-32V396.9l17.6 17.5 0 0c87.5 87.4 229.3 87.4 316.7 0c24.4-24.4 42.1-53.1 52.9-83.7c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.5 62.5-163.8 62.5-226.3 0l-.1-.1L125.6 352H176c17.7 0 32-14.3 32-32s-14.3-32-32-32H48.4c-1.6 0-3.2 .1-4.8 .3s-3.1 .5-4.6 1z"/></svg></button>';

        publishCustomizationBox.appendChild(newSubSection);
        publishJSONInputHandler = (event) => {
            publishJSONElement = document.getElementById("publishJSON");
            publishJSON = JSON.parse(publishJSONElement.value);
            position = event.target.getAttribute("position");
            position1 = event.target.getAttribute("position1");
            var encodedValue = htmlEncode(event.target.value.replace(/"/g, '\"'));
            var escapedValue = htmlEncode(encodedValue)
            publishJSON[position1 - 1]['subSections'][position]['title'] = escapedValue;
            publishJSONElement.value = JSON.stringify(publishJSON);
            renderPublish();
        };

        publishJSONInput = document.getElementById("subSection" + publishJSON.length + publishJSON[publishJSON
            .length - 1]['subSections'].length + "Input");
        debouncedPublishJSONInputHandler = debounce(publishJSONInputHandler, 1000);

        publishJSONInput.addEventListener("keyup", debouncedPublishJSONInputHandler);
        publishJSONInput.addEventListener("input", debouncedPublishJSONInputHandler);

        publishJSON[publishJSON.length - 1]['subSections'].push({
            "title": "",
            "info": []
        });
        publishJSON = JSON.stringify(publishJSON);
        document.getElementById("publishJSON").value = publishJSON;
        renderPublish();
    }

    function addInfo(section_id, subSection_id, type) {
        var publishJSON = document.getElementById("publishJSON");
        var publishCustomizationBox = document.querySelector(".publishCustomizationBox");
        publishJSON = JSON.parse(publishJSON.value);
        console.log(publishJSON);
        if (publishJSON[section_id - 1]['subSections'][subSection_id].length != 0) {
            if (publishJSON[section_id - 1]['subSections'][subSection_id]['info'].length != 0) {
                document.getElementById("info" + section_id + subSection_id).classList = [];
                document.getElementById("info" + section_id + subSection_id).classList.add(type + "Input");
                publishJSON[section_id - 1]['subSections'][subSection_id]['info'][0]['type'] = type;
                publishJSON = JSON.stringify(publishJSON);
                document.getElementById("publishJSON").value = publishJSON;
                renderPublish();
                return;

            }
        }

        if (type == "text") {
            var newInfo = document.createElement("textarea");
            newInfo.rows = "4"
            newInfo.cols = "40"
            newInfo.id = "info" + section_id + subSection_id;
            newInfo.classList.add(type + "Input");
            parentSubSection = document.getElementById("subSection" + section_id + subSection_id);
            parentSubSection.insertAdjacentElement("afterend", newInfo);

        } else if (type == "html") {
            var newInfo = document.createElement("textarea");
            newInfo.rows = "4"
            newInfo.cols = "40"
            newInfo.id = "info" + section_id + subSection_id;
            newInfo.classList.add(type + "Input");
            parentSubSection = document.getElementById("subSection" + section_id + subSection_id);
            parentSubSection.insertAdjacentElement("afterend", newInfo);

        } else if (type == "code") {
            var newInfo = document.createElement("textarea");
            newInfo.rows = "4"
            newInfo.cols = "40"
            newInfo.id = "info" + section_id + subSection_id;
            newInfo.classList.add(type + "Input");
            parentSubSection = document.getElementById("subSection" + section_id + subSection_id);
            parentSubSection.insertAdjacentElement("afterend", newInfo);

        }
        var editor = CodeMirror.fromTextArea(document.getElementById("info" + section_id + subSection_id), {
            lineNumbers: true,
            lineWrapping: true,
            mode: "text",
            theme: "dracula",
            scrollbarStyle: "simple",
            autoCloseBrackets: true,
            extraKeys: {
                "Alt-F": "findPersistent"
            },
            highlightSelectionMatches: {
                showToken: /\w/,
                annotateScrollbar: true
            },
            extraKeys: {
                "F11": function(cm) {
                    cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                },
                "Esc": function(cm) {
                    if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                }
            }
        });
        editor.setSize("100%", "150px");
        publishJSON[section_id - 1]['subSections'][subSection_id]['info'].push({
            "type": type,
            "content": ""
        });
        document.getElementById("publishJSON").value = JSON.stringify(publishJSON);

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    timeout = null;
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function keyup() {
            var publishJSON = document.getElementById("publishJSON");
            publishJSON = JSON.parse(publishJSON.value);
            var encodedValue = htmlEncode(editor.getValue().replace(/"/g, '\"'));
            var escapedValue = htmlEncode(encodedValue)
            publishJSON[section_id - 1]['subSections'][subSection_id]['info'][0]['content'] =
                escapedValue
            document.getElementById("publishJSON").value = JSON.stringify(publishJSON);
            renderPublish();
        };

        editor.on("keyup", debounce(keyup, 1000));
        editor.on("input", debounce(keyup, 1000));

        renderPublish();

    }
    publishEditorH1 = document.querySelector(".publishEditor h1");
    all = '<?php echo json_encode($manifest);?>';
    all = JSON.parse(all);
    document.getElementsByTagName("title")[0].innerHTML =
        "(<?php echo count($manifest);?>) '<?php echo $row['title'];?>' Versions - CodeConnect"
    title = '<?php echo $row['title'];?>';
    publishEditor = document.querySelector(".publishEditor");
    publishEditorBox = document.querySelector(".publishEditorBox");

    publishEditorBox.addEventListener("click", function() {
        document.querySelector(".publishEditorBox").style.display = "none";
        publishShowBox = document.querySelector(".publishShowBox");
        publishShowBox.innerHTML = "";
    })

    function publishDetailsUpdate() {
        publishEditorBox = document.querySelector(".publishEditorBox");
        publishEditorBox.style.display = "flex";
        renderPublish();
    }
    </script>
    <div class="grid">
        <?php
		function formatDate($inputDate) {
			$timestamp = strtotime($inputDate);
			$formattedDate = date('jS F Y g:ia', $timestamp);
			return $formattedDate;
		}
		
		$versionNumbers = array();
		foreach ($manifest as $version => $details) {
			$versionNumbers[]=$version;
		}
		require "versionTagColors.php";
		$i=0;
		$current=false;

		foreach ($manifest as $version => $details) {
			foreach ($details as $detail) {
				if ($i == count($manifest)-1){
					$current=true;
					$color = $versionNumberColors[$version];
					if($detail['status'] == 'unlisted') {
						$colorBorder="128, 128, 128";
					  }elseif($detail['status'] == 'private') {
						$colorBorder="255, 0, 0";
					  }elseif($detail['status'] == 'public') {
						$colorBorder="0, 128, 0";
					  }elseif($detail['status'] == 'monetized') {
						$colorBorder="255, 215, 0";
					  }elseif($detail['status'] == null) {
						$colorBorder="255, 0, 0";
					  }
					require "versionModules.php";
				}
				$i++;				

				
			}
		}

		$i=0;
		$current=false;

		foreach ($manifest as $version => $details) {
			foreach ($details as $detail) {
				if ($i == count($manifest)-1){
					break;
				}
				if($detail['status'] == 'unlisted') {
					$colorBorder="128, 128, 128";
				  }elseif($detail['status'] == 'private') {
					$colorBorder="255, 0, 0";
				  }elseif($detail['status'] == 'public') {
					$colorBorder="0, 128, 0";
				  }elseif($detail['status'] == 'monetized') {
					$colorBorder="255, 215, 0";
				  }elseif($detail['status'] == null) {
					$colorBorder="255, 0, 0";
				  }
				$color = $versionNumberColors[$version];
				require "versionModules.php";
				$i++;
			}
		}
		
		?>
        <div class="card filler"></div>
        <div class="card filler"></div>
        <div class="card filler"></div>

    </div>
    <div id="confirmation" onclick="this.style.display='none'">
        <div id="confirmationBox" onclick="event.stopPropagation();">
            <h3>Review Changes</h3>
            <div class="showChanges"></div>
            <button id="confirmSave">Confirm</button>
            <button onclick="closeConfirmation()" id="cancelSave">Cancel</button>
        </div>
    </div>
    <div id="versionOptions" onclick="this.style.display='none'">
        <div id="versionOptionsBox" onclick="event.stopPropagation();">

            <div class="optionsSection">
                <h3 class="versionNumber">Version</h3>
                <h3>Options</h3>
                <div class="options">
                    <p>Change Status:</p>
                    <select id="statusOptions">
                        <option value="unlisted">Unlisted</option>
                        <option value="private">Private</option>
                        <option value="public">Public</option>
                        <option value="monetized">Monetized</option>
                    </select>
                    <p>Authorized Websites:</p>
                    <input class="authorizedWebsite" style="display:inline-block" type="text"
                        placeholder="Authorized Websites">
                    <input type="hidden" id="authWebsites">
                    <button id="authAdd" onclick="addAuthWebsite()" style="display:inline-block">+</button>
                    <div class="info showAuthWebsites"></div>
                    <p>Creation Date:</p>
                    <p class="info creationDate"></p>
                    <p>Last Edited:</p>
                    <p class="info lastEditedDate"></p>
                    <p>Release Date:</p>
                    <p class="info releaseDate"></p>
                    <p>Libraries:</p>
                    <input type="text" placeholder="Libraries">
                    <br>
                    <button id="updateManifest">Save</button>

                </div>
                <div style="width:100%;height:30px;position:fixed;
        top: 10px;
        left: 10px;">
                    <button onclick="closeOptions()"
                        style="float:right;background:none;border:none;color:white;font-size:40px;cursor:pointer;">&times;</button>
                </div>
            </div>
        </div>
        <input type="hidden" id="selectedVersion">
        <script>
        window.addEventListener("load", function() {
            const loader = document.querySelector("#loading-screen");
            loader.style.visibility = "hidden";
        });

        function closeConfirmation() {
            document.querySelector("#confirmation").style.display = "none";
        }



        function addAuthWebsite() {
            var authWebsite = document.querySelector(".authorizedWebsite").value;
            if (isValidUrl(authWebsite) == false) {
                alert("Invalid URL");
                return;
            }

            version = document.querySelector("#selectedVersion").value;
            authWebsites = document.querySelector("#authWebsites").value;
            authWebsitesArr = authWebsites.split(",");
            if (authWebsitesArr.includes(authWebsite.trim())) {
                alert("This website is already authorized");
                return;
            }
            if (authWebsites == "") {
                authWebsites = authWebsite;
            } else {
                authWebsites = authWebsites + "," + authWebsite;
            }
            amount = authWebsites.split(",").length;
            document.querySelector("#authWebsites").value = authWebsites;
            document.querySelector(".showAuthWebsites").innerHTML += "<div id='authWebsite" + amount +
                "'><p style='display:inline-block'>" + authWebsite + "</p><button onclick='removeAuthWebsite(`" +
                authWebsite + "`)' style='display:inline-block;cursor:pointer'>-</button></div> ";
        }

        function removeEventListeners(elem) {
            var elemClone = elem.cloneNode(true);
            elem.parentNode.replaceChild(elemClone, elem);
        }

        function removeAuthWebsite(authWebsite) {
            version = document.querySelector("#selectedVersion").value;
            authWebsites = document.querySelector("#authWebsites").value;
            authWebsites = authWebsites.split(",");
            allAuthSites = document.querySelector(".showAuthWebsites")
            i = 0;
            allAuthSites.querySelectorAll("div").forEach(function(div) {
                if (div.querySelector("p").innerText == authWebsite) {
                    div.remove();
                    authWebsites.splice(i, 1);
                    i++;
                }
            });
            authWebsites = authWebsites.join(",");
            amount = authWebsites.split(",").length;
            document.querySelector("#authWebsites").value = authWebsites;
        }

        function closeOptions() {
            document.getElementById("versionOptions").style.display = "none";
        }

        function isValidUrl(url) {
            try {
                new URL(url);
                return true;
            } catch (error) {
                return false;
            }
        }

        function makeApiRequest(method, url, data) {
            return new Promise(function(resolve, reject) {
                const xhr = new XMLHttpRequest();
                xhr.open(method, url);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        resolve(xhr.response);
                    } else {
                        reject(new Error(
                            `API request failed with status ${xhr.status}: ${xhr.statusText}`
                        ));
                    }
                };
                xhr.onerror = function() {
                    reject(new Error('API request failed due to a network error.'));
                };
                xhr.send(JSON.stringify(data));
            });
        }

        function openOptionsMenu(version) {
            document.getElementById("versionOptions").style.display = "block";
            status = all[version][0]['status'];
            authorized_websites = all[version][0]['authorized_websites'];
            creation_date = all[version][0]['creation_date'];
            last_edited = all[version][0]['last_edited'];
            release_date = all[version][0]['release_date'];
            libraries = all[version][0]['libraries'];
            updateManifest = document.getElementById("updateManifest");

            updateManifest.addEventListener("click", updateManifestFunc);

            function updateManifestFunc() {
                if (document.getElementById("authWebsites").value.trim() == "") {
                    manifestAuthWebsites = [];
                } else {
                    manifestAuthWebsites = document.getElementById("authWebsites").value.trim().split(",");
                }
                manifestStatus = document.getElementById("statusOptions").value;
                data = {
                    "version": version,
                    "authWebsites": manifestAuthWebsites,
                    "status": manifestStatus
                }
                legacyManifest = {
                    "version": version,
                    "authWebsites": authorized_websites,
                    "status": status
                }

                function checkChanges(data, legacyManifest) {
                    showChanges = document.querySelector(".showChanges");
                    showChanges.innerHTML = "";
                    changed = false;
                    if (data['status'] == "monetized" && legacyManifest['status'] != "monetized") {
                        showChanges.innerHTML += "<p>Monetize '" + title + "'</p>";
                        changed = true;
                    } else {
                        if (data["status"] != legacyManifest["status"]) {
                            showChanges.innerHTML += "<p>Status changed from " + legacyManifest["status"] + " to " +
                                data["status"] + "</p>";
                            changed = true;
                        }
                    }

                    if (data["authWebsites"] != legacyManifest["authWebsites"]) {
                        for (var i = 0; i < data["authWebsites"].length; i++) {
                            if (legacyManifest["authWebsites"].includes(data["authWebsites"][i]) == false) {
                                showChanges.innerHTML += "<p>Added: " + data["authWebsites"][i] + "</p>";
                                changed = true;
                            }
                        }

                        for (var i = 0; i < legacyManifest["authWebsites"].length; i++) {
                            if (data["authWebsites"].includes(legacyManifest["authWebsites"][i]) == false) {
                                showChanges.innerHTML += "<p>Removed: " + legacyManifest["authWebsites"][i] + "</p>";
                                changed = true;
                            }
                        }
                    }

                    if (!changed) {
                        showChanges.innerHTML = "<p>No changes made.</p>";
                    }
                    document.getElementById("confirmation").style.display = "block";
                    return changed;
                }
                if (checkChanges(data, legacyManifest)) {
                    document.querySelector("#confirmSave").addEventListener("click", function() {
                        console.log("Saving changes");
                        method = "POST";
                        baseUrl = window.location.protocol + "//" + window.location.hostname;
                        url = baseUrl + "/api/private/edit_manifest_js/";
                        data.api_token = '<?php echo $_SESSION['api_token']; ?>';
                        data.uid = '<?php echo $_SESSION['uid']; ?>';
                        data.script_id = '<?php echo $_GET['script_id']; ?>';
                        data.oldStatus = status;

                        function saveScriptId(response) {
                            console.log(response);
                            response = JSON.parse(response);
                            if (response.success) {
                                document.querySelector(".showChanges").innerHTML = "<p>Changes saved.</p>";
                            } else {
                                document.querySelector(".showChanges").innerHTML =
                                    "<p>Error - Changes not saved.</p>";
                            }
                        }
                        makeApiRequest(method, url, data)
                            .then(saveScriptId)
                            .catch((error) => console.error(error));
                    });
                } else {
                    removeEventListeners(document.querySelector("#confirmSave"));
                }
            }
            document.querySelector(".creationDate").innerText = creation_date;
            document.querySelector(".showAuthWebsites").innerHTML = "";
            for (var i = 0; i < authorized_websites.length; i++) {
                document.querySelector(".showAuthWebsites").innerHTML +=
                    "<div id='authWebsite" + i + "'><p style='display:inline-block'>" + authorized_websites[i] +
                    "</p><button onclick='removeAuthWebsite(`" + authorized_websites[i] +
                    "`)' style='display:inline-block;cursor:pointer'>-</button></div> ";
            }
            document.getElementById("selectedVersion").value = version;
            document.getElementById("authWebsites").value = authorized_websites.join(",");
            document.querySelector(".authorizedWebsite").value = "";
            document.querySelector(".lastEditedDate").innerText = last_edited;
            document.querySelector(".releaseDate").innerText = release_date;
            // Get the select element and its options
            var select = document.getElementById("statusOptions");
            var options = select.options;

            // Loop through the options and find the matching value
            for (var i = 0; i < options.length; i++) {
                if (options[i].value == status) {
                    // Set the selected attribute of the matching option
                    options[i].selected = true;
                    break;
                }
            }
            document.querySelector(".optionsSection > .versionNumber").innerText = version;

        }

        window.onload = function() {
            document.querySelector('.imageURL').value = "<?php echo $row['publish_image']; ?>";
            document.querySelector('.description').value = htmlDecode("<?php echo $row['publish_description']; ?>");
            description = document.querySelector('.description').value;
            counter = document.querySelector('.counter');
            counter.innerText = description.length + "/ 250";
            loadPublishSettingsFromJSON();
            document.getElementById("publishJSON").value = htmlEncode1(document.getElementById("publishJSON")
                .value);
            renderPublish();

        }

        function savePublishResponse(btn = document.getElementById("savePublish")) {
            btn.innerText = "Saving...";
            method = "POST";
            baseUrl = window.location.protocol + "//" + window.location.hostname;
            url = baseUrl + "/api/private/save_publish_manifest/";
            publishJSON = document.getElementById("publishJSON").value;
            publishJSON = publishJSON.replace(/\\/g, "\\\\");
            data = {
                "script_id": "<?php echo $_GET['script_id'];?>",
                "publish_manifest": publishJSON,
                "api_token": "<?php echo $_SESSION['api_token'];?>",
                "uid": "<?php echo $_SESSION['uid'];?>"
            };

            function saveScriptId(response) {
                console.log(response);
                response = JSON.parse(response);
                if (response.success) {
                    btn.innerText = "Saved";
                    setTimeout(() => {
                        btn.innerText = "Save";
                    }, 2000);
                } else {
                    btn.innerText = "Error";
                    setTimeout(() => {
                        btn.innerText = "Save";
                    }, 2000);
                }
            }

            makeApiRequest(method, url, data)
                .then(saveScriptId)
                .catch((error) => console.error(error));
        }
        var allowedUrl = "<?php  echo $website;?>";
        window.addEventListener("beforeunload", function(event) {
            var currentUrl = window.location.href;
            if (currentUrl && !currentUrl.startsWith(allowedUrl)) {
                event.preventDefault();
                event.returnValue = "";
            }
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