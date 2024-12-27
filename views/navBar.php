<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Misr International University (MIU)</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="../../assets/css/navBar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo">
            <img src="../assets/images/logo.png" alt="MIU Logo">
        </div>
        <ul class="nav-links">
            <?php
            session_start();

            // Debugging: Display session variables (for testing, remove in production)
            // echo '<pre>';
            // print_r($_SESSION);
            // echo '</pre>';

            // Include the database configuration file
            include __DIR__ . '/../db/config.php';

            try {
                // Check database connection
                if (!isset($connection) || $connection->connect_error) {
                    throw new Exception("Database connection failed: " . ($connection->connect_error ?? 'Undefined connection'));
                }

                // Validate that user_type exists and is a string
                if (!isset($_SESSION['user_type'])) {
                    throw new Exception("Session user_type is not set.");
                }
                $userType = $_SESSION['user_type'];

                // Query to fetch accessible pages for the user type (based on string UserType)
                $query = "SELECT pages.FriendlyName, pages.LinkAddress
                    FROM usertype_pages
                    JOIN pages ON usertype_pages.PageID = pages.ID
                    WHERE usertype_pages.UserType = ?  -- Use UserType as string
                    ORDER BY pages.ID";

                $stmt = $connection->prepare($query);
                if (!$stmt) {
                    throw new Exception("Failed to prepare statement: " . $connection->error);
                }

                $stmt->bind_param("s", $userType);  // Bind the user type as a string
                $stmt->execute();
                $result = $stmt->get_result();

                // Display navigation links
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<li><a href="' . htmlspecialchars($row['LinkAddress']) . '">' . htmlspecialchars($row['FriendlyName']) . '</a></li>';
                    }
                } else {
                    echo '<li><a href="#">No pages available for your user type.</a></li>';
                }

                $stmt->close();
            } catch (Exception $e) {
                // Display error messages in the navigation bar for debugging
                echo '<li><a href="#">Error: ' . htmlspecialchars($e->getMessage()) . '</a></li>';
            } finally {
                // Close the database connection
                if (isset($connection) && $connection instanceof mysqli) {
                    $connection->close();
                }
            }
            ?>
        </ul>
    </nav>
</header>
</body>
</html>
