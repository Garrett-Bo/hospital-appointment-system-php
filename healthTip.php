<?php
include 'dbconn.php';


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM blogs");
    $stmt->execute();
    $blogs = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Articles</title>
    <link rel="stylesheet" href="css/healthtip.css">
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .card {
            transition: all 0.8s;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .card:hover {
            transform: scale(1.10);
        }
    </style>
</head>
<body style="overflow-x:hidden;">
<?php include"nav.php"; ?>
<main role="main" class="col-md-10 px-4 mx-auto">
    <div class="pt-3 pb-2 mb-3 text-center">
        <h1 class="h2 text-success">Health Tips</h1>
        <hr class='border border-success border-3 opacity-75 '>
    </div>
    <div class="row">
        <?php foreach ($blogs as $blog) : ?>
            <div class="col-12 col-md-6 col-lg-4 col-sm-12 mb-5">
                <div class="card w-75 h-100 mx-sm-2" data-aos="flip-left">
                    <img src="Photos/<?= $blog['image'] ?>" class="card-img-top" style="height:200px;" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= $blog['title'] ?></h5>
                        <p class="card-text mt-4">
                            <?php
                            $string =  $blog['content'];
                            $trimstring = substr($string, 0, 180);
                            echo $trimstring; // Corrected function name
                            ?>
                            <br>
                            <br>
                            <br>
                            <a href="blog.php?id=<?= $blog['id'] ?>" class="btn btn-success float-start">See More</a>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</main>
<?php include"footer.php"?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>
</body>
</html>
