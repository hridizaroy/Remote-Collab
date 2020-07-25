<?php

    $user = "User: ".$_POST['user']."\n";

    $msg = "Msg: ".$_POST['chatContent']."\n";
    $timeOfMsg = "Time: ".$_POST['time']."\n";

    $dateOfMsg = "Date: ".$_POST['fullDate']."\n";

    $fileName = $_POST['fileName'].".txt";

    $fileDir = ".\\team1\\project1\\chat\\";

    $file = fopen($fileDir.$fileName, "a");

    fwrite($file, $msg.$user.$timeOfMsg.$dateOfMsg);

     fclose($file);

?>