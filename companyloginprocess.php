<?php
session_start(); // Start the session

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

// Get the login details from the form
$companyID = $_POST['CompanyID'];
$name = $_POST['name'];
$password = $_POST['password'];

// Prepare the SQL query to check login credentials
$sql_query = "SELECT COUNT(*) as total_rows FROM company_login WHERE CompanyID = '$companyID' AND Password = '$password' AND CompanyName = '$name'";
$result = mysqli_query($conn, $sql_query);

// Prepare another query to check if the company exists
$sql_query1 = "SELECT COUNT(*) as total_rows FROM jobs WHERE CompanyID = '$companyID'";
$result1 = mysqli_query($conn, $sql_query1);

// Execute the login check query
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $count = $row['total_rows'];
    
    // Execute the company check query
    if ($result1) {
        $row1 = mysqli_fetch_assoc($result1);
        $count1 = $row1['total_rows'];

        if ($count != 0) {
            // Store relevant company details in session variables
            $_SESSION['CompanyID'] = $companyID; // Store company ID
            $_SESSION['CompanyName'] = $name; // Store company name

            // Check if the company exists
            if ($count1 != 0) {
                header("Location: recruiter_profile.php");
                exit(); // Ensure no further code is executed after the redirect
            } else {
                header("Location: offer_jobs.html");
                exit();
            }
        } else {
            echo "Account credentials not registered";
        }
    } else {
        echo "Error checking company existence: " . mysqli_error($conn);
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>
