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
$roll = $_POST['roll'];
$name = $_POST['name'];
$password = $_POST['password'];

// Check if the input fields are not empty
if (empty($roll) || empty($name) || empty($password)) {
    die("Please fill in all fields.");
}

// Prepare the query to fetch the hashed password
$sql_query = "SELECT Password FROM student_login WHERE RollNo = ? AND Name = ?";
$stmt = $conn->prepare($sql_query);
$stmt->bind_param("ss", $roll, $name);
$stmt->execute();
$stmt->store_result();

// Check if a record was found
if ($stmt->num_rows > 0) {
    // Bind the result to a variable and fetch it
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Debugging: Display fetched hashed password
    echo "Stored hashed password: " . htmlspecialchars($hashed_password) . "<br>";
    echo "Input password: " . htmlspecialchars($password) . "<br>";

    // Verify the password using password_verify()
    if (password_verify($password, $hashed_password)) {
        // Password is correct, proceed with checking the students table
        $_SESSION['roll'] = $roll;
        $_SESSION['name'] = $name;

        // Check if the student exists in the students table
        $sql_query1 = "SELECT COUNT(*) as total_rows FROM students WHERE Roll = ?";
        $stmt1 = $conn->prepare($sql_query1);
        $stmt1->bind_param("s", $roll);
        $stmt1->execute();
        $stmt1->bind_result($count1);
        $stmt1->fetch();

        // Redirect based on the presence in the students table
        if ($count1 > 0) {
            header("Location: student_profile.php");
        } else {
            header("Location: student_data.html");
        }
        exit();
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "Account credentials not registered.";
}

// Close the prepared statements and the connection
$stmt->close();
$conn->close();
?>
