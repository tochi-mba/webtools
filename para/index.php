<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .tooltip {
        position: relative;
    }

    .tooltip::before {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        background-color: #333;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        font-size: 14px;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
        pointer-events: none;
    }

    .tooltip.active::before {
        content: attr(data-tooltip);
        opacity: 1;
        z-index: 9999;
    }
    </style>
</head>

<body>
    <label for="input">Input: </label>
    <textarea name="input" id="input" cols="30" rows="10"></textarea>
    <button onclick="paraphrase()">Paraphrase</button>
    <label for="threshold">Threshold: </label>
    <input name="threshold" type="number" id="threshold" placeholder="enter threshold">
    <div id="avgOutput"></div>
    <label for="output">Output: </label>
    <div style="position:relative;margin-bottom:100px" name="output" id="output">
    </div>


    <script>
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
                        `API request failed with status ${xhr.status}: ${xhr.statusText}`));
                }
            };
            xhr.onerror = function() {
                reject(new Error('API request failed due to a network error.'));
            };
            xhr.send(JSON.stringify(data));
        });
    }

    function paraphrase() {
        console.log("pp")
        var input = document.getElementById("input").value;        var threshold = document.getElementById("threshold").value;
        var data = {
            input: input,
            threshold: threshold
        }
        var baseUrl = window.location.protocol + "//" + window.location.hostname;
        var url = baseUrl + "/para/api/paraphrase/";
        makeApiRequest('POST', url, data)
            .then(function(response) {
                var output = document.getElementById("output");
                response = JSON.parse(response);
                console.log(response)
                output.innerHTML = "";
                for (var i = 0; i < response[0].all.length; i++) {
                    if (response[0].all[i][0].valid == true) {
                        output.innerHTML += "<span real='"+response[0].all[i][0].real+"' class='tooltip show' style='background-color:green'>" +
                            response[0].all[i][0].input + " </span>";
                    } else {
                        output.innerHTML += "<span real='"+response[0].all[i][0].real+"' class='tooltip show' style='background-color:red'>" + response[
                            0].all[i][0].input + " </span>";
                    }
                }
                document.getElementById("avgOutput").innerHTML = "Average Score: " + response[0].avg;
                const tooltip = document.querySelectorAll('.tooltip');

                tooltip.forEach((tooltip) => {
                    tooltip.addEventListener('mouseover', () => {
                        tooltip.classList.add('active');
                    });

                    tooltip.addEventListener('mouseleave', () => {
                        tooltip.classList.remove('active');
                    });

                    tooltip.setAttribute('data-tooltip', tooltip.getAttribute('real'));
                });


            })
            .catch(function(error) {
                console.error(error);
            });
    }
    </script>
</body>

</html>