<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruiter Profile</title>
    <!-- Link to the CSS file -->
    <link rel="stylesheet" href="recruiter_profile.css">
</head>



<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['CompanyID'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve company information from session
$companyID = $_SESSION['CompanyID'];
$companyName = $_SESSION['CompanyName'];

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

// Prepare and execute the SQL query to fetch jobs offered by the company
$sql_query = "SELECT * FROM jobs WHERE CompanyID = '$companyID'";
$result = mysqli_query($conn, $sql_query);

// Display company information
echo "<h1>Jobs Offered by " . htmlspecialchars($companyName) . "</h1>";

// Check if the query was successful and has results
if ($result && mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr>
            <th>JobID</th>
            <th>Position</th>
            <th>Job Description</th>
            <th>Salary</th>
            <th>Min CPI</th>
          </tr>";

    // Fetch and display the results as table rows
    while ($job = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . htmlspecialchars($job['JobID']) . "</td>
                <td>" . htmlspecialchars($job['Position']) . "</td>
                <td>" . htmlspecialchars($job['JobDescription']) . "</td>
                <td>" . htmlspecialchars($job['Salary']) . "</td>
                <td>" . htmlspecialchars($job['MinCPI']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No jobs found for this company.";
}

// Close the connection
mysqli_close($conn);
?>

<!-- Optionally, display a logout link -->
<p><a href="offer_jobs.html">Recruit for more roles</a></p>
<p><a href="tests.php">Schedule Tests/Interviews</a></p>
<p><a href="view_test_results.php">View test results</a></p>
<p><a href="index1.php">Logout</a></p>
