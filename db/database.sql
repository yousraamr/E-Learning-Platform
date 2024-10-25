-- Table structure for table `usertypes`
CREATE TABLE `usertypes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `pages`
CREATE TABLE `pages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FriendlyName` varchar(50) NOT NULL,
  `LinkAddress` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `users`
CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL UNIQUE, 
  `Password` varchar(255) NOT NULL, 
  `UserType_id` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserType_id` (`UserType_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`UserType_id`) REFERENCES `usertypes` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `usertype_pages`
CREATE TABLE `usertype_pages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserTypeID` int(11) NOT NULL,
  `PageID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserTypeID` (`UserTypeID`),
  KEY `PageID` (`PageID`),
  CONSTRAINT `usertype_pages_ibfk_1` FOREIGN KEY (`PageID`) REFERENCES `pages` (`ID`),
  CONSTRAINT `usertype_pages_ibfk_2` FOREIGN KEY (`UserTypeID`) REFERENCES `usertypes` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insert data for user types
INSERT INTO `usertypes` (`ID`, `Name`) VALUES
(1, 'Admin'),
(2, 'Instructor'),
(3, 'Student');

-- Insert initial pages data
INSERT INTO `pages` (`FriendlyName`, `LinkAddress`) VALUES
('Admin Page', 'admin.html'),      -- Accessible by Admin
('Home', 'home.html'),             -- Accessible by all users
('Instructor Page', 'instructor.php'), -- Accessible by Instructors
('Student Page', 'student.php'),   -- Accessible by Students
('Index', 'index.php'),            -- Accessible by Instructors and Students
('Register/Login', 'register_login.php'), -- Accessible by all users
('Logout', 'logout.php');           -- Accessible by all users

-- Insert user types and pages associations
INSERT INTO `usertype_pages` (`UserTypeID`, `PageID`) VALUES
(1, 1), -- Admin can access Admin Page
(1, 2), -- Admin can access Home
(2, 2), -- Instructor can access Home
(2, 3), -- Instructor can access Instructor Page
(3, 2), -- Student can access Home
(3, 4), -- Student can access Student Page
(2, 5), -- Instructor can access Index
(3, 5), -- Student can access Index
(1, 6), -- Admin can access Register/Login
(2, 6), -- Instructor can access Register/Login
(3, 6), -- Student can access Register/Login
(1, 7), -- Admin can access Logout
(2, 7), -- Instructor can access Logout
(3, 7); -- Student can access Logout

COMMIT;
 
