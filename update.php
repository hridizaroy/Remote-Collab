<?php

    $file_to_open = $_POST['openFileName'];

    $fileOpenContent = $_POST['openedFile'];
    $fileOpenDir = ".\\team1\\project1\\files\\";
    $fileDir = ".\\team1\\project1\\files\\";

    $openFile = fopen($fileOpenDir.$file_to_open, "w");

    fwrite($openFile, $fileOpenContent);
    fclose($openFile);

?>