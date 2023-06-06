<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'patient') {
    require_once ('model/db_conn.php');
    include 'model/appointment.class.php';
    include 'model/user.class.php';
    include 'model/health_record.class.php';

    $dbh = Database::get_connection();
    $employee = (new Users($dbh))->getAllEmployeeData($_SESSION['user_id']);
    ?>

    <html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <?php include('shared-components/includes.php') ?>
    <title>Patient Dashboard</title>
</head>
<body>
<?php
include('shared-components/patient/sidebar.php');
?>
<div class="main-content">

    <header>
        <div class="navbar navbar-dark">
            <a href="main.php" class="logo me-auto"><img src="assets/images/logo.png" alt="Clinic Logo" class="img-fluid"></a>
            <a><?php echo $_SESSION['user']['username'] ?></a>
        </div>
    </header>

    <main>
        <br/>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="patient-dashboard.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Health Records</li>
            </ol>
        </nav>
        <br/>
        <br/>
        <br/>

        <table id="health_records_table" class="table table-primary" >
            <thead>
            <tr>
                <th>Prescription</th>
                <th>Description</th>
                <th>Date</th>
                <th>Doctor</th>
<!--                Change these IDs here-->
                <th>Patient</th>
                <th>Diagnosis</th>
            </tr>
            </thead>
        </table>
    </main>
</div>

<script type="text/javascript">

    $(document).ready(function() {

        $('#appointments_table').DataTable({
            responsive: true,
            "bDeferRender":true,
            "sPaginationType": "full_numbers",
            "ajax":{
                url:"controller/view-health-records.php",
                type:"POST"
            },
            "columns": [
                {"data": "prescription"},
                {"data": "description"},
                {"data": "date"},
                {"data": "written_by"},
                {"data": "patient_id"},
                {"data": "patient_diagnosis_id"}
            ],
            "oLanguage": {
                "sProcessing": "Processing...",
            }
        })
    } );
</script>

</body>

<?php } else{
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>