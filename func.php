<?php

function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo json_encode(array('message' => 'SQL error'));
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
        echo json_encode(array('status' => 'Username or email already exists'));
    }
    else {
        $result = false;
        return $result;
        echo json_encode(array('status' => 'success'));
    }

    mysqli_stmt_close($stmt);    
}

function createUser($conn, $firstname, $lastname, $username, $password, $email) {
    $sql = "INSERT INTO users (uidUsers, fnUsers, lnUsers, emailUsers, passUsers) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo json_encode(array('message' => 'SQL error'));
        exit();
    }

    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssss", $username, $firstname, $lastname, $email, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo json_encode(array('status' => 'success'));
    exit();
}


function loginUser($conn, $username, $password) {
    $uidExists = uidExists($conn, $username, $username);
    if ($uidExists == false) {
        echo json_encode(array('status' => 'Username or email does not exist'));
        exit();
    }

    $hashedPwdCheck = password_verify($password, $uidExists['passUsers']);
    if ($hashedPwdCheck == false) {
        echo json_encode(array('status' => 'Password is incorrect'));
        exit();
    } else if ($hashedPwdCheck == true) {
        echo json_encode(array('email' => $uidExists['emailUsers'], 'firstname' => $uidExists['fnUsers'], 'lastname' => $uidExists['lnUsers'],'pp' => $uidExists['uImage'],'points'=> $uidExists['uPoints'], 'solved'=>$uidExists['uSolved'] ,'status' => 'success', 'authenticated' => 'true'));
        exit();
    }
}
/*
function uploadImage($conn,$uid,$pp) {
    $response = array();
    $DIR = 'uploads/';
    $urlServer = 'http://127.0.0.1/api';


    if($pp)
    {
        $fileName = $pp["name"];
        $tempFileName = $pp["tmp_name"];
        $error = $pp["error"];

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
                    "message" => "Image has uploaded",
                    "url" => $urlServer."/".$UPLOAD_IMG_NAME
                );
                $ppurl = $urlServer."/".$UPLOAD_IMG_NAME;
                $sql = "UPDATE users SET uImage='$ppurl' WHERE uidUsers='$uid';";
                mysqli_query($conn, $sql);
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
}
*/