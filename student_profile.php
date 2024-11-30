<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            background: linear-gradient(to right, #0072ff, #00c6ff);
            color: #333;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.3);
            position: fixed;
            height: 100%;
            overflow-y: auto;
            border-radius: 10px;
        }

        /* Blinking Animation */
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* Sidebar Links */
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #0072ff;
        }

        .sidebar a {
            display: block;
            padding: 10px 15px;
            margin: 10px 0;
            color: #0072ff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
            font-weight: bold;
        }

        .sidebar a:hover {
            background-color: rgba(0, 114, 255, 0.2);
        }

        /* Main Content */
        .main-content {
            margin-left: 270px; /* To create space for sidebar */
            padding: 20px;
            flex: 1;
        }

        /* Header Styling */
        h1 {
            margin: 20px 0;
            text-align: center;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* Container for Student Info */
        .student-info {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            width: 20%;
            max-width: 600px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        /* Profile Image Styling */
        .profile-image {
            
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin: 20px 0;
        }

        /* Selected Message */
        .selected-message {
            font-size: 3em;
            color: red;
            animation: blink 2s infinite;
            text-align: center;
            margin: 20px 0;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #0072ff;
            color: #fff;
        }

        tr:hover {
            background-color: rgba(0, 114, 255, 0.1);
        }
    </style>
</head>
<body>

<?php
session_start();

if (isset($_SESSION['roll']) && isset($_SESSION['name']) ) {
    $roll = $_SESSION['roll'];
    $name = $_SESSION['name'];
?>
    <div class="sidebar">
        <h2>Navigation</h2>
        <a href="apply.php"><i class="fas fa-briefcase"></i> Apply for Companies</a>
        <a href="companylist.php"><i class="fas fa-building"></i> List of All Companies</a>
        <a href="applied.php"><i class="fas fa-paper-plane"></i> My Applications</a>
        <a href="comingtest.php"><i class="fas fa-calendar-alt"></i> Upcoming Tests</a>
        <a href="placement_coordinators.php"><i class="fas fa-user-tie"></i> Placement Coordinators</a>
        <a href="index1.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content">
        <h1>List of Eligible Companies</h1>

        <!-- Display student information -->
        <div class="student-info">
            <p><strong>Student Roll:</strong> <?php echo htmlspecialchars($roll); ?></p>
            <p><strong>Student Name:</strong> <?php echo htmlspecialchars($name); ?></p>

            <?php
            // Database connection
            $conn = mysqli_connect("localhost", "root", "", "Placementdata");

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch student image path from the database
            $image_query = "SELECT profile_image FROM students WHERE Roll = '$roll'";
            $image_result = mysqli_query($conn, $image_query);
            $image_path = null;

            if ($image_result && mysqli_num_rows($image_result) > 0) {
                $image_row = mysqli_fetch_assoc($image_result);
                $image_path = $image_row['profile_image'];
            }

            // Display the image if it exists, else show upload form
            if ($image_path && file_exists($image_path)) {
                echo "<img src='" . htmlspecialchars($image_path) . "' alt='Profile Image' class='profile-image'>";
            } else {
                echo "<form action='upload_image.php' method='post' enctype='multipart/form-data'>
                        <label for='profile_image'>Upload Profile Image:</label>
                        <input type='file' name='profile_image' accept='image/*' required>
                        <input type='submit' value='Upload Image'>
                      </form>";
            }
            ?>
        </div>

        <?php
         $selection_query = "
         SELECT j.CompanyName, j.Position 
         FROM selections s
         JOIN jobs j ON s.CompanyID = j.CompanyID AND s.JobID = j.JobID
         WHERE s.RollNo = '$roll'
     ";
     $selection_result = mysqli_query($conn, $selection_query);

     // Check if the student is selected
     if ($selection_result && mysqli_num_rows($selection_result) > 0) {
         $selection_row = mysqli_fetch_assoc($selection_result);
         $company_name = $selection_row['CompanyName'];
         $position = $selection_row['Position'];

         // Display selected message
         echo "<p class='selected-message'>Congratulations! <strong>"  . htmlspecialchars(string: $name) . " you got selected for the position of <strong>" . htmlspecialchars($position) . "</strong> at <strong>" . htmlspecialchars($company_name) . ". <br> You are out of the placement process now.</strong></p>";
     } else {
         // Prepare and execute the first SQL query for CPI
         $sql_query = "SELECT cpi, Backlogs FROM students WHERE Roll = '$roll'";
         $result = mysqli_query($conn, $sql_query);

         // Check if the first query was successful and has results
         if ($result && mysqli_num_rows($result) > 0) {
             $row = mysqli_fetch_assoc($result);
             $cpi = $row['cpi'];
             $backlogs = $row['Backlogs'];
             $_SESSION['cpi'] = $cpi;
             $_SESSION['backlogs'] = $backlogs;

             // Prepare and execute the second SQL query for jobs
             $sql_query1 = "SELECT * FROM jobs WHERE MinCPI <= '$cpi' and ((Allow_Backlogs = 'YES') or (Allow_Backlogs = '$backlogs')) ";
             $result1 = mysqli_query($conn, $sql_query1);

             // Check if the second query was successful and has results
             if ($result1 && mysqli_num_rows($result1) > 0) {
                 echo "<table>";
                 echo "<tr>
                         <th>CompanyName</th>
                         <th>Position</th>
                         <th>JobDescription</th>
                         <th>Salary</th>
                         <th>MinCPI</th>
                       </tr>";

                 // Fetch and display the results as table rows
                 while ($job = mysqli_fetch_assoc($result1)) {
                     echo "<tr>
                             <td>" . htmlspecialchars($job['CompanyName']) . "</td>
                             <td>" . htmlspecialchars($job['Position']) . "</td>
                             <td>" . htmlspecialchars($job['JobDescription']) . "</td>
                             <td>" . htmlspecialchars($job['Salary']) . "</td>
                             <td>" . htmlspecialchars($job['MinCPI']) . "</td>
                           </tr>";
                 }
                 echo "</table>";
             } else {
                 echo "<p>No job matches found.</p>";
             }
         } else {
             echo "<p>CPI not found for the given roll number.</p>";
         }
     }

     // Close the connection
     mysqli_close($conn);
 } else {
     echo "<p>Session data not set. Please log in again.</p>";
 }
        ?>

    </div>
</body>
</html>
<?php

?>
