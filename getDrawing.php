<?php

   // $file = $upload_dir."image_name.png";
   // $success = file_put_contents($file, $data);

   //Enter file data to store image in
    $fileDir = ".\\"; //Image directory
    $file_name = "image.png"; //Replace with temp file

    $file = fopen($fileDir.$file_name, "r");
    $fileContent = base64_encode(fread($file, filesize($fileDir.$file_name)));

    echo $fileContent;
?>