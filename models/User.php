<?php
class User
{
    private $connection;

    public $username;
    public $password;
    public $usertype;
    public $email;
    public $courses = [];

    // Constructor to initialize the database connection
    public function __construct($connection, $username = null, $email = null, $password = null, $usertype = null, $courses = [])
    {
        $this->connection = $connection;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->usertype = $usertype;
        $this->courses = $courses;
    }

    // Sign-Up Method
    public function signUp($username, $email, $password, $usertype)
    {
        // Verify if the email already exists
        $verify_query = mysqli_query($this->connection, "SELECT Email FROM users WHERE Email = '$email'");
        if (mysqli_num_rows($verify_query) != 0) {
            return "This email already exists, try another one!";
        } else {
            // Hash the password before saving
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Updated query to use UserType as string
            $stmt = $this->connection->prepare("INSERT INTO users(UserName, Email, Password, UserType) VALUES(?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $usertype);
            if ($stmt->execute()) {
                return "Registration succeeded!";
            } else {
                return "Error inserting data: " . $stmt->error;
            }
        }
    }

    // Sign-In Method
    public function signIn($email, $password)
    {
        // Fetch user data by email
        $query = mysqli_query($this->connection, "SELECT * FROM users WHERE Email = '$email'");
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            // Verify password
            if (password_verify($password, $row['Password'])) {
                // Store session data, updated to use string for UserType
                session_start();
                $_SESSION['user_id'] = $row['ID'];
                $_SESSION['user_type'] = $row['UserType'];  // Changed from UserType_id to UserType
                $_SESSION['user_name'] = $row['UserName'];

                return true; // Sign-in successful
            } else {
                return "Invalid email or password!";
            }
        } else {
            return "User not found!";
        }
    }

    // Logout Method
    public function logout()
    {
        session_start();
        session_destroy(); // Destroy the session to log out
    }
}
?>
