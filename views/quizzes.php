<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/quizzes.css" />
  </head>
  <body>
      <!-- Navigation Bar -->
      <?php include 'navBar.php'; ?>

    <!--<header>
      <nav class="navbar">
        <div class="logo">
          <img src="..\..\assets\images\logo.png" alt="MIU Logo" />
        </div>
        <ul class="nav-links">
          <li><a href="#">Home</a></li>
          <li><a href="#">My courses</a></li>
          <li><a href="#">Dashboard</a></li>
          <li><a href="#">Admin</a></li>
          <li><a href="#" class="login">Login</a></li>
        </ul>
      </nav>
    </header>-->

    <header>
      <h1 class="dashboard-title">Quizzes</h1>
    </header>
    <h2>Quiz 01 - Sunday</h2>
    <p class="work">
      Opened:26/10/2024 at 12AM <br />
      Closed: 30/10/2024 at 12AM
    </p>
    <hr />
    <p class="parag">
      Attempts allowed: 1 <br />
      <br />
      Attention! It is prohibited to change device while attempting this quiz.
      Please note that after beginning of quiz attempt any connections to this
      quiz using other computers, devices and browsers will be blocked. Do not
      close the browser window until the end of attempt, otherwise you will not
      be able to complete this quiz. <br />
      <br />
      To attempt this quiz you need to know the quiz password
    </p>
    <div class="attempts-section">
      <h1>Your attempts</h1>
      <div class="attempt-card">
        <h2>Attempt 1</h2>
        <table class="attempt-table">
          <tr>
            <th>Status</th>
            <td>Finished</td>
          </tr>
          <tr>
            <th>Started</th>
            <td>Sunday, 20 October 2024, 8:52 AM</td>
          </tr>
          <tr>
            <th>Completed</th>
            <td>Sunday, 20 October 2024, 10:00 AM</td>
          </tr>
          <tr>
            <th>Duration</th>
            <td>1 hour 7 mins</td>
          </tr>
        </table>
        <p class="review-info">Review not permitted</p>
        <p class="attempt-info">No more attempts are allowed</p>
        <button class="back-btn">Back to the course</button>
      </div>
    </div>
    <footer class="footer">
      <div class="footer-container">
        <div class="footer-logo">
          <img src="../assets/images/logo.png" alt="MIU Logo" />
          <p>
            Misr International University<br />
            Established 1996
          </p>
        </div>

        <div class="footer-contact">
          <h4>Contact Us</h4>
          <p>Phone: +20 123 456 789<br />Email: info@miu.edu.eg</p>
          <p>Address: 123 MIU Street, Cairo, Egypt</p>
        </div>

        <div class="footer-links">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="#">Campus Map</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Admission Process</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>

        <div class="footer-social">
          <a href="#"><i class="fab fa-facebook"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-linkedin"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
      </div>

      <div class="footer-bottom">
        ©️ 2024 Misr International University - All Rights Reserved
      </div>
    </footer>
  </body>
</html>
