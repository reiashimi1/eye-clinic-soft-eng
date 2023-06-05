<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'receptionist') {
    require_once('model/db_conn.php');
    include 'model/appointment.class.php';
    include 'model/user.class.php';

    $dbh = Database::get_connection();
    $app_class = new Appointment($dbh);
    ?>

    <html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <?php include('shared-components/includes.php') ?>
    <title>Doctor Dashboard</title>
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
                <li class="breadcrumb-item"><a href="receptionist-appointments.php">Appointments</a></li>
                <li class="breadcrumb-item active" aria-current="page">All</li>
            </ol>
        </nav>
        <br/>
        <br/>
        <br/>

        <table id="appointments_table" class="table table-primary">
            <thead>
            <tr>
                <th>Client</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Visit time</th>
                <th>Doctor</th>
                <th>Status</th>
                <th>Service</th>
            </tr>
            </thead>
        </table>
    </main>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        $('#appointments_table').DataTable({
            responsive: true,
            "bDeferRender": true,
            "sPaginationType": "full_numbers",
            "ajax": {
                url: "controller/view-appointments.php",
                type: "POST"
            },
            "columns": [
                {"data": "full_name"},
                {"data": "email"},
                {"data": "phone"},
                {"data": "time"},
                {"data": "doctor"},
                {"data": "status"},
                {"data": "service"}
            ],
            "oLanguage": {
                "sProcessing": "Processing...",
            },
            "drawCallback": function (settings) {
                let api = this.api();
                let currentDate = new Date();
                let currentDateFormatted = currentDate.getFullYear() + '-' + ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' + ('0' + currentDate.getDate()).slice(-2);

                api.rows().every(function () {
                    let rowData = this.data();
                    let appointmentDate = rowData.time.split(' ')[0];
                    if (appointmentDate < currentDateFormatted) {
                        $(this.node()).addClass('past-appointment');
                    }
                });
            }
        })
    });
</script>

</body>

<?php } else {
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>