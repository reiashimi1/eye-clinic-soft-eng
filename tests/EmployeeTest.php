<?php
require_once('model/db_conn.php');
require_once('model/employee.class.php');

use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{
    private $employee;
    private $mockDbh;

    protected function setUp() {
        $this->mockDbh = $this->createMock(PDO::class);
        $this->employee = new Employee($this->mockDbh);
    }

    public function testGetAllEmployees() {
        $query = "SELECT * FROM `staff`";
        $expectedData = [
            [
                'employee_id' => 1,
                'full_name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '123456789',
                'photo' => 'photo1.jpg',
                'birthday' => '1990-01-01',
                'salary' => 5000.0,
                'status' => 'Active',
                'uuid' => 'abc123'
            ],
            [
                'employee_id' => 2,
                'full_name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '987654321',
                'photo' => 'photo2.jpg',
                'birthday' => '1995-05-05',
                'salary' => 6000.0,
                'status' => 'Active',
                'uuid' => 'xyz789'
            ]
        ];
        $expectedRowCount = count($expectedData);

        $mockStmt = $this->createMock(PDOStatement::class);
        $mockStmt->expects($this->once())
            ->method('execute')
            ->willReturn(true);
        $mockStmt->expects($this->once())
            ->method('fetchAll')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn($expectedData);
        $mockStmt->expects($this->once())
            ->method('rowCount')
            ->willReturn($expectedRowCount);

        $this->mockDbh->expects($this->once())
            ->method('prepare')
            ->with($query)
            ->willReturn($mockStmt);

        $result = $this->employee->getAllEmployees($query);
        $this->assertEquals([$expectedData, $expectedRowCount], $result);
    }

    public function testGetTotalAllRecords() {
        $query = "SELECT * FROM `staff`";
        $expectedRowCount = 5;

        $mockStmt = $this->createMock(PDOStatement::class);
        $mockStmt->expects($this->once())
            ->method('execute')
            ->willReturn(true);
        $mockStmt->expects($this->once())
            ->method('fetchAll')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn([]);
        $mockStmt->expects($this->once())
            ->method('rowCount')
            ->willReturn($expectedRowCount);

        $this->mockDbh->expects($this->once())
            ->method('prepare')
            ->with($query)
            ->willReturn($mockStmt);

        $result = $this->employee->get_total_all_records();
        $this->assertEquals($expectedRowCount, $result);
    }

    public function testRegisterEmployee() {
        $full_name = 'John Doe';
        $email = 'john@example.com';
        $position = 'Manager';
        $phone = '1234567890';
        $birthday = '1990-01-01';
        $salary = 5000;
        $address = '123 Main St';
        $status = 'Active';
        $user_id = 1;

        $expectedQuery = "INSERT INTO `staff` (`full_name`, `email`, `position`, `phone`, `birthday`, `salary`, `address`, `status`, `user_id`)";
        $expectedQuery .= " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

        $mockStmt = $this->createMock(PDOStatement::class);
        $mockStmt->expects($this->once())
            ->method('execute')
            ->with([$full_name, $email, $position, $phone, $birthday, $salary, $address, $status, $user_id])
            ->willReturn(true);

        $this->mockDbh->expects($this->once())
            ->method('prepare')
            ->with($expectedQuery)
            ->willReturn($mockStmt);

        $result = $this->employee->registerEmployee($full_name, $email, $position, $phone, $birthday, $salary, $address, $status, $user_id);
        $this->assertTrue($result);
    }

    public function testGetEmployee() {
        $employee_id = 1;
        $expectedQuery = "SELECT * FROM `staff` WHERE `employee_id` = ?";

        $expectedResult = [
            'employee_id' => $employee_id,
            'full_name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'photo' => 'photo1.jpg',
            'birthday' => '1990-01-01',
            'salary' => 5000.0,
            'status' => 'Active',
            'uuid' => 'abc123'
        ];

        $mockStmt = $this->createMock(PDOStatement::class);
        $mockStmt->expects($this->once())
            ->method('execute')
            ->with([$employee_id])
            ->willReturn(true);
        $mockStmt->expects($this->once())
            ->method('fetch')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn($expectedResult);

        $this->mockDbh->expects($this->once())
            ->method('prepare')
            ->with($expectedQuery)
            ->willReturn($mockStmt);

        $result = $this->employee->getEmployee($employee_id);
        $this->assertEquals($expectedResult, $result);
    }

    public function testUpdateEmployee() {
        $employee_id = 1;
        $full_name = 'John Doe';
        $email = 'john@example.com';
        $position = 'Manager';
        $address = '123 Main St';
        $phone = '1234567890';
        $status = 'Active';
        $salary = 5000;

        $expectedQuery = "UPDATE `staff` 
            SET `full_name` = ?, 
           `email`= ?, 
           `position` = ?,
           `address` = ?, 
           `phone` = ?, 
           `status` = ?, 
           `salary` = ?
            WHERE `employee_id` = ?;";

        $mockStmt = $this->createMock(PDOStatement::class);
        $mockStmt->expects($this->once())
            ->method('execute')
            ->with([$full_name, $email, $position, $address, $phone, $status, $salary, $employee_id])
            ->willReturn(true);

        $this->mockDbh->expects($this->once())
            ->method('prepare')
            ->with($expectedQuery)
            ->willReturn($mockStmt);

        $this->employee->updateEmployee($employee_id, $full_name, $email, $position, $address, $phone, $status, $salary);
    }

    public function testGetDoctors() {
        $position = 'doctor';
        $expectedQuery = "SELECT * FROM `staff` WHERE `position` = ?";

        $expectedResult = [
            [
                'employee_id' => 1,
                'full_name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '123456789',
                'photo' => 'photo1.jpg',
                'birthday' => '1990-01-01',
                'salary' => 5000.0,
                'status' => 'Active',
                'uuid' => 'abc123'
            ],
            [
                'employee_id' => 2,
                'full_name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '987654321',
                'photo' => 'photo2.jpg',
                'birthday' => '1995-02-15',
                'salary' => 6000.0,
                'status' => 'Active',
                'uuid' => 'def456'
            ]
        ];

        $mockStmt = $this->createMock(PDOStatement::class);
        $mockStmt->expects($this->once())
            ->method('execute')
            ->with([$position])
            ->willReturn(true);
        $mockStmt->expects($this->once())
            ->method('fetchAll')
            ->with(PDO::FETCH_ASSOC)
            ->willReturn($expectedResult);

        $this->mockDbh->expects($this->once())
            ->method('prepare')
            ->with($expectedQuery)
            ->willReturn($mockStmt);

        $result = $this->employee->getDoctors();
        $this->assertEquals($expectedResult, $result);
    }
}
