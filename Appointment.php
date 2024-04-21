    <?php
    session_start();
    include 'dbconn.php';

   
     try {
     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
     // set the PDO error mode to exception
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch(PDOException $e) {
     echo "Connection failed: " . $e->getMessage();
     }

   if (isset($_SESSION['user_name'])) {
     $doctor_id = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : null;
    $specialist_id = isset($_GET['specialist_id']) ? $_GET['specialist_id'] : null;

// Fetch doctor's name
$sqlDoctorName = "SELECT doctors.name, doctors.qualification, doctors.specialist_id, 
                        specialists.id AS specialist_id, specialists.name AS specialist, 
                        schedules1.time AS schedule1_time, schedules1.time AS sche1, 
                        schedules2.time AS schedule2_id, schedules2.time AS sche2
                FROM doctors
                INNER JOIN specialists ON doctors.specialist_id = specialists.id
                INNER JOIN schedules1 ON schedules1.id = doctors.schedule1_id
                INNER JOIN schedules2 ON schedules2.id = doctors.schedule2_id
                WHERE doctors.id = ?";

$stmtDoctorName = $conn->prepare($sqlDoctorName);
$stmtDoctorName->execute([$doctor_id]);
$doctor_row = $stmtDoctorName->fetch(PDO::FETCH_ASSOC);
if ($doctor_row) {
    $doctor_name = $doctor_row['name'];
    $doctor_sch1 = $doctor_row['schedule1_time'];
    $doctor_sch2 = $doctor_row['schedule2_id'];
    // Other variables
} else {
    // Handle case where no doctor is found with given ID
}


// Fetch specialist's name
$sqlSpecialistName = "SELECT * FROM specialists WHERE id = ?";
$stmtSpecialistName = $conn->prepare($sqlSpecialistName);
$stmtSpecialistName->execute([$specialist_id]);
$specialist_row = $stmtSpecialistName->fetch(PDO::FETCH_ASSOC);
$specialist_name = $specialist_row['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    
    #card{
      transition : all 0.3s;
    }
    #card:hover{
      transform : scale(1.10);
    }
  </style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<body>
    
  <div class="container-fluid">
    <img src="Photos/d_and_p.jpg" alt="" class="mt-3 rounded w-100" style="height: 300px;">
    
  </div>  
  <div class="container-fluid mt-3">
    <div class="card shadow-lg mb-3">
        <div class="card-body">
            <div class="card-title text-center fs-3"><b>Book Appoiment</b></div>
            <div class="row">

            <!-- appointment form -->
                <div class="col-12 col-md-6 col-lg-6">
                    <form action="actions/addappointment.php" class="mt-4" method="post">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Name" name="patientname">
                            <label for="Name">Patient Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" placeholder="Phone Number" name="phno">
                            <label for="Phone Number">Phone Number</label>
                        </div>
                        <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Doctor Name" value="<?= $doctor_name ?>" name="docname" readonly>
                            <label for="Doctor Name">Doctor Name</label>
                        </div>
                        <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Specialist Name" value="<?= $specialist_name ?>" name="specialist" readonly>

                            <label for="Specialist Name">Specialist Name</label>
                        </div>
                </div>
            <!-- hidden ids by method post start-->
            <input type="hidden" class="form-control" value="<?= $doctor_id; ?>" name="id">
            <input type="hidden" class="form-control" value="<?= $specialist_id;?>" name="specialistid">
            <!-- hidden input end -->
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="row  mt-4">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card text-center mb-3" id="card">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="  mt-3 form-check-input" type="radio" name="schedule" valueid="flexRadioDefault1" value="<?= $doctor_sch1;?>">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                        <?= $doctor_sch1 ;?>
                                      </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card mb-3 mb-3 text-center" id="card">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="  mt-3 form-check-input" type="radio" name="schedule" id="flexRadioDefault1" value="<?= $doctor_sch2 ;?>">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                        <?= $doctor_sch2 ;?>
                                        </label>
                                      </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <input type="submit" class="btn mt-2 btn btn-primary btn-lg" value="Make appointment">
        </div>
    </div>
</form>
  </div>
  </body>
</html>
  <?php }
  else{
    header("Location: offcanvas.php");
  };
