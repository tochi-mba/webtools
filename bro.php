<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .grid-container {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        grid-gap: 10px;
        position: relative;
        /* make the container a positioned element */
    }

    .grid-item {
        background-color: #ccc;
        padding: 20px;
        text-align: center;
        height: 100px;
    }

    .character {
  position: absolute;
  top: 0;
  left: 0;
  height:148px;
width:100%;
background:url(character-sprite-sheet.png) -84px -10px no-repeat;
   animation: walk-right 3s steps(7) infinite;
}
@keyframes walk-right {
  0% {
    background-position: -84px -10px;
  }
  15% {
    background-position: -84px -10px;
  }
  30% {
    background-position: -163px -14px;
  }
  45% {
    background-position: -243px -14px;
  }
  60% {
    background-position: -339px -14px;
  }
  75% {
    background-position: -426px -14px;
  }
  90% {
    background-position: -518px -14px;
  }
  100% {
    background-position: -690px -5px;
    height: 150px;
    width: 146px;
  }
}

@keyframes walk-left {
  0% {
    background-position: -384px 0;
  }
  100% {
    background-position: -640px 0;
  }
}

@keyframes idle {
  0% {
    background-position: -256px 0;
  }
  100% {
    background-position: -256px 0;
  }
}



    @keyframes walk {
        0% {
            transform: translateX(0);
        }

        50% {
            transform: translateX(30px);
        }

        100% {
            transform: translateX(0);
        }
    }
    </style>
</head>

<body>
    <div class="grid-container">
        <div class="grid-item">1</div>
        <div class="grid-item">2</div>
        <div class="grid-item">3</div>
        <div class="grid-item">4</div>
        <div class="grid-item">5</div>
        <div class="grid-item">6</div>
        <div class="grid-item">7</div>
        <div class="grid-item">8</div>
        <div class="grid-item">9</div>
        <div class="grid-item">10</div>
        <div class="grid-item">1</div>
        <div class="grid-item">2</div>
        <div class="grid-item">3</div>
        <div class="grid-item">4</div>
        <div class="grid-item">5</div>
        <div class="grid-item">6</div>
        <div class="grid-item">7</div>
        <div class="grid-item">8</div>
        <div class="grid-item">9</div>
        <div class="grid-item">10</div>
        <div class="grid-item">1</div>
        <div class="grid-item">2</div>
        <div class="grid-item">3</div>
        <div class="grid-item">4</div>
        <div class="grid-item">5</div>
        <div class="grid-item">6</div>
        <div class="grid-item">7</div>
        <div class="grid-item">8</div>
        <div class="grid-item">9</div>
        <div class="grid-item">10</div>
        <div class="grid-item">1</div>
        <div class="grid-item">2</div>
        <div class="grid-item">3</div>
        <div class="grid-item">4</div>
        <div class="grid-item">5</div>
        <div class="grid-item">6</div>
        <div class="grid-item">7</div>
        <div class="grid-item">8</div>
        <div class="grid-item">9</div>
        <div class="grid-item">10</div>
        <div class="grid-item">1</div>
        <div class="grid-item">2</div>
        <div class="grid-item">3</div>
        <div class="grid-item">4</div>
        <div class="grid-item">5</div>
        <div class="grid-item">6</div>
        <div class="grid-item">7</div>
        <div class="grid-item">8</div>
        <div class="grid-item">9</div>
        <div class="grid-item">10</div>
        <img class="character">
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r79/three.min.js"></script>
    <script>
    const character = document.querySelector('.character');
    const gridItems = document.querySelectorAll('.grid-item');
    let currentGridItem = null;

    function isElementMostlyVisible(el) {
        const rect = el.getBoundingClientRect();
        const windowHeight = window.innerHeight || document.documentElement.clientHeight;
        const windowWidth = window.innerWidth || document.documentElement.clientWidth;
        const vertInView = (rect.top <= windowHeight) && ((rect.top + rect.height) >= (0.5 * rect.height));
        const horInView = (rect.left <= windowWidth) && ((rect.left + rect.width) >= (0.5 * rect.width));
        return (vertInView && horInView);
    }

    function moveCharacter() {
        let visibleGridItems = [];

        // Get all visible grid items
        gridItems.forEach(item => {
            const isVisible = isElementMostlyVisible(item);
            if (isVisible) {
                visibleGridItems.push(item);
            }
        });

        // If the current grid item is not visible, select a new one
        if (!visibleGridItems.includes(currentGridItem)) {
            currentGridItem = visibleGridItems[Math.floor(Math.random() * visibleGridItems.length)];
        }

        // Move the character to the center of the current grid item
        const rect = currentGridItem.getBoundingClientRect();
        const containerRect = currentGridItem.parentNode.getBoundingClientRect();
        const x = rect.left - containerRect.left + (rect.width / 2) - (character.offsetWidth / 2);
        const y = rect.top - containerRect.top + (rect.height / 2) - (character.offsetHeight / 2);

        character.style.top = `${y}px`;
        character.style.left = `${x}px`;
        // Calculate the direction to move the character
        const deltaX = x - parseFloat(character.style.left);
        const deltaY = y - parseFloat(character.style.top);
        const direction = deltaX > 0 ? 'right' : 'left';

        // Update the character sprite position
        character.style.top = `${y}px`;
        character.style.left = `${x}px`;
        character.style.transform = `scaleX(${direction === 'right' ? 1 : -1})`;

        // Change the character animation based on direction
        if (deltaX !== 0 || deltaY !== 0) {
            character.style.animationName = direction === 'right' ? 'walk-right' : 'walk-left';
        } else {
            character.style.animationName = 'idle';
        }

    }

    function moveCharacterRandomly() {
        // Get all visible grid items
        let visibleGridItems = [];
        gridItems.forEach(item => {
            const isVisible = isElementMostlyVisible(item);
            if (isVisible) {
                visibleGridItems.push(item);
            }
        });

        // If there are visible grid items, select a random one and move the character there
        if (visibleGridItems.length > 0) {
            currentGridItem = visibleGridItems[Math.floor(Math.random() * visibleGridItems.length)];
            moveCharacter();
        }

        // Move the character again after a random amount of time
        setTimeout(moveCharacterRandomly, Math.random() * 5000 + 2000);
    }

    moveCharacterRandomly();

    document.addEventListener('click', () => {
        character.style.animation = 'fly 0.5s';
        setTimeout(() => {
            character.style.animation = 'walk-left 1s steps(4) infinite';
        }, 500);
    });
    </script>

</body>

</html>