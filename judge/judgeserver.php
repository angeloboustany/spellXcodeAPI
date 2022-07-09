<?php 
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

include_once 'dbh.inc.php';

$response = array();
$DIR = 'temp/';
$urlServer = 'http://127.0.0.1:8888';

if($_FILES['file'])
{
    $fileName = $_FILES["file"]["name"];
    $tempFileName = $_FILES["file"]["tmp_name"];
    $error = $_FILES["file"]["error"];

    if($error > 0){
        $response = array(
            "status" => "error",
            "error" => true,
            "message" => "Error uploading the file!"
        );
    }else 
    {
        $FILE_NAME = rand(10, 1000000)."-".$fileName;
        $UPLOAD_IMG_NAME = $DIR.strtolower($FILE_NAME);
        $UPLOAD_IMG_NAME = preg_replace('/\s+/', '-', $UPLOAD_IMG_NAME);
    
        if(move_uploaded_file($tempFileName , $UPLOAD_IMG_NAME)) {
            $response = array(
                "status" => "success",
                "error" => false,
                "message" => "file has uploaded",
                "url" => $urlServer."/".$UPLOAD_IMG_NAME
              );

        }else
        {
            $response = array(
                "status" => "error",
                "error" => true,
                "message" => "Error occured"
            );
        }
    }

}else{
    $response = array(
        "status" => "error",
        "error" => true,
        "message" => "File not found"
    );
}

echo json_encode($response);
