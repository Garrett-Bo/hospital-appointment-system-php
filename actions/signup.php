<?php
session_start(); // Start the session

$name = $_POST['name'];
$email = $_POST['email'];
$passwordu = $_POST['password'];

include '../dbconn.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit(); // Exit script if database connection fails
}

$passwordu = password_hash($passwordu,PASSWORD_DEFAULT);

// Prepare the SQL statement with placeholders
$sql = "INSERT INTO `users`(`name`, `email`, `password`) VALUES (:name, :email, :password)";
$query = $conn->prepare($sql);

// Bind parameters to the prepared statement
$query->bindParam(':name', $name);
$query->bindParam(':email', $email);
$query->bindParam(':password', $passwordu);

// Execute the prepared statement
$query->execute();

$_SESSION['user_name'] = $name;

header("Location: ../offcanvas.php");
exit(); // Always exit after header redirection
