<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../vendor/autoload.php';

class UserControllerTest extends TestCase
{
    public function testSignUpWithValidData(){
        $mockUser = $this->createMock(User::class);
        $mockUser->method('signUp')->willReturn("Sign-up successful!");

        $controller = new UserController($mockUser);

        $requestMethod = 'POST';
        $postData = [
            'submit' => true,
            'UserName' => 'student',
            'Email' => 'student@gmail.com',
            'Password' => 'student123',
        ];

        $result = $controller->signUp($requestMethod, $postData);
        $this->assertEquals("Sign-up successful!", $result);
    }

    public function testSignUpWithDuplicateEmail() {
        $mockUser = $this->createMock(User::class);
        $mockUser->method('signUp')->willReturn('This email already exists, try another one!');
    
        $controller = new UserController($mockUser);
    
        $requestMethod = 'POST';
        $postData = [
            'submit' => true,
            'UserName' => 'student01',
            'Email' => 'student@gmail.com',
            'Password' => 'student0123',
        ];
    
        $result = $controller->signUp($requestMethod, $postData);
        $this->assertEquals('This email already exists, try another one!', $result);
    }
    
    public function testSignInWithValidCredentials(){
        $mockUser = $this->createMock(User::class);
        $mockUser->method('signIn')->willReturn(true);

        $controller = new UserController($mockUser);

        $requestMethod = 'POST';
        $postData = [
            'login' => true,
            'email' => 'student@gmail.com',
            'password' => 'student',
        ];

        $result = $controller->signIn($requestMethod, $postData);
        $this->assertEquals("Login successful", $result);
    }

    public function testSignInWithIncorrectPassword() {
        $mockUser = $this->createMock(User::class);
        $mockUser->method('signIn')
                 ->willReturn('Invalid email or password!');
    
        $controller = new UserController($mockUser);
    
        $requestMethod = 'POST';
        $postData = [
            'login' => true,
            'email' => 'student@gmail.com',
            'password' => 'wrongpass',  // Incorrect password
        ];
    
        $result = $controller->signIn($requestMethod, $postData);
        $this->assertEquals('Invalid email or password!', $result);
    }
    
}
?>