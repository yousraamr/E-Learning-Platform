<?php
session_start();

include_once __DIR__ . "/../db/config.php";
include_once __DIR__ . "/../models/User.php";

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$user = new User($connection);

// Handle Sign-Up
if (isset($_POST['submit'])) {
    $username = htmlspecialchars(trim($_POST['UserName']));
    $email = filter_var(trim($_POST['Email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['Password'];
    $usertype = 'Student'; // Default user type: Student

    $result = $user->signUp($username, $email, $password, $usertype);

    echo "<div class='message'><p>$result</p></div><br>";
}

// Handle Sign-In
if (isset($_POST['login'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $result = $user->signIn($email, $password);
    if ($result === true) {
        // Redirect based on user type after successful login
        switch ($_SESSION['user_type']) {
            case 'Admin':
            case 'Instructor':
            case 'Student':
                header("Location: /swe_project/views/Home.php");
                exit();
            default:
                echo "<div class='message'><p>Invalid user type!</p></div>";
        }
    } else {
        echo "<div class='message'><p>$result</p></div><br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/register_login.css">
    <title>SignUp | SignIn</title>
</head>

<body>

    <div class="container" id="container">
        <!-- Sign Up-->
        <div class="form-container sign-up">
            <form method="POST">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input type="text" name="UserName" placeholder="Name" required>
                <input type="email" name="Email" placeholder="Email" required>
                <input type="password" name="Password" placeholder="Password" required>
                <input type="hidden" name="UserType_id" value="3"> <!-- Default user type as Student -->
                <button type="submit" id="submit_signup" name="submit">Sign Up</button>
            </form>
        </div>

        <!-- Sign In-->
        <div class="form-container sign-in">
            <form method="POST">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email and password</span>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <a href="#">Forget Your Password?</a>
                <button type="submit" name="login">Sign In</button>
            </form>
        </div>
        
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Welcome, Learner!</h1>
                    <p>Register with your personal details to use all site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/register_login.js"></script>
</body>
</html>
