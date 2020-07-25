<html>
    <head>
        <title>Draw</title>

        <style>
            .point {
                position: absolute;
                border-radius: 50%;
                background-color: #000;
                width: 10px;
                height: 10px;
            }

            #canvas {
                background-color: #fff;
                
            }
        </style>
    </head>

    <body>


        <div id = "image">
            <img>
        </div>

        <script>

            setInterval(getImg, 100);

            var image = document.querySelector('#image img');

            function getImg() {

                var xhttp = new XMLHttpRequest();
                var url = "getDrawing.php";
                xhttp.open("POST", url, true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var newSrc = "data:image/png;base64," + xhttp.responseText;
                        if (image.src != newSrc) {
                            image.src = newSrc;
                        }                        
                    }
                };
                xhttp.send();
            }
        
        </script>

    </body>

</html>