<?php

    $pic = $_POST['pic'];
    $img = str_replace('data:image/png;base64,', '', $pic);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
   
   // $file = $upload_dir."image_name.png";
   // $success = file_put_contents($file, $data);

   //Enter file data to store image in
    $fileDir = ".\\";
    $file_to_open = "image.png";

    $file = $fileDir.$file_to_open;
    $success = file_put_contents($file, $data);

?>