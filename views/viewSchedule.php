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
    <title>VIEW SCHEDULE</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
</head>
<body style="overflow-x:hidden; background-color:#193a45;">

<div class="bg-dark w-100 text-end">
  <nav class="navbar navbar-expand-lg bg-body-tertiary ">
    <div class="container-fluid">
      <a class="text-decoration-none text-light" href="adminindex.php"> <i class="fa-solid fa-arrow-left"></i> Back to Home Page </a>
      <a class="navbar-brand text-light" href="formdoc.php">SCHEDULE VIEW</a>
      <a class="" href="../actions/etpLogout.php">
        <button class="btn btn-outline-light">LOGOUT</button>
        </a>
    </div> 
  </nav>
</div>
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

    <div class="col-lg-8">
    <table class="table mt-2">
        <thead>
          <tr class="text-light">
            <th>ID</th>
            <th>SCHEDULE 1</th>
            <th><form action="../actions/addschedule.php" method="post">
            <input type="hidden" value="schedules1" name="schedule">
            <input type="submit" value="ADD SCHEDULE" class="btn btn-outline-success">
          </form></th>
            
          </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT *
            FROM schedules1";

            $result = $conn->query($sql);
            if(isset($result)){
                while($row = $result->fetch()){
                  echo "<tr class='text-light'>
                          <form method='post' action='formSchedule.php?sch=schedules1'> 
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['time'] . "</td>
                            <td>
                            <input type='hidden' name='table' value='schedules1'>
                            <input type='hidden' name='id' value=". $row['id'] .">
                            <button type='submit' class='btn btn-outline-primary'>UPDATE</button>
                            </td>
                          </form>
                        </tr>";
                }
            }
          ?>
        </tbody>
      </table>
      <br>
      <table class="table mt-2">
    <thead>
      <tr class="text-light">
        <th>ID</th>
        <th>SCHEDULE 2</th>
        <th><form action="../actions/addschedule.php" method="post">
            <input type="hidden" value="schedules2" name="schedule">
            <input type="submit" value="ADD SCHEDULE" class="btn btn-outline-success">
          </form></th>
        
      </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT *
        FROM schedules2";

        $result = $conn->query($sql);
        if(isset($result)){
            while($row = $result->fetch()){
              echo "<tr class='text-light'>
                      <form method='post' action='formSchedule.php?sch=schedules2'> 
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['time'] . "</td>
                        <td>
                        <input type='hidden' name='table' value='schedules1'>
                        <input type='hidden' name='id' value=". $row['id'] .">
                        <button type='submit' class='btn btn-outline-primary'>UPDATE</button>
                        </td>
                      </form>
                    </tr>";
            }
        }
      ?>
    </tbody>
  </table>
    </div>
<br>
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