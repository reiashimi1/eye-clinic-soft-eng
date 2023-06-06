<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'receptionist') {
    include('model/db_conn.php');
    include('model/appointment.class.php');

    $dbh = Database::get_connection();
    $requests = (new Appointment($dbh))->getAppointmentRequests();

    ?>
    <html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include('shared-components/includes.php') ?>
    <title>Receptionist Dashboard</title>
</head>
<body>
<?php
include('shared-components/receptionist/sidebar.php');
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
                <li class="breadcrumb-item"><a href="receptionist-dashboard.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Appointments</li>
            </ol>
        </nav>
        <br/>

        <div class="dash-cards">

            <div class="card-single">
                <div class="card-body">
                    <span class="ti-time"></span>
                    <div>
                        <h5>Manage Requests</h5>
                        <h4><?php echo count($requests[0]); ?> requests</h4>
                        <br/>
                        <br/>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="receptionist-manage-requests.php"> <i class="fa fa-arrow-alt-circle-right fa-2x"></i></a>
                </div>
            </div>

<!--            <div class="card-single">-->
<!--                <div class="card-body">-->
<!--                    <span class="ti-wheelchair"></span>-->
<!--                    <div>-->
<!--                        <h5>Upcomming Appointments</h5>-->
<!--                        <h4>View</h4>-->
<!--                        <br/>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="card-footer">-->
<!--                    <a href="receptionist-upcoming-appointments.php"> <i class="fa fa-arrow-alt-circle-right fa-2x"></i></a>-->
<!--                </div>-->
<!--            </div>-->

            <div class="card-single">
                <div class="card-body">
                    <span class="ti-receipt"></span>
                    <div>
                        <h5>All Appointments</h5>
                        <h4>Check appointment history</h4>
                        <br/>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="receptionist-all-appointments.php"> <i class="fa fa-plus-circle fa-2x"></i></a>
                </div>
            </div>

        </div>

        <br/>

    </main>
</div>
</body>

<?php } else {
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>