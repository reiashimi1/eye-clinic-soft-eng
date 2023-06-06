<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'patient') {
    require_once('model/db_conn.php');
    include 'model/user.class.php';
    include_once('model/patient.class.php');

    $dbh = Database::get_connection();
    $patient = (new Users($dbh))->getUserbyId($_SESSION['user_id']);
    ?>
    <html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include('shared-components/includes.php') ?>
    <title>Patient Profile</title>
</head>
<body>
<?php
include('shared-components/patient/sidebar.php');
?>
<div class="main-content">

    <header>
        <div class="navbar navbar-dark">
            <a href="main.php" class="logo me-auto"><img src="assets/images/logo.png" alt="Clinic Logo"
                                                         class="img-fluid"></a>
            <a><?php echo $_SESSION['user']['username'] ?></a>
        </div>
    </header>

    <main>
        <br/>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="doctor-dashboard.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
        <br/>
        <br/>
        <div class="container">
            <div class="row-cols-4">
                <div class="col s">
                    <div class="card" style="width: 15rem;">
                        <img class="card-img-top" src="assets/images/default-profile.jpg" alt="Card image cap">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><?php echo $patient['name'] . " " . $patient['surname']; ?></li>
                            <li class="list-group-item"><?php echo strtoupper($patient['role']); ?></li>
                            <li class="list-group-item"><?php echo $patient['isOnline']; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>

<?php } else {
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>