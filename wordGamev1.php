<?php

/*TODO
***Database of users and who gets to play 
***Round based on database
***Temp file to store the game
*/

//?>

<html>
<head>
<style>
.nextRound {
    display: none;
}
</style>
</head>
<body>
    <p id = "wordPrompt"></p>
    <input type = "text" id = "wordNext">
    <button id = "submit">Submit</button>
    <p id = "timer"></p>
    <button class = "nextRound">Next Round</button>
    <p id = "msg">Please enter word</p>

    <script>
    //Add a 'start round button' and call set function on it when clicked
    //The button shows only when it's your turn

        var timer;
        var word;
        var newRound = false;
        var wordList = [];

        generateWord();
        

        document.querySelector('.nextRound').addEventListener('click', set);

        document.getElementById('submit').addEventListener('click', next);

        document.getElementById('wordNext').onkeydown = function(e) {
            if (e.keyCode == 13) {
                next();
            }
        }

        function set() {
            wordList = [];
            
            document.getElementById('submit').addEventListener('click', next);
            document.getElementById('wordNext').onkeydown = function(e) {
                if (e.keyCode === 13) {
                    next();
                }
            }

            generateWord();
            document.getElementById('wordNext').value = "";
            document.querySelector('.nextRound').style.display = "none";
            newRound = true;
            next();

        }

        function next() {
            document.getElementById('msg').style.display = 'none';

            if (document.getElementById('wordNext').value != '' || newRound) {
                newRound = false;

                if (wordList.includes(document.getElementById('wordNext').value.toLowerCase())) {
                    document.getElementById('timer').innerHTML = "Word already used!";
                    roundOver();
                }

                else {
                    //Alt: document.getElementById('wordPrompt').innerHTML = document.getElementById('wordNext').value; (for new prompt = word typed)
                    generateWord();
                    wordList.push(document.getElementById('wordNext').value.toLowerCase());
                    //Write Code to send this word to server file

                    if(timer) {
                        clearInterval(timer);
                        timer = false;
                    }
                    
                    document.getElementById('wordNext').value = "";
                    if(!timer) {
                        var x = 3; //Countdown from
                        document.getElementById('timer').innerHTML = x;
                        timer = setInterval(() => {
                            if(x > 1) {
                                x -= 1;
                                document.getElementById('timer').innerHTML = x;
                            }
                            else {
                                document.getElementById('timer').innerHTML = "Time Up!!!";
                                roundOver();
                            }
                        }, 1000);
                    }
                }

            }
            else {
                //Please enter a word msg
                document.getElementById('msg').style.display = 'block';
            }
        }

        function roundOver() {
            document.getElementById('submit').removeEventListener('click', next);
            document.getElementById('wordNext').onkeydown = function(e) {}
            document.querySelector('.nextRound').style.display = "block";
            document.getElementById('msg').style.display = 'none';
            clearInterval(timer);
            timer = false;
        }

        function generateWord() {
            var xhttp = new XMLHttpRequest();
            var url = "genWord.php"; //tried to change page
            xhttp.open("POST", url, true);

            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    //New Word
                   document.getElementById('wordPrompt').innerHTML = xhttp.responseText;
                }
            };
            xhttp.send();
        }
        
     </script>
</body>
</html>
