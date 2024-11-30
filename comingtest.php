<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Tests</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #0072ff, #00c6ff);
            color: #333;
            display: flex;
            min-height: 100vh;
        }
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
        .main-content {
            margin-left: 270px;
            padding: 20px;
            flex: 1;
        }
        h1 {
            margin: 20px 0;
            text-align: center;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
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
    <h1>Upcoming Tests</h1>

    <?php
    session_start(); // Start the session

    // Check if session data is set
    if (isset($_SESSION['roll']) && isset($_SESSION['name'])) {
        $roll = $_SESSION['roll'];
        $name = $_SESSION['name'];

        echo "<p><strong>Student Roll:</strong> " . htmlspecialchars($roll) . "</p>";
        echo "<p><strong>Student Name:</strong> " . htmlspecialchars($name) . "</p>";

        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database_name = "Placementdata";

        $conn = mysqli_connect($servername, $username, $password, $database_name);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Prepare and execute the SQL query
        $sql_query = "
            SELECT t.*, j.Position, c.CompanyID, 
                   (SELECT COUNT(*) FROM shortlists s WHERE s.CompanyID = c.CompanyID AND s.RollNO = '$roll') AS is_shortlisted
            FROM test AS t
            JOIN apply AS a ON t.JObID = a.JobID
            JOIN jobs AS j ON a.JobID = j.JobID
            JOIN company_login AS c ON j.CompanyID = c.CompanyID
            WHERE a.Roll = '$roll'
        ";

        $result = mysqli_query($conn, $sql_query);

        if ($result && mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr>
                    <th>Job ID</th>
                    <th>CompanyID</th>
                    <th>Position</th>
                    <th>Date</th>
                    <th>Duration (minutes)</th>
                    <th>Type</th>
                    <th>Mode</th>
                    <th>Status</th>
                  </tr>";

            while ($test = mysqli_fetch_assoc($result)) {
                $CompanyID = htmlspecialchars($test['CompanyID']);
                $job_id = htmlspecialchars($test['JObID']);
                $type = htmlspecialchars($test['Type']);
                
                $check_query = "SELECT Score FROM test_performance WHERE JobID = '$job_id' AND RollNO = '$roll' AND CompanyID = '$CompanyID' AND type = '$type'";
                $check_result = mysqli_query($conn, $check_query);
                $test_taken = mysqli_num_rows($check_result) > 0;

                $is_shortlisted = $test['is_shortlisted'] > 0;

                // Display based on test type and shortlist status
                if ($type == 'Aptitude' || ($type == 'Interview' && $is_shortlisted)) {
                    echo "<tr>
                            <td>" . $job_id . "</td>
                            <td>" . $CompanyID . "</td>
                            <td>" . htmlspecialchars($test['Position']) . "</td>
                            <td>" . htmlspecialchars($test['Date']) . "</td>
                            <td>" . htmlspecialchars($test['Duration']) . "</td>
                            <td>" . $type . "</td>
                            <td>" . htmlspecialchars($test['Mode']) . "</td>
                            <td>" . ($test_taken ? 'Test Given' : "<a href='mock_test.php?job_id=$job_id&CompanyID=$CompanyID&type=$type'>Attempt Test</a>") . "</td>
                          </tr>";
                }
            }
            echo "</table>";
        } else {
            echo "<p>No upcoming tests found.</p>";
        }

        mysqli_close($conn);
    } else {
        echo "<p>Session data not set. Please log in again.</p>";
    }
    ?>
</div>
</body>
</html>
