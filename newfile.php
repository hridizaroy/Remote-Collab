
<?php
    
    $file_to_open = $fileDir = $file = $fileContent = $nowOpen = "";

    function listing(){
        global $file_to_open, $fileDir, $file, $fileContent;

        $fileList = array();

        if($handle = opendir(".\\team1\\project1\\files\\")) {
            while ($entry = readdir($handle)) {
                if ( $entry != "."  && $entry != ".." ){
                    array_push($fileList, $entry);
                }
            }
            closedir($handle);
        }

        for ($i = 0; $i < count($fileList); $i++) {
            echo("<li>".$fileList[$i]."</li>");
        }
    }

    function open() {
        global $file_to_open, $fileDir, $file, $fileContent, $nowOpen;

        $file_to_open = $nowOpen = $_POST['toOpenFileName'];
        $fileDir = ".\\team1\\project1\\files\\";

        $file = fopen($fileDir.$file_to_open, "r");

        $fileContent = strval( fread($file, filesize($fileDir.$file_to_open)) );
        fclose($file);
        echo $fileContent;
    }

    function update() {
        global $file_to_open, $fileDir, $file, $fileContent;

        $fileOpenContent = $_POST['openedFile'];
        $fileOpenDir = ".\\team1\\project1\\files\\";

        $openFile = fopen($fileOpenDir.$file_to_open, "w");

        fwrite($openFile, $fileOpenContent);
        fclose($openFile);

        getUpdated();
    }

    function getUpdated() {
        global $file_to_open, $fileDir, $file, $fileContent;

        if($file_to_open !== "") {
            $file = fopen($fileDir.$file_to_open, "r");
            $fileContent = fread($file, filesize($fileDir.$file_to_open));
            fclose($file);
        }

        echo $fileContent;
    }

    function test() {
        global $file_to_open, $fileDir, $file, $fileContent;

        $file_to_open = "test1.txt";
        $fileDir = ".\\team1\\project1\\files\\";

        $file = fopen($fileDir.$file_to_open, "r");

        $fileContent = strval( fread($file, filesize($fileDir.$file_to_open)) );
        fclose($file);
        echo $fileContent;
    }

?>


