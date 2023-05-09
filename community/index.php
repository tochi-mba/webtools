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
    color: #acbdce;
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
        /* add this */
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

</head>

<body>

    <div onclick="this.style.display='none'" class="projectDetailsBox">
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
                            <input onkeyup="search(this)" placeholder="Search..." />
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
    </div>
    <ul class="cards">
    </ul>

    <script>
    function openDetails(project_id) {
        detailsBox = document.querySelector(".projectDetailsBox");
        detailsBox.style.display = "block";
        details = document.querySelector(".projectDetails");
        details.innerHTML = project_id;
    }

    function addProject(i) {
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


        card = `
        <li>
    <div onclick="openDetails('` + i + `')"  class="card">
    <div class="card__open">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path fill="grey" d="M32 32C14.3 32 0 46.3 0 64v96c0 17.7 14.3 32 32 32s32-14.3 32-32V96h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H32zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7 14.3 32 32 32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H64V352zM320 32c-17.7 0-32 14.3-32 32s14.3 32 32 32h64v64c0 17.7 14.3 32 32 32s32-14.3 32-32V64c0-17.7-14.3-32-32-32H320zM448 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64H320c-17.7 0-32 14.3-32 32s14.3 32 32 32h96c17.7 0 32-14.3 32-32V352z"/></svg>
    </div>
    <img onload="cardImg=this;cardImg.style.display = 'block';parent = cardImg.parentNode;parent.querySelector('div.card__image').style.display = 'none';" style="display:none" loop src="http://webtoolsv2/user_assets/image.php?v=private%2Fezgif.com-resize%20(2).gif" class="card__image" alt="" />

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
        if (tab == "All") {
            for (let i = 0; i < 12; i++) {
                addProject(i);
            }
        } else if (tab == "For You") {
            for (let i = 0; i < 12; i++) {
                addProject(tab);
            }
        } else if (tab == "JS Module") {
            for (let i = 0; i < 12; i++) {
                addProject(tab);
            }
        } else if (tab == "JS Only") {
            for (let i = 0; i < 12; i++) {
                addProject(tab);
            }
        } else if (tab == "CSS Only") {
            for (let i = 0; i < 12; i++) {
                addProject(tab);
            }
        } else {
            for (let i = 0; i < 12; i++) {
                addProject(tab);
            }
        }




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
    <div   class="card">
    <div class="card__open">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path fill="grey" d="M32 32C14.3 32 0 46.3 0 64v96c0 17.7 14.3 32 32 32s32-14.3 32-32V96h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H32zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7 14.3 32 32 32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H64V352zM320 32c-17.7 0-32 14.3-32 32s14.3 32 32 32h64v64c0 17.7 14.3 32 32 32s32-14.3 32-32V64c0-17.7-14.3-32-32-32H320zM448 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64H320c-17.7 0-32 14.3-32 32s14.3 32 32 32h96c17.7 0 32-14.3 32-32V352z"/></svg>
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


    const container = document.querySelector(".tabs");
    const content = document.querySelector(".tab");
    const leftButton = document.querySelector(".left");
    const rightButton = document.querySelector(".right");
    const step = 100;
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
        for (let i = 0; i < 24; i++) {
            addProject(i);
        }

    }
    </script>
    <script>
    document.head.innerHTML += '<link rel="icon" type="image/png" href="../../assets/images/logo.png">';
    </script>
    <script src="https://cdn.jsdelivr.net/npm/browser-scss@1.0.3/dist/browser-scss.min.js"></script>

</body>

</html>