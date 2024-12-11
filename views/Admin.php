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
        <h2>Add New User</h2>
        <br>
        <form id="userForm" method="POST" action="">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required >

          <label for="role">Role:</label>
          <select id="role" name="role" required>
            <option value="Admin">Admin</option>
            <option value="Instructor">Instructor</option>
            <option value="Student">Student</option>
          </select>

          <label for="UserName">User Name:</label>
          <input type="text" id="UserName" name="UserName" required 
          pattern=".{3,}" 
          title="User Name must be at least 3 characters long" >

          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>

          <label for="course1">Course 1:</label>
          <input type="text" id="course1" name="courses[]" placeholder="Enter course name" required 
          pattern=".{3,}" 
          title="Course Name must be at least 3 characters long">
          <label for="course2">Course 2:</label>
          <input type="text" id="course2" name="courses[]" placeholder="Enter course name"
          pattern=".{3,}" 
          title="Course Name must be at least 3 characters long">
          <label for="course3">Course 3:</label>
          <input type="text" id="course3" name="courses[]" placeholder="Enter course name"
          pattern=".{3,}" 
          title="Course Name must be at least 3 characters long">
          <label for="course4">Course 4:</label>
          <input type="text" id="course4" name="courses[]" placeholder="Enter course name"
          pattern=".{3,}" 
          title="Course Name must be at least 3 characters long">

          <button type="submit" class="submit-btn">Add User</button>
        </form>
        <br>
        <?php


        // Add User PHP logic
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          require_once(__DIR__ . '/../models/User.php');
          require_once(__DIR__ . '/../models/AdminModel.php');


          $servername = "localhost";
          $username = "root";
          $password = ""; 
          $database = "e-learning platform"; 

          $connection = new mysqli($servername, $username, $password, $database);

          if ($connection->connect_error) {
              die("Connection failed: " . $connection->connect_error);
          }

          $admin = new Admin($connection);

          $email = $_POST['email'];
          $role = $_POST['role'];
          $userName = $_POST['UserName'];
          $password = $_POST['password'];
          $courses = $_POST['courses'];

          $result = $admin->addUser($userName, $email, $password, $role, $courses);
          echo "<p>$result</p>";
        }
        ?>
      </section>

      <div class="container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>User Name</th>
                    <th>Courses</th>
                    <th>Timestamp</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
              $servername = "localhost";
              $username = "root";
              $password = ""; 
              $database = "e-learning platform"; 

              $connection = mysqli_connect($servername, $username, $password, $database);

              if (!$connection) {
                  die("Connection failed: " . mysqli_connect_error());
              }

              $sql = "SELECT users.ID, users.Email, users.UserType, users.UserName, GROUP_CONCAT(user_courses.course_name SEPARATOR ', ') AS courses, users.created_at FROM users LEFT JOIN user_courses ON users.ID = user_courses.user_id GROUP BY users.ID";
              $result = $connection->query($sql);

              if (!$result) {
                  die("Invalid query: " . $connection->error);
              }

              while ($row = $result->fetch_assoc()) {
                  echo "<tr><td>{$row['ID']}</td> <td>{$row['Email']}</td> <td>{$row['UserType']}</td> <td>{$row['UserName']}</td> <td>{$row['courses']}</td> <td>{$row['created_at']}</td> <td> <a href='AdminEdit.php?id={$row['ID']}' class='submit-btn'>Edit</a> <a href='AdminDelete.php?id={$row['ID']}' class='submit-btn'>Delete</a> </td></tr>";
              }
            ?>
            </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
