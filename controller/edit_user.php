<?php
$db = require("../model/DB.php");
$config = require('../config.php');
$databaseConnection = new DatabaseConnection($config);
$conn = $databaseConnection->getConnection();

define('ENCRYPTION_KEY', 'e5f6d7e8c9b10f11e5f6d7e8c9b10f11'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = openssl_encrypt($_POST["password"], 'AES-128-ECB', ENCRYPTION_KEY);
    $course = $_POST["course"];

    $sql = "UPDATE users SET name=?, email=?, password=?, course=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $password, $course, $id);

    if ($stmt->execute()) {
        // echo "Record updated successfully";
           header("Location:../view/admin.php");

    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    $id = $_GET["id"];
    $sql = "SELECT * FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $decryptedPassword = openssl_decrypt($user["password"], 'AES-128-ECB', ENCRYPTION_KEY);
    ?>
   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <h1 class="text-center text-2xl font-bold my-4">Edit User</h1>
    <form method="post" action="edit_user.php" class="max-w-lg mx-auto p-4 bg-white shadow-md rounded-lg">
        <input type="hidden" name="id" value="<?php echo $user["id"]; ?>">
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
            <input type="text" name="name" value="<?php echo $user["name"]; ?>" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
            <input type="email" name="email" value="<?php echo $user["email"]; ?>" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Password:</label>
            <input type="password" name="password" value="<?php echo $decryptedPassword; ?>" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label for="course" class="block text-gray-700 font-bold mb-2">Course:</label>
            <input type="text" name="course" value="<?php echo $user["course"]; ?>" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="text-center">
            <input type="submit" value="Update" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
        </div>
    </form>
</body>
</html>

    <?php
    $stmt->close();
    $conn->close();
}
?>
