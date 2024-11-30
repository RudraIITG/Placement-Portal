<?php
session_start(); // Start the session

if (!isset($_SESSION['roll']) || !isset($_GET['job_id']) || !isset($_GET['CompanyID'])) {
    echo "<p>Session data not set. Please log in again.</p>";
    exit; // Stop the script if session data is not set
}

// Store job_id in the session
$_SESSION['job_id'] = $_GET['job_id'];
$_SESSION['CompanyID'] = $_GET['CompanyID'];
$_SESSION['type']  = $_GET['type'];
echo "$type";

// Redirect to the first section (Statistics)
header('Location: submit_test.php?section=Statistics');
exit;
?>
