<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <link rel="stylesheet" href="../assets/css/dashboard.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Include jQuery -->
    <script src="../assets/js/dashboard.js" defer></script>
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
          <li><a href="../../views/home/Home.php">Home</a></li>
          <li><a href="#">My courses</a></li>
          <li><a href="../../views/dashboard/dashboard.html">Dashboard</a></li>
          <li><a href="../../views/home/Admin.php">Admin</a></li>
          <li><a href="../../views/register_login/register_login.php" class="login">Login</a></li>
        </ul>
      </nav>
    </header>-->

    <header>
      <h1 class="dashboard-title">Dashboard</h1>
    </header>

    <div class="card">
      <h2 class="card-title">Up Coming Submissions</h2>
      <!-- <input type="text" class="search-bar" placeholder="Search..." /> -->
      <p class="card-content">
        Assignment 2 Friday, 28 October 2024 <br />Software Engineering
        Assignment <br />
        <a href="assignment.php">
          <button class="card-btn">Add Submission</button>
        </a>
        <br />
      </p>

      <br />
      <p class="card-content">
        Quiz 2 Friday, 28 October 2024 <br />Software Engineering
        Quiz <br />
        <br />
        <a href="assignment.php">
          <button class="card-btn">Add Submission</button>
        </a>
      </p>

      <!-- <p class="card-assignment">Software Engineering Assignment</p> -->
    </div>
    <div class="container">
      <div class="calendar">
        <div class="front">
          <div class="current-date">
            <h1>Friday 15th</h1>
            <h1>January 2016</h1>
          </div>

          <div class="current-month">
            <ul class="week-days">
              <li>MON</li>
              <li>TUE</li>
              <li>WED</li>
              <li>THU</li>
              <li>FRI</li>
              <li>SAT</li>
              <li>SUN</li>
            </ul>

            <div class="weeks">
              <div class="first">
                <span class="last-month">28</span>
                <span class="last-month">29</span>
                <span class="last-month">30</span>
                <span class="last-month">31</span>
                <span>01</span>
                <span>02</span>
                <span>03</span>
              </div>

              <div class="second">
                <span>04</span>
                <span>05</span>
                <span class="event">06</span>
                <span>07</span>
                <span>08</span>
                <span>09</span>
                <span>10</span>
              </div>

              <div class="third">
                <span>11</span>
                <span>12</span>
                <span>13</span>
                <span>14</span>
                <span class="active">15</span>
                <span>16</span>
                <span>17</span>
              </div>

              <div class="fourth">
                <span>18</span>
                <span>19</span>
                <span>20</span>
                <span>21</span>
                <span>22</span>
                <span>23</span>
                <span>24</span>
              </div>

              <div class="fifth">
                <span>25</span>
                <span>26</span>
                <span>27</span>
                <span>28</span>
                <span>29</span>
                <span>30</span>
                <span>31</span>
              </div>
            </div>
          </div>
        </div>

        <div class="back">
          <input placeholder="What's the event?" />
          <div class="info">
            <div class="date">
              <p class="info-date">Date: <span>Jan 15th, 2024</span></p>
              <p class="info-time">Time: <span>6:35 PM</span></p>
            </div>
            <div class="address">
              <p>Assignment 2 <span>Due: Jan 18th, 2024</span></p>
            </div>
            <div class="observations">
              <p>Observations: <span>Submit before deadline</span></p>
            </div>
          </div>

          <div class="actions">
            <button class="save">Save <i class="ion-checkmark"></i></button>
            <button class="dismiss">
              Dismiss <i class="ion-android-close"></i>
            </button>
          </div>
        </div>
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
        © 2024 Misr International University - All Rights Reserved
      </div>
    </footer>
  </body>
</html>