<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offered Jobs and Scheduled Tests</title>

    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #fff7e6; /* Light orange background */
            color: #333;
            margin: 0;
            padding: 20px;
        }

        /* Heading styling */
        h1 {
            color: #e68a00; /* Darker shade of orange */
            text-align: center;
            font-size: 24px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #e6b800; /* Light orange border */
        }

        th {
            background-color: #ffcc80; /* Light orange */
            color: #333;
            padding: 10px;
            font-size: 16px;
            text-align: left;
        }

        td {
            padding: 10px;
            text-align: left;
        }

        /* Link styling */
        a {
            color: #e68a00;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Additional buttons and links */
        p a {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 15px;
            background-color: #ffcc80;
            color: #333;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        p a:hover {
            background-color: #e68a00;
            color: #fff;
        }
    </style>

</head>
<body>

<div class="main-content">
<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['CompanyID'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve company ID from the session
$companyID = $_SESSION['CompanyID'];

// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database_name = "Placementdata";

$conn = mysqli_connect($servername, $username, $password, $database_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch jobs offered by the company
$sql_query = "SELECT j.JobID, j.Position, j.JobDescription
              FROM jobs j 
              WHERE j.CompanyID = $companyID";

$result = mysqli_query($conn, $sql_query);

// Display jobs and scheduled tests
echo "<h1>Offered Jobs and Scheduled Tests</h1>";

if ($result && mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr>
            <th>Job ID</th>
            <th>Position</th>
            <th>Job Description</th>
            <th>Action</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $jobID = htmlspecialchars($row['JobID']);
        $position = htmlspecialchars($row['Position']);
        $jobDescription = htmlspecialchars($row['JobDescription']);

        echo "<tr>
                <td>$jobID</td>
                <td>$position</td>
                <td>$jobDescription</td>
                <td>";

        // Check how many tests are already scheduled for this job
        $test_count_query = "SELECT COUNT(*) AS test_count FROM test 
                             WHERE CompanyID = $companyID AND JobID = $jobID";
        $count_result = mysqli_query($conn, $test_count_query);
        $count_row = mysqli_fetch_assoc($count_result);
        $testCount = $count_row['test_count'];

        // If less than 2 tests are scheduled, allow scheduling more
        if ($testCount < 2) {
            echo "<a href='schedule_test.php?jobID=$jobID'>Schedule Test</a>";
        } else {
            echo "<p>Tests Scheduled:</p>";

            // Fetch and display the already scheduled tests
            $scheduled_tests_query = "SELECT type, date 
                                      FROM test 
                                      WHERE CompanyID = $companyID AND JobID = $jobID";
            $scheduled_tests_result = mysqli_query($conn, $scheduled_tests_query);

            echo "<ul>";
            while ($test_row = mysqli_fetch_assoc($scheduled_tests_result)) {
                $testType = htmlspecialchars($test_row['type']);
                $testDate = htmlspecialchars($test_row['date']);
                echo "<li>$testType on $testDate</li>";
            }
            echo "</ul>";
        }
        echo "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No jobs found.</p>";
}

// Close the connection
mysqli_close($conn);
?>

<!-- Optionally, display navigation links -->
<p><a href="offer_jobs.html">Recruit for more roles</a></p>
<p><a href="tests.php">Schedule Tests/Interviews</a></p>
<p><a href="view_test_results.php">View test results</a></p>
<p><a href="logout.php">Logout</a></p>