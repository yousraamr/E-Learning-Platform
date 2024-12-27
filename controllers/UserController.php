<<<<<<< HEAD
<?php
session_start();

include_once __DIR__ . "/../db/config.php";
include_once __DIR__ . "/../models/User.php";

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$user = new User($connection);

class UserController
{
    private $user;

    // Constructor to initialize the User model
    public function __construct($user)
    {
        $this->user = $user;
    }

    // Handle user sign-up
    public function signUp()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $username = htmlspecialchars(trim($_POST['UserName']));
            $email = filter_var(trim($_POST['Email']), FILTER_SANITIZE_EMAIL);
            $password = $_POST['Password'];
            $usertype = 'Student'; // Default user type

            $result = $this->user->signUp($username, $email, $password, $usertype);

            return $result; // Returns a success or error message
        }
        return null;
    }

    // Handle user sign-in
    public function signIn()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $result = $this->user->signIn($email, $password);
            if ($result === true) {
                // Redirect based on user type after successful login
                switch ($_SESSION['user_type']) {
                    case 'Admin':
                    case 'Instructor':
                    case 'Student':
                        header("Location: /swe_project/views/Home.php");
                        exit();
                    default:
                        return "Invalid user type!";
                }
            } else {
                return $result; // Error message
            }
        }
        return null;
    }

    // Handle user logout
    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
            $this->user->logout();
            header("Location: /swe_project/views/register-login.php");
            exit();
        }
    }
}

// Initialize the controller
$controller = new UserController($user);

// Handle sign-up and sign-in
$signupMessage = $controller->signUp();
$signinMessage = $controller->signIn();

// Logout functionality
$controller->logout();

?>
=======
<?php
session_start();

include_once __DIR__ . "/../db/config.php";
include_once __DIR__ . "/../models/User.php";

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$user = new User($connection);

class UserController
{
    private $user;

    // Constructor to initialize the User model
    public function __construct($user)
    {
        $this->user = $user;
    }

    // Handle user sign-up
    public function signUp()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $username = htmlspecialchars(trim($_POST['UserName']));
            $email = filter_var(trim($_POST['Email']), FILTER_SANITIZE_EMAIL);
            $password = $_POST['Password'];
            $usertype = 'Student'; // Default user type

            $result = $this->user->signUp($username, $email, $password, $usertype);

            return $result; // Returns a success or error message
        }
        return null;
    }

    // Handle user sign-in
    public function signIn()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $result = $this->user->signIn($email, $password);
            if ($result === true) {
                // Redirect based on user type after successful login
                switch ($_SESSION['user_type']) {
                    case 'Admin':
                    case 'Instructor':
                    case 'Student':
                        header("Location: /swe_project/views/Home.php");
                        exit();
                    default:
                        return "Invalid user type!";
                }
            } else {
                return $result; // Error message
            }
        }
        return null;
    }

    // Handle user logout
    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
            $this->user->logout();
            header("Location: /swe_project/views/register-login.php");
            exit();
        }
    }
}

// Initialize the controller
$controller = new UserController($user);

// Handle sign-up and sign-in
$signupMessage = $controller->signUp();
$signinMessage = $controller->signIn();

// Logout functionality
$controller->logout();

?>
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
