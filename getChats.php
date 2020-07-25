<?php


    $fileName = $_POST['fileName'].".txt";
    $dateOfMsg = "Date: ".$_POST['fullDate'];

    $fileDir = ".\\team1\\project1\\chat\\";

    $file = fopen($fileDir.$fileName, "r");

    $allChats = strval( fread($file, filesize($fileDir.$fileName)) );

    fclose($file);

    echo $allChats;

?>