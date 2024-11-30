<?php
// Start the session and check if the user is logged in
session_start(); 

if (!isset($_SESSION['CompanyID'])) {
    header("Location: login.php");
    exit();
}

$companyID = $_SESSION['CompanyID'];
$companyName = $_SESSION['CompanyName'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "Placementdata";

$conn = mysqli_connect($servername, $username, $password, $database_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql_query = "SELECT * FROM test WHERE CompanyID = '$companyID'";
$result = mysqli_query($conn, $sql_query);

echo "<h1>Scheduled Tests by " . htmlspecialchars($companyName) . "</h1>";

if ($result && mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr>
            <th>JobID</th>
            <th>CompanyID</th>
            <th>Type</th>
            <th>Date</th>
            <th>Mode</th>
            <th>Duration</th>
            <th>Results</th>
            <th>Cutoff</th>
          </tr>";

    while ($test = mysqli_fetch_assoc($result)) {
        $jobID = $test['JObID'];
        $testType = $test['Type'];

        $performance_query = "SELECT * FROM test_performance WHERE CompanyID = '$companyID' AND JobID = '$jobID' ";
        $performance_result = mysqli_query($conn, $performance_query);

        $cutoff_query = "SELECT cutoff FROM cutoff WHERE CompanyID = '$companyID' AND JobID = '$jobID' AND type = '$testType'";
        $cutoff_result = mysqli_query($conn, $cutoff_query);
        $cutoff_row = mysqli_fetch_assoc($cutoff_result);
        $cutoff_set = isset($cutoff_row['cutoff']);

        echo "<tr>
                <td>" . htmlspecialchars($jobID) . "</td>
                <td>" . htmlspecialchars($test['CompanyID']) . "</td>
                <td>" . htmlspecialchars($testType) . "</td>
                <td>" . htmlspecialchars($test['Date']) . "</td>
                <td>" . htmlspecialchars($test['Mode']) . "</td>
                <td>" . htmlspecialchars($test['Duration']) . "</td>
                <td>";

        // Updated link to include test_type
        if ($performance_result && mysqli_num_rows($performance_result) > 0) {
            echo "<a href='test_results.php?job_id=" . urlencode($jobID) . 
                 "&company_id=" . urlencode($companyID) . 
                 "&test_type=" . urlencode($testType) . "'>View Results</a>";
        } else {
            echo "Results Awaiting";
        }

        echo "</td><td>";

        // Updated link to include test_type for the cutoff
        if ($cutoff_set) {
            echo "<a href='view_shortlist.php?job_id=" . urlencode($jobID) . 
                 "&company_id=" . urlencode($companyID) . 
                 "&test_type=" . urlencode($testType) . "'>View Shortlist</a>";
        } else {
            echo "<a href='set_cutoff.php?job_id=" . urlencode($jobID) . 
                 "&company_id=" . urlencode($companyID) . 
                 "&test_type=" . urlencode($testType) . "'>Set Cutoff</a>";
        }

        echo "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No tests found for this company.";
}

mysqli_close($conn);
?>
<p><a href="recruiter_profile.php" class="back-link">Back to Profile</a></p>

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
    .back-link {
        display: inline-block;
        margin: 10px 0;
        padding: 10px 15px;
        background-color: #ffcc80;
        color: #333;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .back-link:hover {
        background-color: #e68a00;
        color: #fff;
    }
</style>
