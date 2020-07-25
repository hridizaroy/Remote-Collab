<?php

 //   if($_POST['task'] === "getUpdated") {
        $file_name = $_POST['openFileName'];

        $fileDir = ".\\team1\\project1\\files\\";

        $file = fopen($fileDir.$file_name, "r");
        $fileContent = strval(fread($file, filesize($fileDir.$file_name)));
        fclose($file);

        echo $fileContent;
 /*   }

    elseif ($_POST['task'] === "update") {
        $file_to_open = $_POST['openFileName'];

        $fileOpenContent = $_POST['openedFile'];
        $fileOpenDir = ".\\team1\\project1\\files\\";
        $fileDir = ".\\team1\\project1\\files\\";

        $openFile = fopen($fileOpenDir.$file_to_open, "w");
        
        fwrite($openFile, $fileOpenContent);
        fclose($openFile);
 //   }*/

?>