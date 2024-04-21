<?php
include '../dbconn.php';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit(); // Exit script if database connection fails
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file upload is successful
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo "Failed to upload image.";
        exit(); // Exit script if image upload fails
    }

    $img_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Move uploaded file to destination folder
    $img_upload_path = '../Photos/' . $img_name;
    if (!move_uploaded_file($tmp_name, $img_upload_path)) {
        echo "Failed to move uploaded file.";
        exit(); // Exit script if file move fails
    }

    // Prepare and execute SQL statement
    $sql = "INSERT INTO blogs (title, content, image) VALUES (:title, :content, :image)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':image', $img_name);
    if (!$stmt->execute()) {
        echo "Failed to insert record into database.";
        exit(); // Exit script if database insert fails
    }

    $_SESSION['status']='<div class="alert alert-warning" role="alert">
										New Departmment is successfully Created.
										</div>';
				header('location: ../views/formBlog.php');
}
