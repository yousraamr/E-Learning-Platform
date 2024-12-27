<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/assignment.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  </head>
  <body>
    <header>
      <h1 class="dashboard-title">Assignments</h1>
    </header>
    <h3>Week 1 Assignment</h3>
    <p class="work">
      Opened:26/10/2024 at 12AM <br />
      Closed: 30/10/2024 at 12AM
    </p>
    <hr />
    <div class="card">
      <h2 class="card-title">Up Coming Submissions</h2>

      <p class="card-content">Friday, 28 October 2024</p>
      <p class="card-assignment">Software Engineering Assignment</p>
      <!-- <button class="card-btn">Add Submission</button> -->
    </div>

    <form action="upload.php" method="POST" class="form-upload">
      <input type="file" multiple />
      <p>Drag your files here or click in this area.</p>
      <button type="submit">Upload</button>
    </form>
    <footer class="footer">
      <div class="footer-container">
        <div class="footer-logo">
          <img src="..\..\assets\images\logo.png" alt="MIU Logo" />
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
