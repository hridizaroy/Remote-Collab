<?php
        $file_name = $_POST['openFileName'];

        $fileDir = ".\\team1\\project1\\files\\";

        $file = fopen($fileDir.$file_name, "r");
        $fileContent = strval(fread($file, filesize($fileDir.$file_name)));
        fclose($file);

        echo $fileContent;

?>
