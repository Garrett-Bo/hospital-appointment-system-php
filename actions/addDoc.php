<?php

session_start();

include '../dbconn.php';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $specialiststring = $_POST['specialists'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $qualifications = $_POST['qualification'];
    $schedule1 = $_POST['sch1'];
    $schedule2 = $_POST['sch2'];

    $img_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    // converting specialist string into id
    $specialistsql = "SELECT id FROM specialists WHERE name = ?";
    $stmt = $conn->prepare($specialistsql);
    $stmt->execute([$specialiststring]); 

    if ($row1 = $stmt->fetch()) {
        $specialistid = $row1['id'];
    } else {
       echo "Can't find specialist ID for given name.";
       exit(); // Exit script if specialist ID not found
    }

        // converting schedule1 string into id
        $sch1sql = "SELECT id FROM schedules1 WHERE time = ?";
        $stmt = $conn->prepare($sch1sql);
        $stmt->execute([$schedule1]); 
    
        if ($row1 = $stmt->fetch()) {
            $sche1 = $row1['id'];
        } else {
           echo "Can't find specialist ID for given name.";
           exit(); // Exit script if specialist ID not found
        }

    // converting schedule2 string into id
    $sch2sql = "SELECT id FROM schedules2 WHERE time = ?";
    $stmt = $conn->prepare($sch2sql);
    $stmt->execute([$schedule2]); 

    if ($row1 = $stmt->fetch()) {
        $sche2 = $row1['id'];
    } else {
       echo "Can't find specialist ID for given name.";
       exit(); // Exit script if specialist ID not found
    }

    // image upload
    $img_upload_path = '../Photos/'.$img_name;

    if (!move_uploaded_file($tmp_name, $img_upload_path)) {
        echo "Failed to upload image.";
        exit(); // Exit script if image upload fails
    }

    $sql = "INSERT INTO doctors (image,name,age,qualification,specialist_id,schedule1_id,schedule2_id)
            VALUES(:image, :name, :age, :qualification, :specialistid, :sche1 , :sche2)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':image', $img_name);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':qualification', $qualifications);
    $stmt->bindParam(':specialistid', $specialistid);
    $stmt->bindParam(':sche1', $sche1);
    $stmt->bindParam(':sche2', $sche2);
    $stmt->execute();

    $_SESSION['status'] = '<div class="alert alert-warning" role="alert">
                                New Doctor has been successfully added.
                            </div>';
    
    header("Location:../views/viewDoc.php");
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
