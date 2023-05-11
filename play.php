<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="stuff">

    </div>
    <input type="text" class="publishJSON">
    <script>
    function htmlDecode1(str) {
        var el = document.createElement("div");
        el.innerHTML = str;
        str = el.innerText;
        return str;
    }

    function htmlEncode1(str) {
        var el = document.createElement("div");
        el.innerText = el.textContent = str;
        str = el.innerHTML;
        return str;
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
    document.querySelector('.publishJSON').addEventListener('keyup', function() {

        json =
            `[{"title":"","subSections":[{"title":"","info":[{"type":"html","content":"&amp;lt;iframe height=\"300\" style=\"width: 100%;\" scrolling=\"no\" title=\"Quote Poster - Jim Bridwell\" src=\"https://codepen.io/josetxu/embed/wvYyaNa?default-tab=html\" frameborder=\"no\" loading=\"lazy\" allowtransparency=\"true\" allowfullscreen=\"true\"&amp;gt;&lt;br&gt;  See the Pen &amp;lt;a href=\"https://codepen.io/josetxu/pen/wvYyaNa\"&amp;gt;&lt;br&gt;  Quote Poster - Jim Bridwell&amp;lt;/a&amp;gt; by Josetxu  (&amp;lt;a href=\"https://codepen.io/josetxu\"&amp;gt;@josetxu&amp;lt;/a&amp;gt;)&lt;br&gt;  on &amp;lt;a href=\"https://codepen.io\"&amp;gt;CodePen&amp;lt;/a&amp;gt;.&lt;br&gt;&amp;lt;/iframe&amp;gt;"}]}]},{"title":"","subSections":[{"title":"","info":[{"type":"html","content":"&amp;lt;iframe height=\"300\" style=\"width: 100%;\" scrolling=\"no\" title=\"Quote Poster - Jim Bridwell\" src=\"https://codepen.io/josetxu/embed/wvYyaNa?default-tab=html\" frameborder=\"no\" loading=\"lazy\" allowtransparency=\"true\" allowfullscreen=\"true\"&amp;gt;&lt;br&gt;  See the Pen &amp;lt;a href=\"https://codepen.io/josetxu/pen/wvYyaNa\"&amp;gt;&lt;br&gt;  Quote Poster - Jim Bridwell&amp;lt;/a&amp;gt; by Josetxu  (&amp;lt;a href=\"https://codepen.io/josetxu\"&amp;gt;@josetxu&amp;lt;/a&amp;gt;)&lt;br&gt;  on &amp;lt;a href=\"https://codepen.io\"&amp;gt;CodePen&amp;lt;/a&amp;gt;.&lt;br&gt;&amp;lt;/iframe&amp;gt; "}]},{"title":"zz","info":[{"type":"html","content":"&amp;lt;div style=\"width:100%;background-color:red;height:80%;top:0;position:sticky;\"&amp;gt;fff&amp;lt;/div&amp;gt;"}]}]}]`
        stuff = document.querySelector('.stuff')
        json = JSON.parse(document.querySelector('.publishJSON').value);
        stuff.innerHTML = '';
        for (let i = 0; i < json.length; i++) {
            stuff.innerHTML += `<input value="` + json[i]['title'] + `" id="section` + i + `Input" position="` +
                i + `"/>`;
            input = document.getElementById("section" + i + "Input");

            // Define the event handler function
            function handleKeyUp(event) {
                var publishJSON = json;
                publishJSON = JSON.parse(publishJSON.value);
                var position = event.target.getAttribute("position");
                var encodedValue = htmlEncode(event.target.value.replace(/"/g, '\"'));
                var escapedValue = htmlEncode(encodedValue)
                publishJSON[position]['title'] = escapedValue;
            }

            // Add a debounced keyup event listener to the input element
            input.addEventListener("keyup", debounce(handleKeyUp, 1000));
            for (let j = 0; j < json[i].subSections.length; j++) {
                stuff.innerHTML += `<input value="` + json[i].subSections[j]['title'] + `" id="subSecton` + i +
                    j + `Input" position="` + i + `" position1="` + j + `"/> 
            
            <select id="subSectionType` + i + j + `" position="` + i + `" position1="` + j + `"> 
            <option value="text">Text</option>
            <option value="html">HTML</option>
            <option value="code">Code</option>
            </select>
            
            `;
                stuff.innerHTML += '<button style="width:30px" onclick="addInfo(`' +
                    i + '`,`' + j +
                    '`,document.getElementById(`' + "subSectionType" + i + j +
                    '`).value);"><svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path fill="black" d="M105.1 202.6c7.7-21.8 20.2-42.3 37.8-59.8c62.5-62.5 163.8-62.5 226.3 0L386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H463.5c0 0 0 0 0 0h.4c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0C73.2 122 55.6 150.7 44.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5zM39 289.3c-5 1.5-9.8 4.2-13.7 8.2c-4 4-6.7 8.8-8.1 14c-.3 1.2-.6 2.5-.8 3.8c-.3 1.7-.4 3.4-.4 5.1V448c0 17.7 14.3 32 32 32s32-14.3 32-32V396.9l17.6 17.5 0 0c87.5 87.4 229.3 87.4 316.7 0c24.4-24.4 42.1-53.1 52.9-83.7c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.5 62.5-163.8 62.5-226.3 0l-.1-.1L125.6 352H176c17.7 0 32-14.3 32-32s-14.3-32-32-32H48.4c-1.6 0-3.2 .1-4.8 .3s-3.1 .5-4.6 1z"/></svg></button>';

                input = document.getElementById(`subSecton` + i + j + `Input`);

                // Define the event handler function
                function handleKeyUp(event) {
                    var publishJSON = json;
                    publishJSON = JSON.parse(publishJSON.value);
                    var position = event.target.getAttribute("position");
                    var position1 = event.target.getAttribute("position1");
                    var encodedValue = htmlEncode(event.target.value.replace(/"/g, '\"'));
                    var escapedValue = htmlEncode(encodedValue)
                    publishJSON[position]['subSections'][position1]['title'] = escapedValue;
                }

                // Add a debounced keyup event listener to the input element
                input.addEventListener("keyup", debounce(handleKeyUp, 1000));
                for (let k = 0; k < json[i].subSections[j].info.length; k++) {
                    if (json[i].subSections[j].info[k].type == 'html') {
                        stuff.innerHTML += `<textarea class="html" id="info` + i + j +
                            `" style="width:100%;height:100px"></textarea>`;
                        input = document.getElementById(`info` + i + j);
                        content = json[i].subSections[j].info[0].content;
                        // Define the event handler function
                        input.innerHTML = htmlDecode1(content);
                    } else if (json[i].subSections[j].info[
                            k].type == 'text') {
                        stuff.innerHTML += `<textarea class="text" id="info` + i + j +
                            `" style="width:100%;height:100px"></textarea>`;
                        input = document.getElementById(`info` + i + j);
                        content = json[i].subSections[j].info[0].content;
                        // Define the event handler function
                        input.value = htmlDecode1(content);
                    } else if (json[i].subSections[j].info[k].type == 'code') {
                        stuff.innerHTML += `<textarea class="code" id="info` + i + j +
                            `" style="width:100%;height:100px"></textarea>`;
                        input = document.getElementById(`info` + i + j);
                        content = json[i].subSections[j].info[0].content;
                        // Define the event handler function
                        input.value = htmlDecode1(content);
                    }


                }
            }
        }
    })
    </script>
</body>

</html>