<?php
session_start();
if (isset($_SESSION['doctor_id']) && $_SESSION['role'] === 'doctor') {
    include('model/db_conn.php');
    include('model/employee.class.php');

    $dbh = Database::get_connection();
    $doctor = (new Employee($dbh))->getEmployee($_SESSION['doctor_id']);
    ?>
    <html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include('shared-components/includes.php') ?>
    <title>Doctor Profile</title>
</head>
<body>
<?php
include('shared-components/doctor/sidebar.php');
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
                            <li class="list-group-item"><?php echo $doctor['full_name']; ?></li>
                            <li class="list-group-item"><?php echo $doctor['email']; ?></li>
                            <li class="list-group-item"><?php echo $doctor['phone']; ?></li>
                        </ul>
                        <div class="card-body">
                            <button class="btn btn-primary btn-sm">Schedule</button>
                        </div>
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