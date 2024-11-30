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
$CompanyID = $_POST['CompanyID'];
$name = $_POST['name'];
$password = $_POST['password'];

// Prepare the SQL query
$sql_query = "INSERT INTO company_login (CompanyID, CompanyName, Password) VALUES ('$CompanyID', '$name', '$password')";

// Execute the query
if (mysqli_query($conn, $sql_query)) 
    echo "Account credentials successfully registered";

else 
    echo "Error: " . mysqli_error($conn);
?>

</body>

</html>
