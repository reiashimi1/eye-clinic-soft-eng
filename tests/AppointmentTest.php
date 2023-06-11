<?php
require_once('model/db_conn.php');
require_once('model/appointment.class.php');

use PHPUnit\Framework\TestCase;

class AppointmentTest extends TestCase
{
    private $appointment;

    protected function setUp()
    {
        $dbh = new PDO('mysql:host=localhost;dbname=eye_clinic', 'root', '');
        $this->appointment = new Appointment($dbh);
    }

    protected function tearDown()
    {
        $this->appointment = null;
    }

    public function testAddNewAppointment()
    {
        $full_name = 'John Doe';
        $email = 'johndoe@example.com';
        $phone = '1234567890';
        $status = 'approved';
        $time = '2023-06-06 09:00:00';
        $doctor_id = 1;
        $patient_id = 1;
        $transaction_id = 123456789;
        $service_id = 1;
        $description = 'Appointment description';
        $result = $this->appointment->addNewAppointment($full_name, $email, $phone, $status, $time, $doctor_id, $patient_id, $transaction_id, $service_id, $description);
        $this->assertTrue($result);
    }

    public function testGetNextAppointment()
    {
        $doctor_id = 1;
        $result = $this->appointment->getNextAppointment($doctor_id);
        $this->assertIsArray($result);
    }

    public function testGetAvailableTimeSlots()
    {
        $date = '2023-06-06';
        $doctor_id = 1;
        $result = $this->appointment->getAvailableTimeSlots($date, $doctor_id);
        $this->assertIsArray($result);
    }

    public function testGetTodaysSchedule()
    {
        $doctor_id = 1;
        $result = $this->appointment->getTodaysSchedule($doctor_id);
        $this->assertIsArray($result);
    }

    public function testGetDoctorsAppointments()
    {
        $query = 'SELECT * FROM `appointment` WHERE `doctor_id` = ?';
        $doctor_id = 1;
        $result = $this->appointment->getDoctorsAppointments($query, $doctor_id);
        $this->assertIsArray($result);
    }

    public function testGetAllAppointments()
    {
        $query = 'SELECT * FROM `appointment`';
        $result = $this->appointment->getAllAppointments($query);
        $this->assertIsArray($result);
    }

    public function testAddTransaction()
    {
        $transaction = '123456789';
        $a_id = 1;
        $this->appointment->addTransaction($transaction, $a_id);
        $this->expectNotToPerformAssertions();
    }

    public function testAddService()
    {
        $service = 1;
        $a_id = 1;
        $this->appointment->addService($service, $a_id);
        $this->expectNotToPerformAssertions();
    }

    public function testGetAppointmentDetails()
    {
        $a_id = 1;
        $result = $this->appointment->getAppointmentDetails($a_id);
        $this->assertIsArray($result);
    }

    public function testGetAppointmentRequests()
    {
        $result = $this->appointment->getAppointmentRequests();
        $this->assertIsArray($result);
    }

    public function testGetAppointmentForPatient()
    {
        $patient_id = 1;
        $result = $this->appointment->getAppointmentForPatient($patient_id);
        $this->assertIsArray($result);
    }

    public function testManageRequest()
    {
        $a_id = 1;
        $action = 'approved';
        $doctor_id = 1;
        $result = $this->appointment->manageRequest($a_id, $action, $doctor_id);
        $this->assertTrue($result);
    }

    public function testCompleteAppointment()
    {
        $a_id = 1;
        $this->appointment->completeAppointment($a_id);
        $this->expectNotToPerformAssertions();
    }

    public function testGetNrAppointment()
    {
        $assigned_to = 1;
        $time = '2023-06-06 09:00:00';
        $result = $this->appointment->getNrAppointment($assigned_to, $time);
        $this->assertIsArray($result);
    }

    public function testReschedule()
    {
        $a_id = 1;
        $doctor_id = 1;
        $time = '2023-06-07 09:00:00';
        $result = $this->appointment->reschedule($a_id, $doctor_id, $time);
        $this->assertTrue($result);
    }

    public function testCancelAppointment()
    {
        $a_id = 1;
        $result = $this->appointment->cancelAppointment($a_id);
        $this->assertTrue($result);
    }
}
