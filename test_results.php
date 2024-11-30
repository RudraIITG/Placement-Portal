<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['CompanyID'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

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

// Retrieve JobID, CompanyID, and test_type from query parameters
$jobID = $_GET['job_id'];
$companyID = $_GET['company_id'];
$type = $_GET['test_type']; // test_type added

// Prepare the SQL query with placeholders
$query = "SELECT tp.RollNO, tp.Score, s.Name, s.Branch, s.CPI, s.Degree
          FROM test_performance tp
          JOIN students s ON tp.RollNO = s.Roll
          WHERE tp.CompanyID = ? AND tp.JobID = ? AND tp.type = ?"; // Added the condition for test_type

// Prepare the statement
$stmt = mysqli_prepare($conn, $query);

// Bind parameters to the prepared statement
mysqli_stmt_bind_param($stmt, "iis", $companyID, $jobID, $type); // 'i' for integers, 's' for string

// Execute the prepared statement
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Display test information
echo "<h1 style='color: #e68a00; text-align: center; font-size: 24px; margin-top: 20px;'>
        Test Results for Job ID: " . htmlspecialchars($jobID) . " (Test Type: " . htmlspecialchars($type) . ")
      </h1>";

// Check if the query was successful and has results
if ($result && mysqli_num_rows($result) > 0) {
    echo "<table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>
            <tr style='background-color: #ffcc80; color: #333;'>
                <th style='padding: 10px; border: 1px solid #e6b800;'>Roll Number</th>
                <th style='padding: 10px; border: 1px solid #e6b800;'>Name</th>
                <th style='padding: 10px; border: 1px solid #e6b800;'>Branch</th>
                <th style='padding: 10px; border: 1px solid #e6b800;'>CPI</th>
                <th style='padding: 10px; border: 1px solid #e6b800;'>Degree</th>
                <th style='padding: 10px; border: 1px solid #e6b800;'>Score</th>
            </tr>";

    // Fetch and display the results as table rows
    while ($performance = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td style='padding: 10px; border: 1px solid #e6b800;'>" . htmlspecialchars($performance['RollNO']) . "</td>
                <td style='padding: 10px; border: 1px solid #e6b800;'>" . htmlspecialchars($performance['Name']) . "</td>
                <td style='padding: 10px; border: 1px solid #e6b800;'>" . htmlspecialchars($performance['Branch']) . "</td>
                <td style='padding: 10px; border: 1px solid #e6b800;'>" . htmlspecialchars($performance['CPI']) . "</td>
                <td style='padding: 10px; border: 1px solid #e6b800;'>" . htmlspecialchars($performance['Degree']) . "</td>
                <td style='padding: 10px; border: 1px solid #e6b800;'>" . htmlspecialchars($performance['Score']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: #e68a00; text-align: center; margin-top: 20px;'>No students have taken this test yet.</p>";
}

// Close the connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!-- Back link with inline CSS -->
<p style='text-align: center; margin-top: 30px;'>
    <a href='view_test_results.php' style='background-color: #ffcc80; color: #333; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block;'>
        &larr; Back to Test List
    </a>
</p>
