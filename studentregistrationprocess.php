<html>
<head>

</head>
<body>
<?php
$servername = "localhost";
$username  = "root";
$password = "";
$database_name = "Placementdata";

// Establish connection
$conn = mysqli_connect($servername, $username, $password, $database_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else
    echo "connected";


// Get the data from the form
$roll = $_POST['roll'];
$name = $_POST['name'];
$password = $_POST['password'];

// Check if inputs are not empty
if (empty($roll) || empty($name) || empty($password)) {
    die("Please fill in all fields.");
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Prepare the SQL query with placeholders
$sql_query = "INSERT INTO student_login (RollNo, Name, Password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql_query);

// Check if preparation was successful
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind the parameters to the query
$stmt->bind_param("sss", $roll, $name, $hashed_password);

// Execute the query
if ($stmt->execute()) {
    echo "Account credentials successfully registered.";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
<p><a href="student_login.html">Back to Login</a></p>
<br>
</body>
</html>
