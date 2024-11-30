<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['CompanyID'])) {
    header("Location: login.php");
    exit();
}

// Retrieve `JobID`, `CompanyID`, and `test_type` from query parameters
$jobID = $_GET['job_id'];
$companyID = $_GET['company_id'];
$testType = isset($_GET['test_type']) ? strtolower($_GET['test_type']) : '';

if (empty($testType)) {
    die("Test type not specified.");
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

// Function to process qualified students
function processQualifiedStudents($conn, $companyID, $jobID, $cutoff, $testType) {
    $qualifiedStudentsQuery = "
        SELECT RollNO FROM test_performance 
        WHERE CompanyID = '$companyID' 
        AND JobID = '$jobID' 
        AND Score >= '$cutoff'
    ";
    $qualifiedResult = mysqli_query($conn, $qualifiedStudentsQuery);

    if (mysqli_num_rows($qualifiedResult) > 0) {
        while ($row = mysqli_fetch_assoc($qualifiedResult)) {
            $rollNo = $row['RollNO'];
            $table = ($testType === 'interview') ? 'selections' : 'shortlists';
            $insertQuery = "INSERT IGNORE INTO $table (CompanyID, JobID, RollNO) VALUES ('$companyID', '$jobID', '$rollNo')";
            mysqli_query($conn, $insertQuery);
        }
        echo "Qualified students added to " . ($testType === 'interview' ? 'selections' : 'shortlists') . " table.<br>";
    } else {
        echo "No students qualified.<br>";
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cutoff = $_POST['cutoff'];

    // Insert or update the cutoff in the database
    $sql = "INSERT INTO cutoff (CompanyID, JobID, cutoff, type) VALUES ('$companyID', '$jobID', '$cutoff', '$testType')
            ON DUPLICATE KEY UPDATE cutoff = '$cutoff'";

    if (mysqli_query($conn, $sql)) {
        processQualifiedStudents($conn, $companyID, $jobID, $cutoff, $testType);
        // Redirect to tests.php after successful cutoff setting
        header("Location: tests.php");
        exit();
    } else {
        echo "Error setting cutoff: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Set Cutoff Score</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 400px;
            text-align: center;
        }

        h1 {
            color: #4caf50;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 18px;
            color: #333;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .success-message {
            color: #28a745;
            font-weight: bold;
            margin-top: 15px;
        }

        .error-message {
            color: #dc3545;
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Set Cutoff Score for Job ID: <?php echo htmlspecialchars($jobID); ?></h1>
        <form action="" method="POST">
            <label for="cutoff">Minimum Score to Qualify:</label>
            <input type="number" name="cutoff" id="cutoff" min="0" max="100" required>
            <button type="submit">Set Cutoff</button>
        </form>
    </div>
</body>
</html>
