<?php

header('Access-Control-Allow-Origin: *');
$imageName = $_POST['imageName'];
$imageData = $_POST['imageData'];
$imageData = base64_decode($imageData);
$uploadPath = '/upload/certificate/' . $imageName;
file_put_contents($uploadPath, $imageData);
$response = ['success' => true];
echo json_encode($response);
