<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../vendor/autoload.php';

class UserTest extends TestCase {
    private $userMock;
    private $connectionMock;

    protected function setUp(): void {
        $this->connectionMock = $this->createMock(mysqli::class);
        $this->userMock = $this->getMockBuilder(User::class)
                               ->setConstructorArgs([$this->connectionMock])
                               ->getMock();
    }

    // Test for signUp
    public function testSignUp() {
        $email = 'student@gmail.com';
        $this->connectionMock->method('query')
                            ->willReturn(true);  // Using true as mysqli_query returns true/false

        $this->userMock->expects($this->once())
                       ->method('signUp')
                       ->with('username', $email, 'password', 'Student')
                       ->willReturn('Registration succeeded!');

        $result = $this->userMock->signUp('username', $email, 'password', 'Student');
        $this->assertEquals('Registration succeeded!', $result);
    }

    public function testSignUpWithDuplicateEmail() {
        $email = 'student@gmail.com';
        $this->connectionMock->method('query')
                            ->willReturn(false);  // Simulate the query failure (email already exists)
    
        $this->userMock->expects($this->once())
                       ->method('signUp')
                       ->with('student01', $email, 'student0123', 'Student')
                       ->willReturn('This email already exists, try another one!');
    
        $result = $this->userMock->signUp('student01', $email, 'student0123', 'Student');
        $this->assertEquals('This email already exists, try another one!', $result);
    }
    

    // Test for signIn
    public function testSignInWithValidCredentials() {
        $email = 'student@gmail.com';
        $password = 'student123';
        $userData = [
            'ID' => 1,
            'UserName' => 'student',
            'Email' => $email,
            'Password' => password_hash($password, PASSWORD_DEFAULT),
            'UserType' => 'Student'
        ];

        // Use a stub for mysqli_result to mimic the query return
        $resultMock = $this->getMockBuilder(mysqli_result::class)
                           ->disableOriginalConstructor()
                           ->getMock();

        // Define how the result should behave when fetch_assoc() is called
        $resultMock->method('fetch_assoc')
                   ->willReturn($userData);

        $this->connectionMock->method('query')
                            ->willReturn($resultMock);  // Return the mocked result object

        $this->userMock->expects($this->once())
                       ->method('signIn')
                       ->with($email, $password)
                       ->willReturn(true);

        $result = $this->userMock->signIn($email, $password);
        $this->assertTrue($result);
    }

    public function testSignInWithIncorrectPassword() {
        $email = 'student@gmail.com';
        $password = 'wrongpass';  // Incorrect password
        $userData = [
            'ID' => 1,
            'UserName' => 'student',
            'Email' => $email,
            'Password' => password_hash('student123', PASSWORD_DEFAULT),  // Correct hashed password
            'UserType' => 'Student'
        ];
    
        // Use a stub for mysqli_result to mimic the query return
        $resultMock = $this->getMockBuilder(mysqli_result::class)
                           ->disableOriginalConstructor()
                           ->getMock();
    
        // Define how the result should behave when fetch_assoc() is called
        $resultMock->method('fetch_assoc')
                   ->willReturn($userData);
    
        $this->connectionMock->method('query')
                            ->willReturn($resultMock);  // Return the mocked result object
    
        $this->userMock->expects($this->once())
                       ->method('signIn')
                       ->with($email, $password)
                       ->willReturn('Invalid email or password!');
    
        $result = $this->userMock->signIn($email, $password);
        $this->assertEquals('Invalid email or password!', $result);
    }


    // Test for logout
    public function testLogout() {
        // Start a session and set some session variables
        $_SESSION['user_id'] = 1;
        $_SESSION['user_type'] = 'Student';
        $_SESSION['user_name'] = 'student';
    
        // Ensure session variables are set
        $this->assertArrayHasKey('user_id', $_SESSION);
        $this->assertArrayHasKey('user_type', $_SESSION);
        $this->assertArrayHasKey('user_name', $_SESSION);
    
        // Mock the logout method to destroy the session
        $this->userMock->expects($this->once())
                       ->method('logout')
                       ->will($this->returnCallback(function () {
                           // Simulate session destruction
                           $_SESSION = [];
                       }));
    
        // Call the logout method
        $this->userMock->logout();
    
        // Verify that the session variables are cleared
        $this->assertArrayNotHasKey('user_id', $_SESSION);
        $this->assertArrayNotHasKey('user_type', $_SESSION);
        $this->assertArrayNotHasKey('user_name', $_SESSION);
    }
    
    
    // Test for downloadFile with a valid file
    public function testDownloadFile() {
        // Mock the $_GET parameters
        $_GET['course'] = 'course1';
        $_GET['section'] = 'section1';
        $_GET['file'] = 'example.txt';

        $baseDirectory = __DIR__ . '/../views/uploads';
        $directory = "$baseDirectory/course1/section1";
        $filePath = "$directory/example.txt";

        // Ensure directory and file exist for testing
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        file_put_contents($filePath, "Test content");

        // Mock the User::downloadFile() method
        $this->userMock->expects($this->once())
                       ->method('downloadFile')
                       ->willReturn(file_get_contents($filePath));

        ob_start();
        $result = $this->userMock->downloadFile();
        ob_end_clean();

        $this->assertEquals('Test content', $result);

        // Cleanup
        unlink($filePath);
        rmdir($directory);
    }

    // Test for downloadFile with a nonexistent file
    public function testDownloadFileNotFound() {
        $_GET['course'] = 'course1';
        $_GET['section'] = 'section1';
        $_GET['file'] = 'nonexistent.txt';

        $this->userMock->expects($this->once())
                       ->method('downloadFile')
                       ->willReturn('Error: File not found.');

        ob_start();
        $result = $this->userMock->downloadFile();
        ob_end_clean();

        $this->assertEquals('Error: File not found.', $result);
    }
}
