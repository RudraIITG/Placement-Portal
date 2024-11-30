<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['CompanyID'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve `JobID` and `CompanyID` from query parameters
$jobID = $_GET['job_id'];
$companyID = $_GET['company_id'];
$test_type = $_GET['test_type'];

// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database_name = "Placementdata";

$conn = mysqli_connect($servername, $username, $password, $database_name);

// Fetch cutoff score
$cutoff_query = "SELECT cutoff FROM cutoff WHERE CompanyID = '$companyID' AND JobID = '$jobID'";
$cutoff_result = mysqli_query($conn, $cutoff_query);
$cutoff_row = mysqli_fetch_assoc($cutoff_result);
$cutoff_score = $cutoff_row['cutoff'] ?? 0;

// Fetch shortlisted candidates
$sql_query = "SELECT tp.RollNO, tp.Score, s.Name, s.Branch, s.CPI
              FROM test_performance tp
              JOIN students s ON tp.RollNO = s.Roll
              WHERE tp.CompanyID = '$companyID' AND tp.JobID = '$jobID' AND tp.Score >= '$cutoff_score' AND tp.type = '$test_type'";
$result = mysqli_query($conn, $sql_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortlisted Candidates</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">

<?php
echo "<h1 style='color: #007bff; text-align: center;'>Shortlisted Candidates for Job ID: " . htmlspecialchars($jobID) . "</h1>";

if ($result && mysqli_num_rows($result) > 0) {
    echo "<table border='1' style='width: 80%; margin: 20px auto; border-collapse: collapse;'>";
    echo "<tr style='background-color: #007bff; color: white;'>
            <th style='padding: 10px; text-align: left;'>Roll Number</th>
            <th style='padding: 10px; text-align: left;'>Name</th>
            <th style='padding: 10px; text-align: left;'>Branch</th>
            <th style='padding: 10px; text-align: left;'>CPI</th>
            <th style='padding: 10px; text-align: left;'>Score</th>
          </tr>";

    while ($candidate = mysqli_fetch_assoc($result)) {
        echo "<tr style='background-color: #e9ecef;'>
                <td style='padding: 10px;'>" . htmlspecialchars($candidate['RollNO']) . "</td>
                <td style='padding: 10px;'>" . htmlspecialchars($candidate['Name']) . "</td>
                <td style='padding: 10px;'>" . htmlspecialchars($candidate['Branch']) . "</td>
                <td style='padding: 10px;'>" . htmlspecialchars($candidate['CPI']) . "</td>
                <td style='padding: 10px;'>" . htmlspecialchars($candidate['Score']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align: center; color: #dc3545;'>No candidates qualified with the current cutoff score.</p>";
}

// Close the connection
mysqli_close($conn);
?>

<!-- Optionally, display a back link -->
<p style="text-align: center; margin-top: 20px;">
    <a href='view_test_results.php' style='color: #007bff; text-decoration: none;'>Back to Test List</a>
</p>

</body>
</html>
