<?php 
require "../head.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    body {
        background-color: #18181B;
        font-family: 'Roboto Mono', monospace;
    }

    .app {
        padding: 50px;
        padding-top: 30px;
    }

    .section_title {
        color: white;
        margin-left: 10px;
        font-size: 28px;
    }

    .section {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
        grid-gap: 30px;

    }

    .new_cluster {
        width: 100%;
        background-color: #2C2C2E;
        border-radius: 10px;
        overflow: hidden;
    }

    .new_cluster .info {
        width: 50%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        float: right;
        backdrop-filter: blur(5px);
    }

    .new_cluster .info h4 {
        color: white;
        font-size: 35px;
    }

    .badge {
        background-color: #2C2C2E;
        color: white;
        border-radius: 10px;
        padding: 5px;
        margin-top: 10px;
        margin-left: 15%;
        width: 100px;
        text-align: center;
        display: inline-block;
    }

    .new_cluster .info svg {
        width: 20px;
    }

    .section a {
        margin-bottom: 40px;
    }

    .cluster_title {
        color: white;
        font-size: 20px;
        margin-left: 10px;
    }
    .new_cluster center button{
        background:none;
        border:none;
        color:white;
        font-size:50px;
        font-weight:bolder;
        transition: all 0.5s ease;
        cursor:pointer;
    }
    .new_cluster center p{
        background:none;
        border:none;
        color:white;
        font-size:20px;
        font-weight:bolder;
        cursor:pointer;
    }
    .new_cluster:hover center button{
        transform: scale(2);

    }
    </style>
</head>

<body>
    <?php require "../navbar.php"; ?>
    <div class="app">

        <h3 class="section_title">Clusters</h3>

        <div id="cluster_section" class="section">
            <a href="../clusters?cid=PLv4HFbqT6zq2fyKLW1r9FjgX4GWeZebiK">
                <div class="new_cluster"
                    style="background-image: url('http://webtoolsv2/scripts/0HAXkUrU_assets_c0XMpcNgRf5LcFaWtmAuHrNsBeFud1/public/ezgif.com-resize%20(2).gif'); background-size: cover;">
                    <div class="info">
                        <center>

                            <h4>14</h4>
                            <svg style="width:40px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path fill="white"
                                    d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" />
                            </svg>
                        </center>
                        <div class="badge">Unlisted <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                <path fill="white"
                                    d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6 1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5 82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4-10.3 17.7-30.3 7.4-44.6s-30.3-17.7-44.6-7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z" />
                            </svg></div>
                        <p class="cluster_title">website</p>

                    </div>

                </div>
            </a>
            <div class="new_cluster"
                style="cursor:pointer; width: 360px; height: 285px; display: flex; align-items: center; justify-content: center;">
                <center>
                    <button>+</button>
                    <p>Create New Cluster</p>
                </center>
            </div>

        </div>
    </div>

</body>

</html>