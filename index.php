<?php require "head.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - CodeConnect</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.globe.min.js"></script>
<style>
    #bb{
    width:100vw;
    height:100vh;
    margin: 0 !important;
    padding: 0 !important;
    display: flex;
    justify-content: center;
    align-items: center;
}
body{
    padding:0;
    margin:0;
}
#webtools {
    font-family: 'Roboto Mono', monospace;
    font-size: 2rem;
    color: white;
}

.navbar {
  position: fixed;
  top: 0;
  left: 0;
  width: 99%;
  background: none;
  color: white;
  padding: 10px;
  z-index: 1;
  font-family: 'Roboto Mono', monospace;
}

.navbar a {
  float: left;
  color: white;
  text-align: center;
  padding: 8px;
  text-decoration: none;
  font-size: 14px;
  line-height: 20px;
  border-radius: 4px;
}

.navbar a.right {
  float: right;
}

.navbar a:hover {
  background-color: #ddd;
  color: black;
}

#subtext {
    font-family: 'Roboto Mono', monospace;
    font-size: 1rem;
    color: white;
    text-align: center;
    width:60%;
}

#developer {
    font-family: 'Roboto Mono', monospace;
    font-size: 1.5rem;
    color: white;
    text-align: left;
    width:60%;
}

@media only screen and (max-width: 600px) {
    #webtools {
        font-size: 1.5rem;
    }
    #subtext {
        font-size: 0.8rem;
    }
    #developer {
        font-size: 1rem;
    }
    .navbar a {
        font-size: 12px;
        padding: 6px;
    }
}

</style>
</head>

<body id="bb" >
   <?php require "navbar.php"; ?>
    <div >
        <div id="webtools">
           <center>
           <h1 style="padding:0px;margin:10px;font-size:4rem">CodeConnect <span id="developer">Developer</span></h1>
           </center> 
           <center>
           <div id="subtext">We know the power of good development. That is why we created CodeConnect, an open source platform for developers made by developers.</div>
           </center>

    </div>
    </div>
<script>
VANTA.GLOBE({
  el: "#bb",
  mouseControls: true,
  touchControls: true,
  gyroControls: false,
  minHeight: 200.00,
  minWidth: 200.00,
  scale: 1.00,
  scaleMobile: 1.00,
  color: 0xcff5b,
  color2: 0xc5c5c5,
  size: 0.90,
  backgroundColor: 0x1e1f1f
})
</script>
</body>
</html>