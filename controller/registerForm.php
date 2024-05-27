<?php

session_start();
$db = require("../model/DB.php");
$config = require('../config.php');
$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->getConnection();
define('ENCRYPTION_KEY', 'e5f6d7e8c9b10f11e5f6d7e8c9b10f11');

if(isset($_POST['name'], $_POST['email'], $_POST['password'] ,$_POST['course'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $course = $_POST['course'];
  
    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result && $result->num_rows > 0) {
       
        header("Location:../view/login.php");
        exit;
    }

   
     $encryptedPassword = openssl_encrypt($password, 'AES-128-ECB', ENCRYPTION_KEY);

    $sql = "INSERT INTO users (name, email, password,course ) VALUES ('$name', '$email', '$encryptedPassword' ,'$course')";

    if ($conn->query($sql) === TRUE) {
        header("Location:../view/login.php");
        exit; 
    } else {
        echo "Error: Registration failed";
    }
} else {
    echo "Invalid input data";
}

$conn->close();

?>
