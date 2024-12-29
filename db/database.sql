<<<<<<< HEAD
-- Table structure for table `usertypes`
CREATE TABLE `usertypes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` enum('Admin', 'Instructor', 'Student') NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `pages`
CREATE TABLE `pages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FriendlyName` varchar(50) NOT NULL,
  `LinkAddress` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `users` with `UserType` as ENUM
CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL UNIQUE,
  `Password` varchar(255) NOT NULL,
  `UserType` enum('Admin', 'Instructor', 'Student') NOT NULL,  -- Changed to ENUM
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- New column for timestamp
  `courses` JSON DEFAULT NULL,  -- New column to store array of courses as JSON
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `user_courses`
CREATE TABLE `user_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `usertype_pages` with `UserType` as ENUM
CREATE TABLE `usertype_pages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserType` enum('Admin', 'Instructor', 'Student') NOT NULL,  -- Changed to ENUM
  `PageID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `PageID` (`PageID`),
  CONSTRAINT `usertype_pages_ibfk_1` FOREIGN KEY (`PageID`) REFERENCES `pages` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insert data for user types
INSERT INTO `usertypes` (`ID`, `Name`) VALUES
=======
-- Table structure for table usertypes
CREATE TABLE usertypes (
  ID int(11) NOT NULL AUTO_INCREMENT,
  Name enum('Admin', 'Instructor', 'Student') NOT NULL,
  PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table pages
CREATE TABLE pages (
  ID int(11) NOT NULL AUTO_INCREMENT,
  FriendlyName varchar(50) NOT NULL,
  LinkAddress varchar(50) NOT NULL,
  PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table users with UserType as ENUM
CREATE TABLE users (
  ID int(11) NOT NULL AUTO_INCREMENT,
  UserName varchar(50) NOT NULL,
  Email varchar(100) NOT NULL UNIQUE,
  Password varchar(255) NOT NULL,
  UserType enum('Admin', 'Instructor', 'Student') NOT NULL,  -- Changed to ENUM
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- New column for timestamp
  courses JSON DEFAULT NULL,  -- New column to store array of courses as JSON
  PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table user_courses
CREATE TABLE user_courses (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  course_name varchar(100) NOT NULL,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  CONSTRAINT user_courses_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table usertype_pages with UserType as ENUM
CREATE TABLE usertype_pages (
  ID int(11) NOT NULL AUTO_INCREMENT,
  UserType enum('Admin', 'Instructor', 'Student') NOT NULL,  -- Changed to ENUM
  PageID int(11) NOT NULL,
  PRIMARY KEY (ID),
  KEY PageID (PageID),
  CONSTRAINT usertype_pages_ibfk_1 FOREIGN KEY (PageID) REFERENCES pages (ID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE course_sections (
    id INT(11) NOT NULL AUTO_INCREMENT,
    course_name VARCHAR(100) NOT NULL,
    section_name VARCHAR(100) NOT NULL,
    PRIMARY KEY (id),
    KEY course_name (course_name)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE uploads (
    id INT(11) NOT NULL AUTO_INCREMENT,
    file_name VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    course_id INT(11) NOT NULL,
    section_id INT(11) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (course_id) REFERENCES user_courses (id) ON DELETE CASCADE,
    FOREIGN KEY (section_id) REFERENCES course_sections (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS quiz_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_text TEXT NOT NULL,
    option_1 VARCHAR(255) NOT NULL,
    option_2 VARCHAR(255) NOT NULL,
    option_3 VARCHAR(255) NOT NULL,
    option_4 VARCHAR(255) NOT NULL,
    correct_option INT NOT NULL
);

CREATE TABLE assignment_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(255) NOT NULL,
    assignment_name VARCHAR(255) NOT NULL,
    submitted_file VARCHAR(255) NOT NULL,  -- Column to store the uploaded file path or name
    submission_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE assignments (
    id INT(11) NOT NULL AUTO_INCREMENT, -- Assignment ID
    assignment_name VARCHAR(255) NOT NULL, -- Assignment Name
    instructor_name VARCHAR(255) NOT NULL, -- Instructor Name
    file_name VARCHAR(255) NOT NULL, -- Uploaded file name
    due_date DATE NOT NULL, -- Due Date
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of when the assignment was uploaded
    PRIMARY KEY (id) -- Primary Key
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `quiz_results` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `student_id` INT NOT NULL,
    `score` DECIMAL(5, 2) NOT NULL,
    `submission_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE student_scores (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- Unique identifier for each entry
    student_name VARCHAR(100) NOT NULL,        -- Name of the student
    score INT NOT NULL,                        -- Score of the student
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp of record creation
);


-- Insert data for user types
INSERT INTO usertypes (ID, Name) VALUES
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
(1, 'Admin'),
(2, 'Instructor'),
(3, 'Student');

-- Insert initial pages data
<<<<<<< HEAD
INSERT INTO `pages` (`FriendlyName`, `LinkAddress`) VALUES
=======
INSERT INTO pages (FriendlyName, LinkAddress) VALUES
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
('Admin', 'admin.php'),      -- Accessible by Admin
('Home', 'home.php'),        -- Accessible by all users
('Logout', 'logout.php'),    -- Accessible by all users
('Courses', 'home-course.php'), -- Accessible by Instructors
('Dashboard', 'dashboard.php'); -- Accessible by all roles

-- Insert user types and pages associations with ENUM UserType
<<<<<<< HEAD
INSERT INTO `usertype_pages` (`UserType`, `PageID`) VALUES
=======
INSERT INTO usertype_pages (UserType, PageID) VALUES
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
('Admin', 2),  -- Admin can access Home
('Admin', 1),  -- Admin can access Admin Page
('Admin', 5),  -- Admin can access Dashboard
('Admin', 3),  -- Admin can access Logout

('Instructor', 2),  -- Instructor can access Home
('Instructor', 4),  -- Instructor can access Home Course
('Instructor', 5),  -- Instructor can access Dashboard
('Instructor', 3),  -- Instructor can access Logout

('Student', 2),  -- Student can access Home
('Student', 4),  -- Student can access Home Course
('Student', 5),  -- Student can access Dashboard
<<<<<<< HEAD
('Student', 3);  -- Student can access Logout
=======
('Student', 3);  -- Student can access Logout
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff

COMMIT;
