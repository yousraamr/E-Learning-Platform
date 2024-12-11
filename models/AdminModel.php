<?php
require_once(__DIR__ . '/../db/config.php');
require_once(__DIR__ . '/User.php'); 

class Admin extends User
{
    public $connection;

    public function __construct($connection = null, $username = null, $email = null, $password = null, $usertype = 'admin', $courses = [])
    {
        if ($connection === null) {
            $this->connection = mysqli_connect($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);

            if (!$this->connection) {
                die('Database connection failed: ' . mysqli_connect_error());
            }
        } else {
            $this->connection = $connection;
        }

        if ($username !== null && $email !== null && $password !== null) {
            parent::__construct($connection, $username, $email, $password, $usertype, $courses);
        }
    }


    // Method to get user data by ID
    public function getUserById($user_id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE ID = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Return the user data as an associative array
        } else {
            return null; // No user found
        }
    }



    // Add a new user
    public function addUser($username, $email, $password, $usertype, $courses = [])
    {
        // Check if email already exists
        $verify_query = $this->connection->query("SELECT Email FROM users WHERE Email = '$email'");
        if ($verify_query->num_rows != 0) {
            return "This email already exists, try another one!";
        }
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $stmt = $this->connection->prepare("INSERT INTO users(UserName, Email, Password, UserType) VALUES(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $usertype);

        if ($stmt->execute()) {
            // Get the newly created user's ID
            $user_id = $this->connection->insert_id;

            // Assign courses to the user
            foreach ($courses as $course) {
                $course_stmt = $this->connection->prepare("INSERT INTO user_courses(user_id, course_name) VALUES(?, ?)");
                $course_stmt->bind_param("is", $user_id, $course);
                $course_stmt->execute();
            }

            return "User added successfully!";
        } else {
            return "Error adding user: " . $stmt->error;
        }
    }



    
   // Edit an existing user
    public function editUser($userId, $username, $email, $password, $usertype, $courses = []) {
    // Check if email is changing and already exists for another user
    $verify_query = $this->connection->prepare("SELECT ID FROM users WHERE Email = ? AND ID != ?");
    $verify_query->bind_param("si", $email, $userId);
    $verify_query->execute();
    $verify_result = $verify_query->get_result();

    if ($verify_result->num_rows != 0) {
        return "This email already exists, try another one!";
    }

    // Update the user's details in the `users` table
    if (!empty($password)) { // If a new password is provided
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->connection->prepare("UPDATE users SET UserName = ?, Email = ?, Password = ?, UserType = ? WHERE ID = ?");
        $stmt->bind_param("ssssi", $username, $email, $hashed_password, $usertype, $userId);
    } else { // If no password is provided, update other fields only
        $stmt = $this->connection->prepare("UPDATE users SET UserName = ?, Email = ?, UserType = ? WHERE ID = ?");
        $stmt->bind_param("sssi", $username, $email, $usertype, $userId);
    }

    if ($stmt->execute()) {
        // Delete all current courses for the user
        $delete_courses_stmt = $this->connection->prepare("DELETE FROM user_courses WHERE user_id = ?");
        $delete_courses_stmt->bind_param("i", $userId);
        $delete_courses_stmt->execute();

        // Assign new courses to the user
        foreach ($courses as $course) {
            if (!empty($course)) { // Avoid inserting empty courses
                $course_stmt = $this->connection->prepare("INSERT INTO user_courses(user_id, course_name) VALUES(?, ?)");
                $course_stmt->bind_param("is", $userId, $course);
                $course_stmt->execute();
            }
        }

        return "User updated successfully!";
    } else {
        return "Error updating user: " . $stmt->error;
    }
}






public function deleteUser($user_id)
{
    // Delete the user's courses first
    $stmt = $this->connection->prepare("DELETE FROM user_courses WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Delete the user from the database
    $stmt = $this->connection->prepare("DELETE FROM users WHERE ID = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        return "User deleted successfully!";
    } else {
        return "Error deleting user: " . $stmt->error;
    }
}
}
?>
