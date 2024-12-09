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
        <h2>Edit User info</h2>
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

          <button type="submit" class="submit-btn">Save</button>
        </form>
      </section>

      </main>
  </div>
</body>
</html>