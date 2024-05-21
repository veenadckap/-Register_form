<?php
session_start();


$db = require("../model/DB.php");
$config = require('../config.php');
$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->getConnection();

if(isset($_POST['email'], $_POST['password'])) {
    $email = $conn->real_escape_string($_POST['email']); 
    $password = $conn->real_escape_string($_POST['password']); 


    $sql = "SELECT id, password FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if($result === false) {
        
        $error = 'Error executing SQL query: ' . $conn->error;
    } elseif($result->num_rows > 0) {
       
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        if(password_verify($password, $storedPassword)) {
          
            $_SESSION['name'] = $email;
            header("Location:../view/success.php");
            exit; 
        } else {
            $error = 'Invalid password';
        }
    } else {
        $error = 'No user found with the provided email';
    }
} else {
    $error = 'Invalid input data'; 

}
$conn->close();

if(isset($error)) {
    echo 'Error: ' . $error;
}
?>
