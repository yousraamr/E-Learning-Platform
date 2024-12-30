<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../vendor/autoload.php';

class AdminTest extends TestCase {
    private $adminMock;
    private $connectionMock;

    protected function setUp(): void {
        // Mock the MySQL connection
        $this->connectionMock = $this->createMock(mysqli::class);

        // Mock the Admin class, passing the mocked connection to the constructor
        $this->adminMock = $this->getMockBuilder(Admin::class)
                                 ->setConstructorArgs([$this->connectionMock])
                                 ->getMock();
    }

    // Test for addUser
    public function testAddUserWithUniqueEmail() {
        $username = 'newUser';
        $email = 'newuser@example.com';
        $password = 'password123';
        $usertype = 'Student';
        $courses = ['Math', 'Science'];

        // Mock query to simulate email not existing
        $this->connectionMock->method('query')
                             ->willReturn(false);

        // Create a mock for mysqli_stmt to simulate the prepared statement behavior
        $stmtMock = $this->createMock(mysqli_stmt::class);

        // Mock methods for the statement
        $stmtMock->method('bind_param')->willReturn(true); // Mock bind_param
        $stmtMock->method('execute')->willReturn(true); // Mock execute

        // Mock the prepare method to return the statement mock
        $this->connectionMock->method('prepare')
                             ->willReturn($stmtMock);

        // Expect the addUser method to be called and return success message
        $this->adminMock->expects($this->once())
                        ->method('addUser')
                        ->with($username, $email, $password, $usertype, $courses)
                        ->willReturn("User added successfully!");

        // Call the method and check the result
        $result = $this->adminMock->addUser($username, $email, $password, $usertype, $courses);
        $this->assertEquals("User added successfully!", $result);
    }

    // Test for editUser with valid data
    public function testEditUserWithValidData() {
        $userId = 1;
        $username = 'updatedUser';
        $email = 'updateduser@example.com';
        $password = 'newpassword123';
        $usertype = 'Instructor';
        $courses = ['Physics', 'Chemistry'];

        // Create a mock for mysqli_stmt to simulate the prepared statement behavior
        $stmtMock = $this->createMock(mysqli_stmt::class);

        // Mock methods for the statement
        $stmtMock->method('bind_param')->willReturn(true);
        $stmtMock->method('execute')->willReturn(true);

        // Mock the prepare method to return the statement mock
        $this->connectionMock->method('prepare')
                             ->willReturn($stmtMock);

        // Expect the editUser method to be called and return success message
        $this->adminMock->expects($this->once())
                        ->method('editUser')
                        ->with($userId, $username, $email, $password, $usertype, $courses)
                        ->willReturn("User updated successfully!");

        // Call the method and check the result
        $result = $this->adminMock->editUser($userId, $username, $email, $password, $usertype, $courses);
        $this->assertEquals("User updated successfully!", $result);
    }

    // Test for deleteUser
    public function testDeleteUser() {
        $userId = 1;

        // Create a mock for mysqli_stmt to simulate the prepared statement behavior
        $stmtMock = $this->createMock(mysqli_stmt::class);

        // Mock methods for the statement
        $stmtMock->method('bind_param')->willReturn(true);
        $stmtMock->method('execute')->willReturn(true);

        // Mock the prepare method to return the statement mock
        $this->connectionMock->method('prepare')
                             ->willReturn($stmtMock);

        // Expect the deleteUser method to be called and return success message
        $this->adminMock->expects($this->once())
                        ->method('deleteUser')
                        ->with($userId)
                        ->willReturn("User deleted successfully!");

        // Call the method and check the result
        $result = $this->adminMock->deleteUser($userId);
        $this->assertEquals("User deleted successfully!", $result);
    }
}
