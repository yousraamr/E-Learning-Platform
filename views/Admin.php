
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Users</title>
  <link rel="stylesheet" href="../assets/css/Admin.css"> 
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
        <form id="userForm">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>

          <!-- Updated Role Field -->
          <label for="role">Role:</label>
          <select id="role" name="role" required>
            <option value="">Select Role</option>
            <option value="Instructor">Instructor</option>
            <option value="Student">Student</option>
          </select>

          <label for="first-name">User Name:</label>
          <input type="text" id="first-name" name="first-name" required>

          <!-- New Password Field -->
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>








          <button type="submit" class="submit-btn">Add User</button>
        </form>
      </section>



      <div class="container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>User Name</th>
                    <th>Course name</th>
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


              // read all row from database table
              $sql = "SELECT * FROM users";
              $result = $connection->query($sql);
              if (!$result) {
              die("Invalid query:" . $connection->error);
              }
              // read data of each row
              while($row = $result->fetch_assoc())
              {
                 echo"<tr> <td>$row[ID]</td> <td>$row[Email]</td> <td>$row[UserType]</td>  <td>$row[UserName]</td>  <td> <a href='AdminEdit.php?id= $row[ID]' class='submit-btn'>Edit</a> <a href='DeleteAdmin.php?id= $row[ID]' class='submit-btn'>Delete</a> </td></tr>";
               
              
            }
            ?>

              
            </tbody>
        </table>
    </div>

    </main>
  </div>
</body>
</html>
