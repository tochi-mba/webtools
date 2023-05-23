<?php require "../head.php"; ?>
<?php require "../connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - CodeConnect</title>
    <style type="text/scss">
        @import url('https://fonts.googleapis.com/css?family=Orbitron&display=swap');
  @import url('https://fonts.googleapis.com/css?family=Hind&display=swap');

  * {
    -webkit-font-smoothing: antialiased;
  }

  :root {
    --border-radius: 10px;
  }

  .cardSearch {
    padding: 1px;
    border-radius: var(--border-radius);
    background: linear-gradient(-67deg, rgba(43, 43, 45, .8));
    overflow: hidden;
    width: 380px;
    border:none;
  }

  .CardInner {
    padding: 16px 16px;
    background-color: #2b2b2d;
    border-radius: var(--border-radius);
  }

  .container {
    display: flex;
  }

  .Icon {
    min-width: 46px;
    min-height: 46px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--border-radius);
    margin-right: 12px;
    box-shadow: 
      -2px -2px 6px rgba(0, 0, 0, .6),
      2px 2px 12px #1d1d1f;

    svg {
      transform: translate(-1px, -1px);    
    }
  }

  label {
    font-family: "Hind", sans-serif;
    display: block;
    color: #c8d8e7;
    margin-bottom: 12px;
    background: linear-gradient(45deg, rgba(#6b7b8f, 1), #c8d8e7);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .InputContainer {
    width: 100%;
  }

  .InputContainer input {
    background-color: #2b2b2d;
    padding: 16px 32px;
    border: none;
    display: block;
    font-family: 'Orbitron', sans-serif;
    font-weight: 600;
    color: white;
    -webkit-appearance: none;
    transition: all 240ms ease-out;
    width: 100%;

    &::placeholder {
      color: grey;
    }

    &:focus {
      outline: none;
      color: #c8d8e7;
      background-color: #3c3c3e;
    }
  };

  .InputContainer {
    --top-shadow: inset 1px 1px 3px #1d1d1f, inset 2px 2px 6px #1d1d1f;
    --bottom-shadow: inset -2px -2px 4px rgba(0, 0, 0, .7);

    position: relative;
    border-radius: var(--border-radius);
    overflow: hidden;

    &:before,
    &:after {
      left: 0;
      top: 0;
      display: block;
      content: "";
      pointer-events: none;
      width: 100%;
      height: 100%;
      position: absolute;
    }

    &:before {
      box-shadow: var(--bottom-shadow);
    }

    &:after {
      box-shadow: var(--top-shadow);
    }
  }
</style>

    <style>
    body {
        background-color: #1a1a1a;
    }

    :root {
        --surface-color: rgba(43, 43, 45, 0.8);
        --curve: 15;
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Noto Sans JP', sans-serif;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin: 9rem 5vw;
        padding: 0;
        list-style-type: none;
        min-width: 250px;
        margin-left: 0;
        /* add this */
    }

    .sideBar {
        display: inline-block;
        float: left;
        width: 10%;
        height: 100%;
        position: fixed;
        top: 0;
    }

    .cardBox {
        display: inline-block;
        float: right;
        width: 90%;
    }

    .card {
        position: relative;
        display: block;
        height: 100%;
        border-radius: calc(var(--curve) * 1px);
        overflow: hidden;
        text-decoration: none;
        cursor: pointer;
    }

    .card__image {
        width: 100%;
        height: auto;
    }

    .card__overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1;
        border-radius: calc(var(--curve) * 1px);
        background-color: var(--surface-color);
        transform: translateY(100%);
        transition: .2s ease-in-out;
    }

    .card:hover .card__overlay {
        transform: translateY(0);
    }

    .card:hover .card__open {
        transform: scale(1.5);

    }

    .card:hover .card__open svg path {
        fill: #fff;

    }


    .card__header {
        position: relative;
        display: flex;
        align-items: center;
        gap: 2em;
        padding: 0.25em;
        border-top-left-radius: calc(var(--curve) * 1px);
        border-top-right-radius: calc(var(--curve) * 1px);
        background-color: rgba(43, 43, 45, 0.5);
        transform: translateY(-100%);
        transition: .2s ease-in-out;
        /* set a translucent background */
        backdrop-filter: blur(10px) opacity(80%);
        -webkit-backdrop-filter: blur(5px) opacity(80%);
        z-index: 50;
        /* add the frosted filter */
    }

    .card__arc {
        width: 80px;
        height: 80px;
        position: absolute;
        bottom: 100%;
        right: 0;
        z-index: 1;
        display: none
    }

    .card__arc path {
        fill: var(--surface-color);
        d: path("M 40 80 c 22 0 40 -22 40 -40 v 40 Z");
        backdrop-filter: blur(10px) opacity(80%);
        -webkit-backdrop-filter: blur(5px) opacity(80%);
        /* for Safari */
    }


    .card:hover .card__header {
        transform: translateY(0);
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
        background-color: rgba(43, 43, 45, 1);
    }

    .card__thumb {
        flex-shrink: 0;
        width: 50px;
        height: 50px;
        border-radius: 15px;
    }

    .card__title {
        font-size: 1em;
        margin: 0 0 .3em;
        color: white;
    }

    .card__tagline {
        display: block;
        margin: 1em 0;
        font-family: "MockFlowFont";
        font-size: .8em;
        color: white;
    }

    .card__status {
        font-size: .8em;
        color: white;
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
        display: none;
    }

    .projectDetailsBox {
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: rgba(24, 24, 27, 0.8);
        z-index: 101;
        top: 0;
        display: none;
        backdrop-filter: blur(10px);
    }

    /* WebKit based browsers */
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background-color: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 5px;
    }

    /* Firefox based browsers */
    * {
        scrollbar-width: thin;
        scrollbar-color: #ccc #f1f1f1;
    }

    *::-webkit-scrollbar-track {
        background-color: #f1f1f1;
    }

    *::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 5px;
    }

    *::-webkit-scrollbar-thumb:hover {
        background-color: #aaa;
    }

    .projectDetails {
        width: 80%;
        height: 80%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #2B2B2D;
        border-radius: 10px;
        padding: 20px;
        color: white;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    .projectDetails::-webkit-scrollbar {
        display: none;
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

    .card__open:hover svg path {
        animation: rainbow 2s linear infinite;
    }

    @keyframes rainbow {
        0% {
            fill: #c8e6c9;
            /* light green */
        }

        20% {
            fill: #b2dfdb;
            /* teal */
        }

        40% {
            fill: #80cbc4;
            /* light blue-green */
        }

        60% {
            fill: #ffd54f;
            /* yellow */
        }

        80% {
            fill: #ffb74d;
            /* orange */
        }

        100% {
            fill: #ff8a65;
            /* light red-orange */
        }
    }

    .navigator {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 10%;

    }

    .btnRight {
        float: right;
    }

    .btnLeft {
        float: left;
    }


    .code {
        overflow-x: scroll;
    }

    .code::-webkit-scrollbar {
        display: none;
    }

    .code {
        border-radius: 15px;
        padding: 10px;
        width: 100%;
        background-color: #282a36;
        word-break: break-all;
        word-wrap: break-word;
    }

    .copyCode {
        border-radius: 15px;
        padding: 10px;
        background-color: #282a36;
        word-break: break-all;
        word-wrap: break-word;
        white-space: pre-wrap;
        margin: 0px;
        margin-top: 20px;
        border: 1px solid grey;
    }


    .code code {
        color: white;
    }

    .codeCopyBtn {
        background-color: #282a36;
        border-radius: 10px;
        padding: 5px;
        border: 1px solid grey;
        cursor: pointer;
        top: -15px !important;
    }

    .miniModalBox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        /* background-color: rgba(0, 0, 0, 0.5); */
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
        display: none;
    }

    .miniModal {
        background-color: #282828;
        border-radius: 15px;

    }

    .miniModal p {
        color: white;
        padding: 10px;
        margin: 10px;
        cursor: pointer;
        font-size: 20px;
    }

    .miniModal p:hover {
        background-color: #3B3B3D;
    }

    .miniModalDetails {
        background-color: #282828;
        border-radius: 15px;
        margin-top: 10px;
        padding: 10px;
        width: 25%;
        overflow-y: scroll;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
    }

    .miniModalDetails::-webkit-scrollbar {
        display: none;
    }

    .miniModalDetails .topTitle {
        color: white;
        font-size: 20px;
        margin: 10px;
    }

    .miniModalDetails .body {
        margin-top: 10px;
        width: 100%;
        max-height: 150px;
        overflow-y: scroll;
    }

    .miniModalDetails .bottomBar {
        color: white;
        font-size: 20px;
        cursor: pointer;
        padding: 10px;
    }

    .miniModalDetails .bottomBar:hover {
        background-color: #3B3B3D;
    }

    .addClusterTitleLabel {
        color: white;
        font-size: 15px;
        outline: none;
    }

    .addClusterTitleLabel:active {
        border: none;

    }

    .clusterVersionLabel {
        color: white;
        font-size: 15px;
        outline: none;
        margin-top: 0px;
    }

    #clusterName {
        width: 100%;
        background: none;
        color: white;
        border: none;
        border-bottom: 1px solid white;
        height: 30px;
    }

    select {
        outline: none;
    }

    input {
        outline: none;
    }

    #clusterStatus {
        width: 100%;
        background: none;
        color: white;
        border: none;
        border-bottom: 1px solid white;
        height: 30px;
    }

    #clusterStatus option {
        background-color: #282828;
        color: white;
        border: none;
    }

    #versionCluster {
        width: 100%;
        background: none;
        color: white;
        border: none;
        border-bottom: 1px solid white;
        height: 30px;
    }

    #versionCluster option {
        background-color: #282828;
        color: white;
        border: none;
    }


    .createClusterBtn {
        cursor: pointer;
        color: white;
        font-size: 15px;
        width: fit-content;
        float: right;
        color: #3366CC;
        padding: 10px;
        border-radius: 15px;
        font-weight: bolder;
        transition: all 0.5s ease;
    }

    .createClusterBtn:hover {
        background-color: rgba(51, 102, 204, 0.5);
        color: white;
    }

    .clusterTitleLabelCount {
        color: white;
        font-size: 12px;
        float: right;
        margin: 0;
    }

    .addSite {
        color: white;
        font-size: 12px;
        float: right;
        margin: 0;
        cursor: pointer;
        display: inline-block;

    }

    .siteInput {
        width: 70%;
        background: none;
        color: white;
        border: none;
        border-bottom: 1px solid white;
        height: 30px;
        font-size: 12px;
        display: inline-block;
    }

    .showWebsitesCluster div {
        display: inline-block;
        color: white;
        font-size: 12px;
        padding: 10px;
        border: solid 1px grey;
        margin-top: 10px;
    }

    .removeWebsiteBtn {
        border: solid 1px grey;
        background: none;
        color: grey;
        cursor: pointer;
    }

    .websitesCluster {
        user-select: none;
    }

    .clusterChoice,
    .clusterChoiceName,
    .clusterChoiceStatus {
        margin-right: 10px;
    }

    .clusterChoice input {
        -webkit-appearance: none;
        -moz-appearance: none;
        -o-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        border: solid 3px white;
        background: transparent !important;
    }

    .clusterChoice input:checked::before {
        content: url("data:image/svg+xml;charset=utf-8,%3Csvg width='12px'  xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'%3E%3Cpath fill='white' d='M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z'/%3E%3C/svg%3E");
        color: white;
        width: 20px;
        height: 20px;
    }

    .clusterChoiceName p {
        color: white;
        font-size: 20px;
        margin: 0;

    }

    .clusterChoiceName {
        flex: 1;
        white-space: normal;
        word-wrap: break-word;
        overflow: hidden;
    }

    .clusterChoiceStatus {
        float: right;
    }
    </style>

