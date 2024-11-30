<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['CompanyID'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve company ID from the session
$companyID = $_SESSION['CompanyID'];

// Check if JobID is set in the URL
if (!isset($_GET['jobID'])) {
    echo "Job ID not specified.";
    exit();
}

$jobID = htmlspecialchars($_GET['jobID']);

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

// Check if a test has already been scheduled for this job
$check_test_query = "SELECT * FROM tests WHERE CompanyID = '$companyID' AND JobID = '$jobID'";
$check_result = mysqli_query($conn, $check_test_query);

if (mysqli_num_rows($check_result) > 0) {
    echo "A test has already been scheduled for this job.";
    // Optionally provide a link back to the job listings or a button to go back
    echo "<p><a href='tests.php'>Back to Offered Jobs</a></p>";
    mysqli_close($conn);
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $test_date = $_POST['test_date'];
    $duration = $_POST['duration'];
    $mode = $_POST['mode'];

    // Insert the new test into the database
    $insert_test_query = "INSERT INTO test (CompanyID, JobID, Type, Date, Duration, Mode) VALUES ('$companyID', '$jobID', '$type', '$test_date', '$duration', '$mode')";

    if (mysqli_query($conn, $insert_test_query)) {
        // Redirect to the recruiter profile page upon successful test scheduling
        header("Location: tests.php");
        exit(); // Stop further execution after redirection
    } else {
        echo "Error scheduling test: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}

 else {
    // Show the form for scheduling the test
    echo "<h1>Schedule Test for Job ID: $jobID</h1>";
    echo "<form method='POST' action=''>

            <label for='type'>Test Type:</label>
            <select id='type' name='type' required>
                <option value='' disabled selected>Select</option>
                <option value='Aptitude'>Aptitude/Technical Test</option>
                <option value='Interview'>Interview</option>
            </select><br>

            <label for='test_date'>Test Date:</label>
            <input type='date' name='test_date' required><br>

            <label for='duration'>Duration (in minutes):</label>
            <input type='number' name='duration' required><br>

            <label for='mode'>Test Mode:</label>
            <select id='mode' name='mode' required>
                <option value='' disabled selected>Select</option>
                <option value='Online'>Online</option>
                <option value='Offline'>Offline</option>
            </select><br>

            <input type='submit' value='Schedule Test' class='submit-btn'>
          </form>";
}

mysqli_close($conn);
?>

<!-- Link to return to the offered jobs page -->
<p><a href="tests.php" class="back-link">Back to Offered Jobs</a></p> 

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

    /* Form styling */
    form {
        background-color: #ffcc80; /* Light orange */
        padding: 20px;
        border-radius: 10px;
        width: 300px;
        margin: 20px auto;
    }

    form label {
        display: block;
        margin: 10px 0 5px;
    }

    form input, form select {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #e68a00;
        border-radius: 5px;
    }

    form input[type="submit"] {
        background-color: #e68a00;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    form input[type="submit"]:hover {
        background-color: #ffcc80;
        color: #333;
    }

    /* Link styling */
    a {
        color: #e68a00;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    /* Link for back button */
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
