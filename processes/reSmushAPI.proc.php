<?php

function reSmush($file, $quality="80"){
    $mime = mime_content_type($file);
    $info = pathinfo($file);
    $name = $info['basename'];
    $output = new CURLFile($file, $mime, $name);
    $data = array(
        "files" => $output,
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://api.resmush.it/?qlty='.$quality);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
       $result = curl_error($ch);
    }
    curl_close ($ch);

    $result = json_decode($result);
    file_put_contents($file, file_get_contents($result->dest));
  }
