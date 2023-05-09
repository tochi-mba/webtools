<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #head{
            width: 100px;
            height: 100px;
            background-color: black;
            border-radius: 50%;
            position: absolute;
            top: 50px;
            left: 50%;
            transform: translateX(-50%);
        }

        #neck{
            width: 20px;
            height: 20px;
            background-color: black;
            position: absolute;
            top: 150px;
            left: 50%;
            transform: translateX(-50%);
        }

        #body{
            width: 100px;
            height: 100px;
            background-color: black;
            position: absolute;
            top: 170px;
            left: 50%;
            transform: translateX(-50%);
        }

        #left-arm{
            width: 100px;
            height: 20px;
            background-color: black;
            position: absolute;
            top: 170px;
            left: 50%;
            transform: translateX(-150%);
        }

        #right-arm{
            width: 100px;
            height: 20px;
            background-color: black;
            position: absolute;
            top: 170px;
            left: 50%;
            transform: translateX(50%);
        }

        #left-leg{
            width: 20px;
            height: 100px;
            background-color: black;
            position: absolute;
            top: 270px;
            left: 50%;
            transform: translateX(-150%);
        }

        #right-leg{
            width: 20px;
            height: 100px;
            background-color: black;
            position: absolute;
            top: 270px;
            left: 50%;
            transform: translateX(50%);
        }
    </style>
</head>
<body>
    <div>
        <div id="head"></div>
        <div id="neck"></div>
        <div id="body"></div>
        <div id="left-arm"></div>
        <div id="right-arm"></div>
        <div id="left-leg"></div>
        <div id="right-leg"></div>
    </div>
    <script>
    const stickman = document.querySelector('div');
    const body = document.querySelector('#body');
    const leftLeg = document.querySelector('#left-leg');
    const rightLeg = document.querySelector('#right-leg');

    let position = 'center'; //initial position
    let walking = false; //flag to check if stickman is walking or not

    //function to move stickman left
    function moveLeft() {
        if (position == 'center') {
            stickman.style.left = '0px';
            position = 'left';
        } else if (position == 'right') {
            stickman.style.left = '50%';
            position = 'center';
        }
    }

    //function to move stickman right
    function moveRight() {
        if (position == 'center') {
            stickman.style.left = '100%';
            position = 'right';
        } else if (position == 'left') {
            stickman.style.left = '50%';
            position = 'center';
        }
    }

    //function to make stickman walk
    function walk() {
        walking = true;
        let count = 0;
        let timer = setInterval(function() {
            if (position == 'left') {
                body.style.transform = 'rotate(10deg)';
                leftLeg.style.transformOrigin = 'bottom left';
                leftLeg.style.transform = 'rotate(' + (count * 5) + 'deg)';
                rightLeg.style.transformOrigin = 'top right';
                rightLeg.style.transform = 'rotate(' + (count * -5) + 'deg)';
            } else if (position == 'right') {
                body.style.transform = 'rotate(-10deg)';
                leftLeg.style.transformOrigin = 'top left';
                leftLeg.style.transform = 'rotate(' + (count * -5) + 'deg)';
                rightLeg.style.transformOrigin = 'bottom right';
                rightLeg.style.transform = 'rotate(' + (count * 5) + 'deg)';
            }
            count++;
        }, 50);

        //stop walking after 1000ms
        setTimeout(function() {
            walking = false;
            clearInterval(timer);
            body.style.transform = 'rotate(0deg)';
            leftLeg.style.transformOrigin = 'top left';
            leftLeg.style.transform = 'rotate(0deg)';
            rightLeg.style.transformOrigin = 'top right';
            rightLeg.style.transform = 'rotate(0deg)';
        }, 1000);
    }

    //event listener for keyboard arrow keys
    document.addEventListener('keydown', function(event) {
        if (event.code === 'ArrowLeft') { //left arrow key
            moveLeft();
        } else if (event.code === 'ArrowRight') { //right arrow key
            moveRight();
        } else if (event.code === 'ArrowUp' && !walking) { //up arrow key
            walk();
        }
    });
</script>
</body>
</html>