<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

if (isset($obj)) {
    
    $firstname = $obj['first_name'];
    $lastname = $obj['last_name'];
    $username = $obj['username'];
    $password = $obj['password'];
    $cpassword = $obj['cpassword'];
    $email = $obj['email'];

    require_once 'dbh.inc.php';
    require_once 'func.php';

    if ($password != $cpassword) {
        echo json_encode(array('status' => 'Passwords do not match'));
        exit();
    }
    if (uidExists($conn, $username, $email)) {
        echo json_encode(array('status' => 'Username or email already exists'));
        exit();
    }
    createUser($conn, $firstname, $lastname, $username, $password, $email);
/*
    else {
        
        $sql1 = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql1);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
            echo json_encode(array('message' => 'Username already exists'));
            exit();
        }
        else {
        $passMD5 = md5($password);
        $sql = "INSERT INTO users (uidUsers, fnUsers, lnUsers, emailUsers, passUsers) VALUES ('$username', '$firstname', '$lastname', '$email', '$passMD5')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(array('status' => 'success'));
            exit();
        } else {
            echo json_encode(array('status' => 'error'));
            exit();
        }
    }
}
*/

}else {
    echo json_encode(array('message' => 'No data received'));
    exit();
}