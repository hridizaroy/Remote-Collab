<html>
    <head>
        <title>Board</title>

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


        <canvas id = "canvas"></canvas>



        <script src="https://cdn.jsdelivr.net/processing.js/1.4.8/processing.min.js"></script>

        <script>

            //Add eraser, clear screen and color options

            var sketchProc = function (processingInstance) {
                with (processingInstance) {
                    size(innerWidth - 30, innerHeight-175);
                    frameRate(30);

                    function paint() {
                        stroke(0, 0, 0);
                        fill(0, 0, 0);
                        ellipse(mouseX, mouseY, 10, 10);
                        sendImg();
                    }

                    var draw = function(){
                        
                        mouseDragged = function () {
                            paint();
                        }

                        mouseClicked = function(){
                            paint();
                        }

                    }

                }
            };


            var canvas = document.getElementById("canvas"); 

            var processingInstance = new Processing(canvas, sketchProc); 

            function sendImg() {

                const params = "pic=" + canvas.toDataURL('image/png');
                console.log(canvas.toDataURL('image/png'));

                var xhttp = new XMLHttpRequest();
                var url = "drawData.php";
                xhttp.open("POST", url, true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log('yup');
                    }
                };
                xhttp.send(params);
            }            
        
        </script>

    </body>

</html>
