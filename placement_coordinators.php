<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placement Coordinators</title>
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
    <h1>Placement Coordinators</h1>

    <?php
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database_name = "Placementdata"; // Change this to your database name

    // Establish connection
    $conn = mysqli_connect($servername, $username, $password, $database_name);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute the SQL query to fetch data
    $sql_query = "SELECT PC_ID, Role, Roll, Phone, Name FROM placement_coordinator"; // Replace 'your_table_name' with the actual table name
    $result = mysqli_query($conn, $sql_query);

    // Check if the query was successful and has results
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>
                <th>PC ID</th>
                <th>Role</th>
                <th>Roll</th>
                <th>Phone</th>
                <th>Name</th>
              </tr>";

        // Fetch and display the results as table rows
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['PC_ID']) . "</td>
                    <td>" . htmlspecialchars($row['Role']) . "</td>
                    <td>" . htmlspecialchars($row['Roll']) . "</td>
                    <td>" . htmlspecialchars($row['Phone']) . "</td>
                    <td>" . htmlspecialchars($row['Name']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No records found.</p>";
    }

    // Close the connection
    mysqli_close($conn);
    ?>

</div>
</body>
</html>
