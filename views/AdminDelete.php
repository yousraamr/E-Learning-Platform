<?php
require_once('../models/AdminModel.php');
require_once(__DIR__ . '/../controllers/AdminController.php');

session_start();

// Handle POST request to save user data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $userId = intval($_POST['id']);

        // Gather form data
        $email = $_POST['email'];
        $role = $_POST['role'];
        $userName = $_POST['first-name'];
        $password = $_POST['password'];
        $courses = $_POST['courses'];

        $adminController = new AdminController();

        // Update the user
        $result = $adminController->editUser($userId, $userName, $email, $password, $role, $courses);

        if ($result === "User updated successfully!") {
        header("Location: Admin.php?message=User updated successfully");
        exit;
        } else {
            echo "Error updating user: " . $result;
        }
      }
}

// Handle GET request to display the form
if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);

    $adminController = new AdminController();
    $userData = $adminController->getUserById($userId);

    if (!$userData) {
        die('User not found');
    }

    $sql = "SELECT GROUP_CONCAT(user_courses.course_name SEPARATOR ', ') AS courses FROM users LEFT JOIN user_courses ON users.ID = user_courses.user_id where user_id='$userId' GROUP BY users.ID ";
              $result = $connection->query($sql);

              if (!$result) {
                  die("Invalid query: " . $connection->error);
              }

              while ($row = $result->fetch_assoc()) {
                $userData['courses']=$row['courses'];

    $courses = $userData['courses'];

} 
}else {
    die('Invalid user ID');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Users</title>
  <link rel="stylesheet" href="../assets/css/Admin2.css"> 
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <div class="brand">
        <h2>Admin</h2>
      </div>
      <nav>
        <ul>
          <li><a href="Home.php">Home</a></li>
          <li><a href="#">Dashboard</a></li>
        </ul>
      </nav>
    </aside>

    <main class="content">
      <!-- Add New User Form -->
      <section class="add-user-form">
        <h2>Edit User info</h2>
        <br>
        <form id="userForm" method="POST" action="AdminEdit.php">
           <!-- Hidden ID Field -->
           <input type="hidden" name="id" value="<?php echo htmlspecialchars($userId); ?>">

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['Email']); ?>" required>

    
          <!-- Updated Role Field -->
          <label for="role">Role:</label>
          <select id="role" name="role" required>
          <option value="Admin" <?php echo $userData['UserType'] == 'Admin' ? 'selected' : ''; ?>>Admin</option>
            <option value="Instructor" <?php echo $userData['UserType'] == 'Instructor' ? 'selected' : ''; ?>>Instructor</option>
            <option value="Student" <?php echo $userData['UserType'] == 'Student' ? 'selected' : ''; ?>>Student</option>
          </select>

          <label for="first-name">User Name:</label>
          <input type="text" id="first-name" name="first-name" value="<?php echo htmlspecialchars($userData['UserName']); ?>" required>

       
          
          <!-- Courses -->
          <?php
          for ($i = 0; $i < 4; $i++) {
              $coursesarr = explode(',', $courses);
              $course_value = isset($courses[$i]) ? htmlspecialchars($coursesarr[$i]) : '';
              echo "<label for='course$i'>Course " . ($i + 1) . ":</label>";
              echo "<input type='text' id='course$i' name='courses[]' value='$course_value' placeholder='Enter course name'>";
          }
          ?>

        

          <button type="submit" class="submit-btn">Save</button>
        </form>
      </section>
    </main>
  </div>
</body>
</html>
