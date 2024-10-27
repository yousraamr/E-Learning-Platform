 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Users</title>
  <link rel="stylesheet" href="..\..\assets\css\Admin.css">
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

          <label for="first-name">First Name:</label>
          <input type="text" id="first-name" name="first-name" required>

          <label for="last-name">Last Name:</label>
          <input type="text" id="last-name" name="last-name" required>

          <!-- New Password Field -->
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>

          <button type="submit" class="submit-btn">Add User</button>
        </form>
      </section>

      <!-- User Table -->
      <section class="user-table">
        <h2>Users</h2>
        <br>
        <table>
          <thead>
            <tr>
              <th>Email</th>
              <th>Role</th>
              <th>First Name</th>
              <th>Last Name</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>francois@instagrid.dev</td>
              <td>Instructor</td>
              <td>Francois</td>
              <td>Vores</td>
            </tr>
            <tr>
              <td>xmed@grunge.ducky</td>
              <td>Student</td>
              <td>Anne</td>
              <td>Bretagne</td>
            </tr>
          </tbody>
        </table>
        <div class="pagination">
          <p>Showing 1 to 2 of 2 results.</p>
          <div class="page-controls">
            <button class="prev-page">← Previous</button>
            <button class="next-page">Next →</button>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
