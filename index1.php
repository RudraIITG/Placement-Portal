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

// Check if the form is submitted
if (isset($_POST['save'])) {
    // Get the name from the form
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Background Image */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('iitg.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            z-index: -1;
        }

        /* Overlay */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Dark overlay */
            z-index: 0;
        }

        /* Choice Container */
        .choice-container {
            position: relative;
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.8); /* Light background for readability */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 450px; /* Fixed width for consistent layout */
        }

        /* Heading Styles */
        h1 {
            margin-bottom: 20px;
            font-size: 2em;
            color: #0072ff;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        /* Form Styling */
        label {
            display: block;
            margin: 10px 0;
            font-size: 1.2em;
            color: #000; /* Darker color for labels */
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #0072ff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="choice-container">
        <h1>IIT Guwahati Placement Portal</h1>
        <h2>Select Your Role</h2>
        <form action="" method="POST">
            <label>
                <input type="radio" name="role" value="student" required>
                Student
            </label>
            <label>
                <input type="radio" name="role" value="recruiter" required>
                Recruiter
            </label>
            <button type="submit" name="save">Continue</button>
        </form>

        <?php
        // Redirect based on selected role
        if (isset($_POST['save'])) {
            $role = $_POST['role'];
            if ($role == 'student') {
                header("Location: student_login.html");
                exit();
            } elseif ($role == 'recruiter') {
                header("Location: company_login.html");
                exit();
            }
        }
        ?>
    </div>
</body>
</html>
