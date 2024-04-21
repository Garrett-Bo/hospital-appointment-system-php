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


    //alert box for adding department
    if(isset($_SESSION['status']))
    {
        echo$_SESSION['status'];
        unset($_SESSION['status']);
    }
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
      <a class="navbar-brand text-light" href="formDoc.php">DEPARTMENT VIEW</a>
      <a class="" href="../actions/etpLogout.php">
        <button class="btn btn-outline-light">LOGOUT</button>
        </a>
    </div> 
  </nav>
</div>

<div class="row mt-4">

    <!-- stuff data show div -->
    <div class="col-lg-3">
      <?php include"adminNav.php";?>
    </div>

    <div class="col-lg-8">
    <table class="table mt-2">
        <thead>
          <tr class="text-light">
            <td>ID</td>
            <td>MYANMAR NAME</td>
            <td>NAME</td>
            
          </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT *
            FROM specialists";

            $result = $conn->query($sql);
            if(isset($result)){
                while($row = $result->fetch()){
                  echo "<tr class='text-light'>
                          <form method='post' action='../actions/cancel.php'> 
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['mya_name'] . "</td>
                            <td>" . $row['name'] . "</td>
                          </form>
                        </tr>";
                }
            }
          ?>
        </tbody>
      </table>
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