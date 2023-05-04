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
    </style>
</head>

<body>
    <?php 
    require "navbar.php";
    ?>
    <style>
    .nvbar {
        background-color: #18181B;
        width: 100vw;
		z-index:9991;
    }
    </style>
    <div id="loading-screen">
        <img class="loading-gif" src="./assets/images/loading.gif" alt="Loading...">


        <p id="loading-label" style="color:white">Loading Versions for '<?php echo $row['title']?>'</p>

    </div>
	<?php

$dir = './scripts/'.$_SESSION['uid']."_private/".$_GET['script_id']."/";
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
    $dir="./scripts/".$_SESSION['uid']."_public/". $_GET['script_id']."/";
	if (is_dir($dir)) {
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
} 
    ?>
    <div
        style="position:fixed;top:7%;z-index:999;width:100%;background-color:#18181B;text-align:center;padding-bottom:10px;color:white">

        <h1 style="display:inline-block"><?php echo $row['title'];?></h1>
		<p style="display:inline-block;border:solid grey 1px;border-radius:5px;padding:5px;font-size:14px"><?php echo count($manifest);?> <?php echo (count($manifest) == 1 ? "version" : "versions")?> found</p>
		<p style="display:inline-block;border:solid grey 1px;border-radius:5px;padding:5px;font-size:14px">Size: <?php echo number_format((float)getMbsValue($size), 2, '.', '');?>MB</p>

    </div>

    <br>
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
    </div>
    <script>
    window.addEventListener("load", function() {
        const loader = document.querySelector("#loading-screen");
        loader.style.visibility = "hidden";
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