</head>

<body>
    <input type="hidden" id="current_project">
    <div onclick="document.querySelector('.miniModalBox').style.display='none';" class="miniModalBox">
        <div onclick="event.stopPropagation();" class="miniModal">
            <p
                onclick="document.querySelector('.miniModalDetails').style.display = 'block';document.querySelector('.miniModal').style.display = 'none';defaultCluster()">
                + Add</p>
        </div>
        <div onclick="event.stopPropagation();" class="miniModalDetails">
            <p class="topTitle">Add To...</p>
            <div class="body">
                <div style="display: flex; align-items: center;">
                    <div class="clusterChoice" style="display: inline;">
                        <input type="checkbox" name="" id="">
                    </div>
                    <div class="clusterChoiceName" style="display: inline;">
                        <p>Brooooooooooooooooooooo</p>
                    </div>
                    <div class="clusterChoiceStatus" style="display: inline;">
                    <svg viewBox="0 0 18 18" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon" style="pointer-events: none; display: block; width: 20px"><g class="style-scope yt-icon"><path fill="white" d="M13,5c0-2.21-1.79-4-4-4C6.79,1,5,2.79,5,5v1H3v11h12V6h-2V5z M6,5c0-1.65,1.35-3,3-3c1.65,0,3,1.35,3,3v1H6V5z M14,7v9H4 V7H14z M7,11c0-1.1,0.9-2,2-2s2,0.9,2,2c0,1.1-0.9,2-2,2S7,12.1,7,11z" class="style-scope yt-icon"></path></g></svg>
                    </div>
                </div>
            </div>
            <div class="bottomMiniModal">
                <p onclick="newCluster();" class="bottomBar">Create New Cluster +</p>
            </div>
        </div>
        <script>
        function defaultCluster() {
            bottomMiniModal = document.querySelector('.bottomMiniModal');
            bottomMiniModal.innerHTML = `<p onclick="newCluster();" class="bottomBar">Create New Cluster +</p>`;
        }

        function getClusters() {
            baseUrl = window.location.protocol + "//" + window.location.hostname;
            var method = 'POST';
            var url = '/api/private/get_clusters/';
            var data = {
                "uid": "<?php echo $_SESSION['uid']?>"
            };
            url = baseUrl + url;

            function handleClusters(response) {
                console.log(response);
                if (response.success) {

                } else {
                    console.log(response);
                }
            }
            makeApiRequest(method, url, data)
                .then(handleClusters)
                .catch((error) => console.error(error));
        }

        function createCluster() {
            clusterName = document.getElementById('clusterName').value;
            clusterStatus = document.getElementById('clusterStatus').value;
            current_project = document.getElementById('current_project').getAttribute('project_id');
            current_project_uid = document.getElementById('current_project').getAttribute('uid');
            versionCluster = document.getElementById('versionCluster').value;
            if (clusterName.trim().length > 0) {
                clusterName = clusterName.trim();
                createClusterBtn = document.querySelector(".createClusterBtn").remove()
                baseUrl = window.location.protocol + "//" + window.location.hostname;
                var method = 'POST';
                var url = '/api/private/create_cluster/';
                var data = {
                    "name": clusterName,
                    "status": clusterStatus,
                    "project_id": current_project,
                    "author_uid": current_project_uid,
                    "uid": "<?php echo $_SESSION['uid']?>",
                    "version": versionCluster,
                    "auth_websites": document.querySelector("#clusterAuthWebsitesSave").value,
                };
                url = baseUrl + url;

                function saveScriptId(response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if (response.success) {
                        defaultCluster();
                        getClusters();
                    }
                }
                makeApiRequest(method, url, data).then(saveScriptId).catch((error) => console.error(error));
            }
        }

        function authWebsitesCluster() {
            authWebsitesBox = document.querySelector(".authWebsitesBox");
            clusterStatus = document.getElementById("clusterStatus").value;
            if (clusterStatus != "private") {
                authWebsitesBox.innerHTML = "";
            } else {
                authWebsitesBox.innerHTML = ` 
                <div style="display: flex;align-items: center;">
                <input placeholder="https:// or http://" class="siteInput" type="text"/>
                <p onclick="addSite()" class="addSite">Add Website +</p>
                </div>
                <div class="showWebsitesCluster">
                </div>`;
                document.querySelector(".siteInput").value = "";
                document.querySelector("#clusterAuthWebsitesSave").value = "[]";


            }
        }

        function addSite() {
            var siteInput = document.querySelector(".siteInput").value;
            document.querySelector(".siteInput").value = "";
            var clusterAuthWebsitesSave = document.querySelector("#clusterAuthWebsitesSave");
            var current_sites = clusterAuthWebsitesSave.value;
            current_sites = current_sites ? JSON.parse(current_sites) :
        []; // Initialize as an empty array if null or undefined
            console.log(current_sites);
            if (current_sites.includes(siteInput)) {
                // Display an error message if the siteInput already exists in current_sites
                alert("This website is already added.");
            } else {
                // Validate siteInput and add a new div to div.showWebsitesCluster
                if (siteInput.startsWith("http://") || siteInput.startsWith("https://")) {
                    // Remove "http://" or "https://" from siteInput
                    var formattedSiteInput = siteInput.replace(/^https?:\/\//, "");
                    var newDiv = document.createElement("div");
                    newDiv.classList.add("websitesCluster");
                    newDiv.setAttribute("website", siteInput);
                    newDiv.textContent = formattedSiteInput;
                    var removeBtn = document.createElement("button");
                    removeBtn.classList.add("removeWebsiteBtn");
                    removeBtn.style.top = "0px";
                    removeBtn.style.right = "0px";
                    removeBtn.innerHTML = "x";
                    // Add event listener to the remove button
                    removeBtn.addEventListener("click", function() {
                        siteInput = this.parentNode.getAttribute("website")
                        var clusterAuthWebsitesSave = document.querySelector("#clusterAuthWebsitesSave");
                        var current_sites = clusterAuthWebsitesSave.value;
                        current_sites = current_sites ? JSON.parse(current_sites) : [];
                        // Update current_sites by removing the corresponding website
                        current_sites = current_sites.filter(function(site) {
                            return site !== siteInput;
                        });
                        current_sites = JSON.stringify(current_sites);
                        clusterAuthWebsitesSave.value = current_sites;
                        // Remove the div from the DOM
                        this.parentNode.remove();
                    });
                    newDiv.appendChild(removeBtn);
                    document.querySelector(".showWebsitesCluster").appendChild(newDiv);

                    // Update current_sites
                    current_sites.push(siteInput);
                } else {
                    // Display an error message if siteInput doesn't start with "http://" or "https://"
                    alert("Please enter a valid website URL starting with 'http://' or 'https://'.");
                }
            }

            current_sites = JSON.stringify(current_sites);
            clusterAuthWebsitesSave.value = current_sites;
        }


        function newCluster() {

            publicVersions = document.getElementById('current_project').getAttribute("publicVersions");
            publicVersions = JSON.parse(publicVersions);
            bottomMiniModal = document.querySelector('.bottomMiniModal');
            bottomMiniModal.scrollIntoView();
            bottomMiniModal.innerHTML = `
            <input type="hidden" value="[]" id="clusterAuthWebsitesSave" />
            <p class="addClusterTitleLabel">Name
                <br>
                <input type="text" id="clusterName" placeholder="Enter Cluster Name...">
                <p class="clusterTitleLabelCount">0/150</p></p>
                <br>
                <p class="addClusterTitleLabel">Status<br>
                <select onchange="authWebsitesCluster()" id="clusterStatus">
                    <option value="private">Private</option>
                    <option value="public">Public</option>
                    <option value="unlisted">Unlisted</option>
                </select>
                <div class="authWebsitesBox">
                <div style="display: flex;align-items: center;">
                <input placeholder="https:// or http://" class="siteInput" type="text"/>
                <p onclick="addSite()" class="addSite">Add Website +</p>
                </div>
                <div class="showWebsitesCluster">
                </div>
                </div>
                </p>
                <br>
                <p class="clusterVersionLabel">Version<br>
                <select name="version" id="versionCluster" >
                </select>
                </p>
                <p onclick="createCluster();" class="createClusterBtn">Create +</p>`;

            versionCluster = document.getElementById("versionCluster");
            console.log(publicVersions)
            for (var i = publicVersions.length - 1; i >= 0; i--) {
                versionCluster.innerHTML += "<option value='" + publicVersions[i] + "'> " + publicVersions[i] +
                    " </option>";
            }

            var input = document.getElementById('clusterName');
            var counter = document.querySelector('.clusterTitleLabelCount');

            input.addEventListener('input', function() {
                var maxLength = 150;
                var currentLength = input.value.length;
                var remainingLength = maxLength - currentLength;
                counter.textContent = currentLength + '/' + maxLength;

                if (currentLength > maxLength) {
                    counter.style.color = 'red';
                } else {
                    counter.style.color = 'white'; // Change it back to black if it's within the limit
                }
            });
        }
        </script>
    </div>
    <div onclick="this.style.display='none';document.querySelector('.projectDetails').innerHTML='';"
        class="projectDetailsBox">
        <div onclick='event.stopPropagation()' class="projectDetails">

        </div>
    </div>
    <div class="topBar">
        <div class="mainBar">
            <div class="cardSearch">
                <div class="CardInner">
                    <div class="container">
                        <div class="Icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="grey" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-search">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                        </div>
                        <div class="InputContainer">
                            <input oninput="search(this)" placeholder="Search..." />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tabContainer">
            <button class="scroll-button left">&lt;</button>

            <div class="tabs">

                <div class="tab active">
                    All
                </div>
                <div class="tab">
                    For You
                </div>
                <div class="tab">
                    JS Module
                </div>
                <div class="tab">
                    JS Only
                </div>
                <div class="tab">
                    CSS Only
                </div>
                <div class="tab monetized">
                    Monetized
                </div>
                <div class="tab free">
                    Free
                </div>
                <?php require "generateTabs.php"; ?>

            </div>
            <button class="scroll-button right">&gt;</button>
        </div>
        <div class="navigator">
            <button class="btnLeft">
                < </button>
                    <button class="btnRight">></button>
        </div>
    </div>
    <div class="sideBar">jjjjjjjjjjjj</div>
    <div class="cardBox">
        <ul class="cards">
        </ul>
    </div>


    <script>
    function miniModal(type, project_id, uid) {
        console.log("hi")
        var modal = document.querySelector(".miniModal");
        var modalBox = document.querySelector(".miniModalBox");
        var modalDetails = document.querySelector(".miniModalDetails");
        var cursorX = window.event.clientX; // Get the cursor's X-coordinate
        var cursorY = window.event.clientY; // Get the cursor's Y-coordinate

        modal.style.position = "fixed";
        modal.style.width = "auto";
        modal.style.height = "auto";
        modal.style.padding = "10px";
        modal.style.paddingLeft = "0px";
        modal.style.paddingRight = "0px";
        modal.style.left = cursorX + "px";
        modal.style.top = cursorY + "px";
        modal.style.display = "block";
        modalDetails.style.display = "none";
        modalBox.style.display = "flex";
    }

    function renderPublish(info, publicVersions, uid, project_id, type) {

        var publishJSON = info
        publishJSON = publishJSON.replace(/[\x00-\x1F\x7F-\x9F]/g, '');
        publishJSON = JSON.parse(publishJSON);
        var publishShowBox = document.querySelector(".projectDetails");
        publishShowBox.style.wordWrap = "break-word";
        publishShowBox.style.overflowWrap = "break-word";
        publishShowBox.innerHTML =
            `<button class="miniModalBtn" style="background:none;border:none;cursor:pointer;"><svg style="width:5px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path fill="white" d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"/></svg></button>`;
        publishShowBox.innerHTML += "<h2>Getting Started</h2>";
        miniModalBtn = document.querySelector(".miniModalBtn");
        miniModalBtn.addEventListener("click", function() {
            miniModal(type, project_id, uid);
        })
        for (var i = 0; i < publishJSON.length; i++) {
            var section = document.createElement("div");
            section.classList.add("sectionRendered");
            section.innerHTML = "<h2>" + publishJSON[i]['title'] + "</h2>";
            for (var j = 0; j < publishJSON[i]['subSections'].length; j++) {
                var subSection = document.createElement("div");
                subSection.classList.add("subSectionRendered");
                subSection.innerHTML = "<h3>" + publishJSON[i]['subSections'][j]['title'] + "</h3>";
                for (var k = 0; k < publishJSON[i]['subSections'][j]['info'].length; k++) {
                    var info = document.createElement("div");
                    info.style.width = "100%";
                    info.style.position = "relative";
                    info.classList.add("infoRendered");
                    if (publishJSON[i]['subSections'][j]['info'][k]['type'] == "text") {
                        info.innerHTML += "<p class='text'>" + publishJSON[i]['subSections'][j]['info'][k][
                                'content'
                            ] +
                            "</p>";
                    } else if (publishJSON[i]['subSections'][j]['info'][k]['type'] == "code") {
                        info.innerHTML += "<pre class='code'><code>" + publishJSON[i]['subSections'][j][
                                'info'
                            ][k][
                                'content'
                            ] +
                            "</code></pre>";
                    } else if (publishJSON[i]['subSections'][j]['info'][k]['type'] == "html") {
                        htmlString = publishJSON[i]['subSections'][j]['info'][k]['content'].replace(/\//g, '&#x2F;')
                            .replace(/:/g, '&#x3A;');
                        console.log(htmlString)
                        let textarea = document.createElement('textarea');
                        textarea.innerHTML = htmlString;
                        let decodedStr = textarea.value;
                        console.log(decodedStr);
                        info.innerHTML = decodedStr;
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
        project_code = document.createElement('div');
        project_code.style.position = "absolute";
        project_code.style.top = "50%";
        project_code.style.left = "50%";
        project_code.style.transform = "translate(-50%, -50%)";
        project_code.style.width = "40%";
        project_code.style.height = "fit-content";
        project_code.style.backgroundColor = "none";
        project_code.style.borderRadius = "10px";
        project_code.style.display = "none";
        project_code.setAttribute("onclick", "event.stopPropagation()");
        project_code.classList.add("project_code");
        publishShowBox.appendChild(project_code);
        publishShowBox.addEventListener("click", function() {
            project_code.style.display = "none";
        });
        const button = document.createElement("button");
        button.style.position = "absolute";
        button.style.top = "20px";
        button.style.right = "20px";
        button.style.width = "40px";
        button.style.height = "40px";
        button.style.borderRadius = "10px";
        button.style.backgroundColor = "#2b2b2d";
        button.style.cursor = "pointer";
        button.style.transition = "transform 0.3s ease";
        button.style.padding = "8px";
        button.style.justifyContent = "center";
        button.style.display = "flex";
        button.style.zIndex = "9999";
        button.innerHTML =
            `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="white" d="M392.8 1.2c-17-4.9-34.7 5-39.6 22l-128 448c-4.9 17 5 34.7 22 39.6s34.7-5 39.6-22l128-448c4.9-17-5-34.7-22-39.6zm80.6 120.1c-12.5 12.5-12.5 32.8 0 45.3L562.7 256l-89.4 89.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l112-112c12.5-12.5 12.5-32.8 0-45.3l-112-112c-12.5-12.5-32.8-12.5-45.3 0zm-306.7 0c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3l112 112c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256l89.4-89.4c12.5-12.5 12.5-32.8 0-45.3z"/></svg>`;
        button.classList.add("generate_code");
        publishShowBox.appendChild(button);

        let isButtonPressed = false;

        button.addEventListener("mousedown", function() {
            button.style.transform = "scale(0.9)";
            isButtonPressed = true;
        });

        button.addEventListener("mouseup", function() {
            button.style.transform = "scale(1)";
            isButtonPressed = false;
        });

        button.addEventListener("mouseleave", function() {
            if (isButtonPressed) {
                button.style.transform = "scale(1)";
                isButtonPressed = false;
            }
        });
        const slidingDiv = document.createElement("div");
        slidingDiv.style.position = "absolute";
        slidingDiv.style.top = "25px";
        slidingDiv.style.right = "0px";
        slidingDiv.style.width = "fit-content";
        slidingDiv.style.height = "50px";
        slidingDiv.style.backgroundColor = "none";
        slidingDiv.style.transition = "transform 0.3s ease";
        slidingDiv.style.transform = "translateX(300px)";
        div = document.createElement("div");
        div.classList.add("versions_container");
        div.style.marginRight = "70px";
        publicVersions = JSON.parse(publicVersions);
        for (var i = 0; i < publicVersions.length; i++) {
            var version = publicVersions[i];
            versionBtn = document.createElement("button");
            versionBtn.classList.add("version");
            versionBtn.innerHTML = version;
            versionBtn.style.marginRight = "10px";
            versionBtn.style.padding = "7px";
            versionBtn.style.borderRadius = "15px";
            versionBtn.style.backgroundColor = "#2b2b2d";
            versionBtn.style.color = "white";
            versionBtn.style.cursor = "pointer";
            versionBtn.style.transition = "transform 0.3s ease";
            versionBtn.style.display = "inline-block";
            versionBtn.style.alignItems = "center";
            versionBtn.style.justifyContent = "center";
            versionBtn.style.border = "solid 1px grey";
            versionBtn.style.fontSize = "12px";
            versionBtn.style.fontWeight = "bold";
            versionBtn.setAttribute("onclick", "event.stopPropagation()");
            versionBtn.setAttribute("data-version", version);
            versionBtn.addEventListener("click", function() {
                project_code.style.display = "block";
                baseUrl = window.location.protocol + "//" + window.location.hostname;
                if (type == "module") {
                    project_code.innerHTML =
                        `<pre class="copyCode integrateCopy">&lt;script type="module" src="` + baseUrl +
                        `/scripts/` +
                        uid + `_public/` +
                        project_id + `/` + this.getAttribute("data-version") + `/` + project_id +
                        `.js"&gt;&lt;/script&gt;</pre>`;
                } else {
                    project_code.innerHTML = `<pre class="copyCode integrateCopy">&lt;script src="` + baseUrl +
                        `/scripts/` +
                        uid +
                        `_public/` +
                        project_id + `/` + this.getAttribute("data-version") + `/` + project_id +
                        `.js"&gt;&lt;/script&gt;</pre>`;
                }

                copyButton = document.createElement("button");
                copyButton.innerHTML =
                    '<svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1.25em" width="1.25em" xmlns="http://www.w3.org/2000/svg"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>';
                copyButton.style.position = "absolute";
                copyButton.style.top = "0px";
                copyButton.style.right = "0px";
                copyButton.querySelector('svg').style.stroke = 'white';
                copyButton.classList.add("codeCopyBtn");



                copyButton.addEventListener("click", function() {
                    scriptTagString = project_code.querySelector(".integrateCopy").innerText;

                    textarea = document.createElement("textarea");
                    textarea.value = scriptTagString;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand("copy");
                    document.body.removeChild(textarea);

                    // Change the button text to "Copied!" for 2 seconds
                    originalText =
                        '<svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1.25em" width="1.25em" xmlns="http://www.w3.org/2000/svg"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>';

                    copyButton.innerHTML =
                        '<svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1.25em" width="1.25em" xmlns="http://www.w3.org/2000/svg"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                    copyButton.querySelector('svg').style.stroke = 'white';
                    setTimeout(function() {
                        copyButton.innerHTML = originalText;
                        copyButton.querySelector('svg').style.stroke = 'white';

                    }, 2000);
                });
                // Add the copy button to the project_code element
                if (type == "module") {
                    project_code.innerHTML +=
                        `<br><div class="copyImportLine"><br></div><pre style="margin-top:0px !important" class="copyCode importLine">import <> from "` +
                        baseUrl +
                        `/scripts/` +
                        uid + `_public/` +
                        project_id + `/` + this.getAttribute("data-version") + `/` + project_id + `.js"</pre>`;
                    copyButton1 = document.createElement("button");
                    copyButton1.innerHTML =
                        '<svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1.25em" width="1.25em" xmlns="http://www.w3.org/2000/svg"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>';
                    copyButton1.style.position = "relative";
                    copyButton1.querySelector('svg').style.stroke = 'white';
                    copyButton1.style.float = "right";
                    copyButton1.classList.add("codeCopyBtn");


                    copyButton1.addEventListener("click", function() {
                        scriptTagString = project_code.querySelector(".importLine").innerText;

                        textarea = document.createElement("textarea");
                        textarea.value = scriptTagString;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand("copy");
                        document.body.removeChild(textarea);

                        originalText =
                            '<svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1.25em" width="1.25em" xmlns="http://www.w3.org/2000/svg"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>';

                        copyButton1.innerHTML =
                            '<svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" height="1.25em" width="1.25em" xmlns="http://www.w3.org/2000/svg"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                        copyButton1.querySelector('svg').style.stroke = 'white';
                        setTimeout(function() {
                            copyButton1.innerHTML = originalText;
                            copyButton1.querySelector('svg').style.stroke = 'white';

                        }, 2000);
                    });

                    project_code.querySelector(".copyImportLine").appendChild(copyButton1);
                }
                project_code.appendChild(copyButton);







            });
            div.appendChild(versionBtn);
        }
        slidingDiv.appendChild(div);
        publishShowBox.appendChild(slidingDiv);

        button.addEventListener("click", function() {
            if (slidingDiv.style.transform === "translateX(0px)") {
                slidingDiv.style.transform = "translateX(300px)";
            } else {
                slidingDiv.style.transform = "translateX(0px)";
            }
        });

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

    function openDetails(project_manifest, publicVersions, uid, project_id, type) {
        current_project = document.querySelector("#current_project");
        current_project.setAttribute("project_id", project_id);
        current_project.setAttribute("uid", uid);
        publicVersions = publicVersions.replace(/'/g, '"')
        console.log(publicVersions)
        current_project = document.getElementById("current_project");
        current_project.setAttribute("publicVersions", publicVersions);
        info = project_manifest.replace(/'/g, '"')
        console.log(info)
        renderPublish(info, publicVersions, uid, project_id, type)
        detailsBox = document.querySelector(".projectDetailsBox");
        detailsBox.style.display = "block";
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

    function addProject(image, title, description, username, publish_manifest, project_id, user_id, versions,
        publicVersions, privateVersions, type) {
        publicVersions = publicVersions;
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

        publish_manifest = publish_manifest.replace(/"/g, "'").replace(/\(/g, '\\(').replace(/`/g, '\\`').replace(/\)/g,
            '\\)');
        card = `
    <li>
        <div class="card">
            <div onclick="openDetails(\`` + publish_manifest +
            `\`, \`` + JSON.stringify(publicVersions).replace(/"/g, "'") + `\`,'` + user_id + `','` + project_id +
            `','` + type + `')" style="z-index:9" class="card__open">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path fill="grey"
                        d="M32 32C14.3 32 0 46.3 0 64v96c0 17.7 14.3 32 32 32s32-14.3 32-32V96h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H32zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7 14.3 32 32 32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H64V352zM320 32c-17.7 0-32 14.3-32 32s14.3 32 32 32h64v64c0 17.7 14.3 32 32 32s32-14.3 32-32V64c0-17.7-14.3-32-32-32H320zM448 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64H320c-17.7 0-32 14.3-32 32s14.3 32 32 32h96c17.7 0 32-14.3 32-32V352z" />
                </svg>
            </div>
            <img onload="cardImg=this;cardImg.style.display = 'block';parent = cardImg.parentNode;parent.querySelector('div.card__image').style.display = 'none';"
                style="display:none" loop src="` +
            image + `" class="card__image" alt="" />

            <div class="card__image" style="background-color:grey;height:300px"></div>
            <div class="card__overlay">
                <div class="card__header">
                    <svg class="card__arc" xmlns="http://www.w3.org/2000/svg">
                        <path />
                    </svg>
                    <img class="card__thumb" src="../dp.php?u=` + username + `" alt="" />
                    <div class="card__header-text">
                        <h3 class="card__title">` + title + `</h3>
                        <span class="card__status">@` + username + `</span>
                    </div>
                </div>
                <p class="card__description">` + description + `
                </p>
            </div>
        </div>
    </li>
    `;

        document.querySelector(".cards").innerHTML += card;


        fillers = document.querySelectorAll(".filler");
        fillers.forEach(filler => {
            parent = filler.parentNode
            parent.remove()
        });

        document.querySelector(".cards").innerHTML += filler;


    }
    tabs = document.querySelectorAll(".tab");
    tabs.forEach(tab => {
        tab.addEventListener("click", function() {
            tabs.forEach(tab => {
                tab.classList.remove("active");
            });
            tab.classList.add("active");
            switchTab(tab.innerText);
        });
    });

    function switchTab(tab) {
        document.querySelector(".cards").innerHTML = "";
        document.querySelector("title").innerHTML = tab + " - CodeConnect";
        tabs = document.querySelectorAll(".tab");
        tabs.forEach(tabElem => {
            tabElem.classList.remove("active");
            if (tabElem.innerText == tab) {
                tabElem.classList.add("active");
            }
        });
        var data = {};
        method = "POST";
        baseUrl = window.location.protocol + "//" + window.location.hostname;
        url = baseUrl + "/api/private/search_tab/";
        data.tab_name = tab;

        function saveScriptId(response) {
            console.log(response);

            if (!JSON.parse(response)) {} else {
                response = JSON.parse(response);
            }
            if (response.success) {
                for (let i = 0; i < response.valid_scripts.length; i++) {
                    image = response.valid_scripts[i].publish_image;
                    title = response.valid_scripts[i].title;
                    description = response.valid_scripts[i].publish_description;
                    username = response.valid_scripts[i].username;
                    publish_manifest = response.valid_scripts[i].publish_manifest;
                    project_id = response.valid_scripts[i].script_id;
                    user_id = response.valid_scripts[i].uid;
                    versions = response.valid_scripts[i].active_versions;
                    manifest = response.valid_scripts[i].manifest;
                    type = response.valid_scripts[i].type;
                    data = JSON.parse(manifest);
                    publicVersions = [];
                    privateVersions = [];
                    for (let
                            key in data) {
                        if (data.hasOwnProperty(key)) {
                            const value = data[key];
                            for (let i = 0; i < value.length; i++) {
                                if (value[i].status === "public") {
                                    publicVersions.push(key);
                                    console.log(key);
                                } else if (value[i].status === "private") {
                                    privateVersions.push(key);
                                }
                            }
                        }
                    }

                    addProject(image, title, description,
                        username, publish_manifest, project_id, user_id, versions, publicVersions, privateVersions,
                        type);
                }
            } else {}
        }
        makeApiRequest(method, url, data).then(saveScriptId).catch((error) => console.error(error));
        scrollToTop();
        return true;

    }
    let timeoutId;

    function scrollToTop() {
        const currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
        if (currentScroll > 0) {
            window.requestAnimationFrame(scrollToTop);
            window.scrollTo(0, currentScroll - (currentScroll / 10));
        }
    }

    function search(elem) {


        filler = `
        <li>
            <div class="card">
                <div class="card__open">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path fill="grey"
                            d="M32 32C14.3 32 0 46.3 0 64v96c0 17.7 14.3 32 32 32s32-14.3 32-32V96h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H32zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7 14.3 32 32 32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H64V352zM320 32c-17.7 0-32 14.3-32 32s14.3 32 32 32h64v64c0 17.7 14.3 32 32 32s32-14.3 32-32V64c0-17.7-14.3-32-32-32H320zM448 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64H320c-17.7 0-32 14.3-32 32s14.3 32 32 32h96c17.7 0 32-14.3 32-32V352z" />
                    </svg>
                </div>
                <div class="card__image" style="background-color:grey;height:300px"></div>
                <div class="card__overlay">
                    <div class="card__header">
                        <svg class="card__arc" xmlns="http://www.w3.org/2000/svg">
                            <path />
                        </svg>
                        <img class="card__thumb" src="https://i.imgur.com/oYiTqum.jpg" alt="" />
                        <div class="card__header-text">
                            <h3 class="card__title">Jessica Parker</h3>
                            <span class="card__status">1 hour ago</span>
                        </div>
                    </div>
                    <p class="card__description">Pears are a type of fruit that
                        are enjoyed all over the world for their sweet and juicy flavor, as well as their many health
                        benefits. They come in a variety of colors, shapes, and sizes, and can be eaten raw, cooked, or
                        used in a variety of rsssssss
                    </p>
                </div>
            </div>
        </li>
        `;
        document.querySelector(".cards").innerHTML = "";
        document.querySelector("title").innerHTML = "Search '" + elem.value.trim() + "' - CodeConnect";

        for (let i = 0; i < 12; i++) {
            document.querySelector(".cards").innerHTML += filler;
        }
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            const searchTerm = elem.value.trim();
            if (searchTerm === "") {
                switchTab("All");
                return;
            }

            document.querySelector(".cards").innerHTML = "";
            for (let i = 0; i < 12; i++) {
                addProject(searchTerm);
                scrollToTop();
            }
        }, 500);
    }
    const
        container = document.querySelector(".tabs");
    const content = document.querySelector(".tab");
    const
        leftButton = document.querySelector(".left");
    const rightButton = document.querySelector(".right");
    const
        step = 100;
    let isDragging = false;
    let startX;
    let scrollLeft;
    leftButton.addEventListener("click", () => {
        container.scrollBy({
            left: -step,
            behavior: "smooth",
        });

        // Check if the container has reached the beginning
        if (container.scrollLeft === 0) {
            leftButton.style.display = "none";
        }
    });

    // Show/hide the left button based on the container's scroll position
    container.addEventListener("scroll", () => {
        const containerWidth = container.offsetWidth;
        const contentWidth = container.scrollWidth;
        const scrollPosition = container.scrollLeft;

        if (scrollPosition === 0) {
            leftButton.style.display = "none";
        } else if (contentWidth - scrollPosition <= containerWidth + 10) {
            leftButton.style.display = "none";
        } else {
            leftButton.style.display = "block";
        }
    });
    rightButton.addEventListener("click", () => {
        container.scrollBy({
            left: step,
            behavior: "smooth",
        });

        // Check if the container has reached the end
        if (container.scrollLeft + container.offsetWidth >= container.scrollWidth) {
            rightButton.style.display = "none";
        }

        // Show the left button
        leftButton.style.display = "block";
    });

    container.addEventListener("scroll", () => {
        const containerWidth = container.offsetWidth;
        const contentWidth = container.scrollWidth;
        const scrollPosition = container.scrollLeft;

        if (scrollPosition === 0) {
            leftButton.style.display = "none";
        } else {
            leftButton.style.display = "block";
        }

        if (contentWidth - scrollPosition <= containerWidth + 10) {
            rightButton.style.display = "none";
        } else {
            rightButton.style.display = "block";
        }
    });
    container.addEventListener("mousedown", (e) => {
        isDragging = true;
        startX = e.pageX - container.offsetLeft;
        scrollLeft = container.scrollLeft;
    });

    container.addEventListener("mouseup", () => {
        isDragging = false;
    });

    container.addEventListener("mousemove", (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - container.offsetLeft;
        const walk = (x - startX) * 1; // adjust scroll speed here
        container.scrollLeft = scrollLeft - walk;
    });
    window.onload = function() {
        switchTab("All");

    }
    </script>
    <script>
    document.head.innerHTML +=
        '<link rel="icon" type="image/png" href="../../assets/images/logo.png">';
    </script>
    <script src="https://cdn.jsdelivr.net/npm/browser-scss@1.0.3/dist/browser-scss.min.js"></script>

</body>

</html>