<html>
    <head>
        <title>Open File</title>
        <style>
            .chatwindow {
                position: absolute;
                top: 0;
                right: 0;
                height: 500px;
                width: 300px;
                border: 1px solid #000;
            }

            .send {
                position: absolute;
                bottom: 0;
            }

            .chat {
                width: 300px;
                height: 35px;
                min-height: 35px;
                padding-top: 3px;
                padding-bottom: 3px;
                max-height: 150px;
            }

            .msgContainer {
                display: block;
            }

            .msg {
                padding: 3px 8px;
                margin: 10px 5px;
                border: 0.5px solid #000;
                display: inline-block;
            }

            .msgs {
                height: 400px;
                overflow: auto;
            }

            .date {
                margin: auto;
                text-align: center;
            }

        </style>
    </head>
    <body>

        <iframe name="hiddenFrame" width="0" height="0" style="display: none;"></iframe>


        <ul class = "files">
        <?php
            listing();
        ?>
        </ul>

                <!--For opening a file-->
        <form class = "openName" action = "newfile2.php" target="newfile2.php" method = "post">
            <input type = "text" name = "toOpenFileName" hidden>
        </form>

        <form action = "newfile2.php" target="newfile2.php" method = "post" id = "openName">
            <textarea type = "text" name = "openedFile" rows = "20" cols = "100" id = "openedFile"><?php
                if ( isset($_POST['toOpenFileName']) ) {
                    open();
                }
            ?>
            </textarea>
            <input class = "nowOpen" id = "openFileName" name = "openFileName" value = "<?php echo $nowOpen ?>" hidden>
        </form>

        <button class = "update">Update</button>
        <div class = "nowOpen"><p><?php echo $nowOpen ?></p></div>

        <div class = "chatwindow">
            <p>Chat</p>
            <div class = "msgs">
            </div>
            <div class = "send">
                <textarea type = "text" class = "chat"></textarea>
                <button class = "sendButton">Send</button>
                <input name = "user" value = "user_name" class = "user" hidden>
            </div>
        </div>

        <script>

            var file = document.getElementById('openName');
            var openedFile = document.getElementById('openedFile');
            var nowOpen = document.querySelector(".nowOpen p").innerText;
            var updateInterval;
            var getUpdatedInterval;

            var files = document.querySelectorAll(".files li");

            function open() {
                var openValue = document.querySelector(".openName input");
                openValue.value = this.innerText;
                document.querySelector(".openName").submit();
            }

            for ( var i = 0; i < files.length; i++) {
                files[i].addEventListener('click', open);
            }

            if (nowOpen !== "") {
                openedFile.addEventListener('input', update);
                getUpdatedInterval = setInterval(getUpdated, 500);
                document.getElementsByClassName('update')[0].addEventListener('click', getUpdated);
            }

            function update() {

                clearInterval(getUpdatedInterval);
                const params1 = "openedFile=" + document.querySelector('#openedFile').value + "&openFileName=" + document.querySelector('#openFileName').value;

                var xhttp1 = new XMLHttpRequest();
                var url = "update.php"; //tried to change page
                xhttp1.open("POST", url, true);
                xhttp1.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp1.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Updated
                        console.log('updated yo');
                        getUpdatedInterval = setInterval(getUpdated, 500);
                    }
                };
                xhttp1.send(params1);
            }

            function getUpdated() {

                const params2 = "openFileName=" + document.querySelector('#openFileName').value;

                var xhttp2 = new XMLHttpRequest();
                var url = "open.php";
                xhttp2.open("POST", url, true);
                xhttp2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp2.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(!(xhttp2.responseText.startsWith("<") || xhttp2.responseText === openedFile.value)){
                            var caretPos = getCaretPosition(openedFile);
                            openedFile.value = xhttp2.responseText;
                            console.log('Up to date');
                            setCaretPosition(openedFile, caretPos);
                        }
                    /*    else if (xhttp2.responseText.startsWith("<") ){
                            console.log('world is broken');
                        }
                        else if (xhttp2.responseText === openedFile.value) {
                            console.log('what');
                        }
                        else {
                            console.log('else?');
                        }*/
                    }
                };
                xhttp2.send(params2);
            }

            function getCaretPosition(elem) {
                var startPos = elem.selectionStart;
                var endPos = elem.selectionEnd;
                return startPos;
            }

            function setCaretPosition(elem, caretPos) {
                if(elem.createTextRange) {
                    var range = elem.createTextRange();
                    range.collapse(true);
                    range.moveEnd('character', caretPos);
                    range.moveStart('character', caretPos);
                    range.select();
                    return;
                }

                if(elem.selectionStart) {
                    elem.focus();
                    elem.setSelectionRange(caretPos, caretPos);
                }
            }

            document.querySelector(".chat").addEventListener('input', print);

            function print() {
                /*var text = document.querySelector(".chat").value;
                var lines = text.split("\n");
                var count = lines.length;*/
                var sh = document.querySelector(".chat").scrollHeight;
                var ch = document.querySelector(".chat").clientHeight;
                document.querySelector(".chat").style.height = sh + "px";
                if (ch < 148) {
                    document.querySelector(".chat").style.overflow = "hidden";
                }
                else {
                    document.querySelector(".chat").style.overflow = "auto";
                }
                //console.log(sh);
                //console.log(ch);
            }

            document.querySelector(".sendButton").addEventListener('click', send);
            var updateChatsInterval = setInterval(getChats, 500);

            var chats = "";

            function send() {

                var date = new Date();
                var day = date.getDate();
                var month = date.getMonth();
                var year = date.getFullYear();
                var h = date.getHours();
                var m = date.getMinutes();
                var time = h + ":" + m;
                var fullDate = String(day) + "/" + String(month) + "/" + String(year);
                var fileName = "project1"; //Find a way to get value based on current project

                const params3 = "user=" + document.querySelector('.user').value + "&chatContent=" + document.querySelector('.chat').value + "&time=" + time + "&fileName=" + fileName + "&fullDate=" + fullDate;

                var xhttp3 = new XMLHttpRequest();
                var url = "chat.php"; //tried to change page
                xhttp3.open("POST", url, true);

                xhttp3.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp3.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Updated
                        console.log('updated chat');
                    }
                };
                xhttp3.send(params3);

                document.querySelector(".chat").value = "";
                document.querySelector(".chat").style.height = "35px";
            }

            function getChats(){

                var date = new Date();
                var day = date.getDate();
                var month = date.getMonth();
                var year = date.getFullYear();
                var h = date.getHours();
                var m = date.getMinutes();
                var time = h + ":" + (m).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false});
                var fullDate = String(day) + "/" + String(month) + "/" + String(year);
                var fileName = "project1"; //Find a way to get value based on current project

                const params4 = "fileName=" + fileName+ "&fullDate=" + fullDate;

                var xhttp4 = new XMLHttpRequest();
                var url = "getChats.php"; //tried to change page
                xhttp4.open("POST", url, true);

                xhttp4.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp4.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(!(xhttp4.responseText.startsWith("<") || xhttp4.responseText === chats)) {
                            // Updated

                            console.log('got chats');

                            var msg, user, msgTime, msgDate;
                            var updateChats = xhttp4.responseText;
                            chats = updateChats;

                            updateChats = updateChats.split("Msg: ");

                            var dates = document.body.getElementsByClassName('date');

                            document.querySelector(".msgs").innerHTML = "";

                            for (var i = 1; i < updateChats.length; i++){
                                msg = updateChats[i].split("User: ")[0];
                                user = updateChats[i].split("User: ")[1].split("Time: ")[0];
                                msgTime = updateChats[i].split("User: ")[1].split("Time: ")[1].split("Date: ")[0];
                                msgDate = updateChats[i].split("User: ")[1].split("Time: ")[1].split("Date: ")[1];
                                console.log(msgDate);

                                var container = document.createElement("div");
                                container.classList.add("msgContainer");

                                var dateP = document.createElement("p");
                                dateP.classList.add("date");

                                var dateRepeat = false;

                                for (var t = 0; t < dates.length; t++) {
                                    if (dates[t].innerHTML === msgDate) {
                                        dateRepeat = true;
                                        break;
                                    }
                                }

                                if (!(dateRepeat)) {
                                    dateP.innerHTML = msgDate;
                                    container.appendChild(dateP);
                                }

                                var newMsg = document.createElement("div");
                                newMsg.classList.add("msg");

                                var content = document.createElement("div");
                                content.classList.add("content");
                                content.innerHTML = msg;
                                var memberName = document.createElement("div");
                                memberName.classList.add("memberName");
                                memberName.innerHTML = user;
                                var timeOfMsg = document.createElement("div");
                                timeOfMsg.classList.add("time");
                                timeOfMsg.innerHTML = msgTime;

                                newMsg.appendChild(content);
                                newMsg.appendChild(memberName);
                                newMsg.appendChild(timeOfMsg);

                                container.appendChild(newMsg);

                                document.querySelector(".msgs").appendChild(container);

                                document.querySelector(".msgs").scrollTop = document.querySelector(".msgs").scrollHeight;
                            }
                        }
                    }
                };
                xhttp4.send(params4);
            }

        </script>
    </body>
</html>
