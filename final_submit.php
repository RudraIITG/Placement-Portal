<?php
session_start(); // Start the session

if (!isset($_SESSION['roll']) || !isset($_SESSION['answers'])) {
    header("Location: index1.php"); // Redirect to login if session data is missing
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "Placementdata";

$conn = new mysqli($servername, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve job_id, CompanyID, and roll number from session
$CompanyID = $_SESSION['CompanyID'];
$job_id = $_SESSION['job_id'];
$type = $_SESSION['type'];
$roll_no = $_SESSION['roll'];

// Correct answers for all questions
$correct_answers = [
    // Statistics Answers
    'B', 'A', 'C', 'A', 'C', 'A', 'B', 'C', 'A', 'A', // Statistics
    // Machine Learning Answers
    'A', 'A', 'C', 'A', 'C', 'A', 'B', 'C', 'A', 'B', // Machine Learning
    // Data Structures and Algorithms Answers
    'A', 'B', 'C', 'A', 'A', 'B', 'C', 'A', 'B', 'C'  // DSA
];

// Calculate total score
$answers = $_SESSION['answers'];
$score = 0;
foreach ($answers as $sectionAnswers) {
    foreach ($sectionAnswers as $index => $answer) {
        if (isset($correct_answers[$index]) && $answer == $correct_answers[$index]) {
            $score++;
        }
    }
}

// Update test performance in the database
$stmt = $conn->prepare("INSERT INTO test_performance (JobID, CompanyID, RollNO, type, Score) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iiisi", $job_id, $CompanyID, $roll_no, $type, $score);

if ($stmt->execute()) {
    // Clear session answers after submission
    unset($_SESSION['answers']);
    
    // Redirect to the student profile page
    header("Location: student_profile.php");
    exit;
} else {
    // If there's an error, redirect to profile page as well
    header("Location: student_profile.php");
    exit;
}

// Close the database connection
$stmt->close();
$conn->close();
?>
