<?php
require "head.php";
require "spam.php";

?>
<html>
<head>
    <title>Input List</title>
    <style>
        .list-item {
            display: inline-block;
            padding: 5px;
            margin: 5px;
            background-color: #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>




    <input type="text" id="input" />
    <input type="hidden" id="list" value="" />
    <div id="list-container"></div>

    <script>
        const input = document.getElementById('input');
        const list = document.getElementById('list');
        const listContainer = document.getElementById('list-container');

        input.addEventListener('keyup', (e) => {
            if (e.keyCode === 13) {
                const value = input.value;
                if (value) {
                    const listValue = list.value ? list.value.split(',') : [];
                    listValue.push(value);
                    list.value = listValue.join(',');
                    input.value = '';
                    renderList();
                }
            }
        });

        const renderList = () => {
            listContainer.innerHTML = '';
            const listValue = list.value ? list.value.split(',') : [];
            listValue.forEach((item, index) => {
                const itemElement = document.createElement('div');
                itemElement.classList.add('list-item');
                itemElement.innerHTML = item;

                const deleteButton = document.createElement('button');
                deleteButton.innerHTML = 'X';
                deleteButton.addEventListener('click', () => {
                    listValue.splice(index, 1);
                    list.value = listValue.join(',');
                    renderList();
                });

                itemElement.appendChild(deleteButton);
                listContainer.appendChild(itemElement);
            });
        };
    </script>
</body>
</html>