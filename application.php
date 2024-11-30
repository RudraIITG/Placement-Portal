<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application for Job</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #0072ff, #00c6ff);
            color: #333;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.3);
            position: fixed;
            height: 100%;
            overflow-y: auto;
            border-radius: 10px;
        }

        /* Sidebar Links */
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #0072ff;
        }

        .sidebar a {
            display: block;
            padding: 10px 15px;
            margin: 10px 0;
            color: #0072ff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
            font-weight: bold;
        }

        .sidebar a:hover {
            background-color: rgba(0, 114, 255, 0.2);
        }

        /* Main Content */
        .main-content {
            margin-left: 270px; /* To create space for sidebar */
            padding: 20px;
            flex: 1;
        }

        /* Header Styling */
        h1 {
            margin: 20px 0;
            text-align: center;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        h2 {
            color: #0072ff;
            margin-bottom: 10px;
        }

        /* Job Details Styling */
        p {
            font-size: 1.1em;
            margin: 5px 0;
        }

        /* Button Styles */
        a.back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #0072ff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        a.back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Navigation</h2>
    <a href="apply.php"><i class="fas fa-briefcase"></i> Apply for Companies</a>
    <a href="companylist.php"><i class="fas fa-building"></i> List of All Companies</a>
    <a href="applied.php"><i class="fas fa-paper-plane"></i> My Applications</a>
    <a href="comingtest.php"><i class="fas fa-calendar-alt"></i> Upcoming Tests</a>
    <a href="placement_coordinators.php"><i class="fas fa-user-tie"></i> Placement Coordinators</a>
    <a href="index1.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <h1>Application for Job</h1>

    <?php
    session_start(); // Start the session

    // Check if session data is set
    if (isset($_SESSION['roll']) && isset($_SESSION['name'])) {
        // Retrieve session variables
        $roll = $_SESSION['roll'];
        $name = $_SESSION['name'];

        // Display student information
        echo "<p><strong>Student Roll:</strong> " . htmlspecialchars($roll) . "</p>";
        echo "<p><strong>Student Name:</strong> " . htmlspecialchars($name) . "</p>";

        // Check if the job details are set in the URL
        if (isset($_GET['companyID']) && isset($_GET['JobID'])) {
            // Retrieve job details from URL parameters
            $companyID = htmlspecialchars($_GET['companyID']);
            $companyName = htmlspecialchars($_GET['companyName']);
            $position = htmlspecialchars($_GET['position']);
            $JobID = htmlspecialchars($_GET['JobID']);
            $jobDescription = htmlspecialchars($_GET['jobDescription']);
            $salary = htmlspecialchars($_GET['salary']);
            $minCPI = htmlspecialchars($_GET['minCPI']);

            // Display job details
            echo "<h2>Job Details</h2>";
            echo "<p><strong>Company ID:</strong> " . $companyID . "</p>";
            echo "<p><strong>Company Name:</strong> " . $companyName . "</p>";
            echo "<p><strong>Position:</strong> " . $position . "</p>";
            echo "<p><strong>Job ID:</strong> " . $JobID . "</p>";
            echo "<p><strong>Job Description:</strong> " . $jobDescription . "</p>";
            echo "<p><strong>Salary:</strong> " . $salary . "</p>";
            echo "<p><strong>Minimum CPI:</strong> " . $minCPI . "</p>";

            // Database connection parameters
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database_name = "Placementdata";

            // Establish connection
            $conn = mysqli_connect($servername, $username, $password, $database_name);

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Check if the student has already applied for this job
            $apply_check_query = "SELECT * FROM apply WHERE Roll = '$roll' AND JobID = '$JobID'";
            $apply_check_result = mysqli_query($conn, $apply_check_query);

            if ($apply_check_result && mysqli_num_rows($apply_check_result) > 0) {
                echo "<p>You have already applied for this job.</p>";
            } else {
                // Prepare and execute the SQL query to insert application
                $sql_query = "INSERT INTO apply (Roll, JobID, CompanyID, CompanyName, Position) VALUES ('$roll', '$JobID', '$companyID', '$companyName', '$position')";
                $result = mysqli_query($conn, $sql_query);

                if ($result) {
                    echo "<p>Application Successful!</p>";
                } else {
                    echo "<p>Application Failed: " . mysqli_error($conn) . "</p>";
                }
            }

            // Close the connection
            mysqli_close($conn);
        } else {
            echo "Job details not found.";
        }
    } else {
        echo "Session data not set. Please log in again.";
    }
    ?>

    <!-- Link to return to the list of eligible companies -->
    <a class="back-button" href="student_profile.php">Back to Eligible Companies</a>
</div>

</body>
</html>
