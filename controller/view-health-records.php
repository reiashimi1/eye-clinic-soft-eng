<?php
include_once('../model/appointment.class.php');
include_once('../model/db_conn.php');
include_once('../model/employee.class.php');
include_once('../model/health_record.class.php');

session_start();

if(isset($_SESSION['user_id'])) {
    $dbh = Database::get_connection();
    $query = '';
    $output = array();
    $query .= 'SELECT * FROM `health_records`';

    $app = new Health_Record($dbh);
    $result = $app->getAllPatientHealthRecord($_SESSION['user_id']);

    $data = $result[0];
    $table = "";

    foreach($data as $row) {
        $table.='{
                      "prescription":"'.$row['prescription'].'",
                      "description":"'.$row['description'].'",
                      "date":"'.$row['date'].'",
                      "written_by":"'.$row['written_by'].'",
                      "patient_id":"'.$row['patient_id'].'",
                      "patient_diagnosis_id":"'.$row['patient_diagnosis_id'].'"
                    },';
    }
    $table = substr($table,0, strlen($table) - 1);
    echo '{"data":['.$table.']}';
} else {
    header("Location: ../login.php?error=Access Forbidden");
}
