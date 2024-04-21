<?php
session_start();

include '../dbconn.php';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $schedule = isset($_POST['schedule']) ? $_POST['schedule'] : ''; // validate or sanitize input as needed

    if (!empty($schedule)) {
        $sql = "INSERT INTO `$schedule`(`time`) VALUES (:time)";
        $query = $conn->prepare($sql);

        // Assuming 'Time' is a placeholder and you want to insert actual time value
        $time = date("Y-m-d"); // or fetch time from the form

        $query->bindParam(':time', $time);
        $query->execute();
    }

    header('location: ../views/viewSchedule.php');
    exit(); // Add an exit call after header redirection to stop script execution
} catch(PDOException $e) {
    // Handle any database errors appropriately
    echo "Database error: " . $e->getMessage();
}
