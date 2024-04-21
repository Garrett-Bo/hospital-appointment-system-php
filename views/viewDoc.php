<?php
session_start();
if(isset($_SESSION['admin_name'])){

?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php
include '../dbconn.php';


            try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              // set the PDO error mode to exception
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
            };
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIEW DOCTOR</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
</head>
<body style="overflow-x:hidden; background-color:#193a45;">

<div class="bg-dark w-100 text-end">
  <nav class="navbar navbar-expand-lg bg-body-tertiary ">
    <div class="container-fluid">
      <a class="text-decoration-none text-light" href="adminIndex.php"> <i class="fa-solid fa-arrow-left"></i> Back to Home Page </a>
      <a class="navbar-brand text-light" href="formDoc.php">DOCTOR VIEW </a>
      <a class="" href="../actions/etpLogout.php">
        <button class="btn btn-outline-light">LOGOUT</button>
        </a>
    </div> 
  </nav>
</div>

<!-- add doc alert  -->
<?php

if(isset($_SESSION['status']))
{
    echo$_SESSION['status'];
    unset($_SESSION['status']);
};

?>

<div class="row mt-4">

    <!-- stuff data show div -->
    <div class="col-lg-3">
      <?php include"adminNav.php";?>
    </div>

<div class="col-lg-9">
    <table class="table mt-1 text-light">
        <thead>
          <tr class="">
            <td>ID</td>
            <td>IMAGE FILE</td>
            <td>NAME</td>
            <td>AGE</td>
            <td>QUALIFICATION</td>
            <td>SPECIALIST</td>
            <td>SCHEDLE TIME 1</td>
            <td>SCHEDLE TIME 2</td>
          </tr>
        </thead>
        <tbody class='text-light'>
        <?php
          // sql query 
            $sql = "SELECT doctors.id AS docid, doctors.image , doctors.name , doctors.age , doctors.qualification , doctors.specialist_id , specialists.id , specialists.name as specialist , schedules1.time as sche1 , schedules2.time as sche2
            FROM doctors,specialists,schedules1,schedules2 WHERE doctors.specialist_id = specialists.id AND schedules1.id = doctors.schedule1_id AND schedules2.id = doctors.schedule2_id ";

            $result = $conn->query($sql);
            if(isset($result)){
                while($row = $result->fetch()){
                  echo "<tr class='text-light'>
                          <form method='post' action='../actions/cancel.php'> 
                            <td>" . $row['docid'] . "</td>
                            <td>" . $row['image'] . "</td>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['age'] . "</td>
                            <td>" . $row['qualification'] . "</td>
                            <td>" . $row['specialist'] . "</td>
                            <td>" . $row['sche1']."</td>
                            <td>" . $row['sche2'] ."</td>
                          </form>
                        </tr>";
                }
            }
          ?>
        </tbody>
      </table>
    </div>
</div>
</body>
</html>
<?php 
exit();
}
else{
  header("Location:../views/etpForm.php");
  exit();
}
 ?>