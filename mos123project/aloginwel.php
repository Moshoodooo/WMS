<?php 
require_once ('process/dbh.php');
$sql = "SELECT id, firstName, lastName FROM employee, rank WHERE rank.eid = employee.id ORDER BY rank.points DESC";
$result = mysqli_query($conn, $sql);

// Calculate the total number of registered employees
$totalEmployees = mysqli_num_rows($result);
?>

<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styleemplogin.css">
    <style>
        /* Add custom styles for the total employees display */
        .total-employees {
            font-size: 24px;
            text-align: center;
            margin-top: 20px;
            color: #000; /* Black color */
            font-weight: bold;
        }
    </style>
</head>
<body>
    
    <header>
        <nav>
            <h1>Dashboard</h1>
            <ul id="navli">
                <li><a class="homered" href="aloginwel.php">HOME</a></li>
                <li><a class="homeblack" href="addemp.php">Add Employee</a></li>
                <li><a class="homeblack" href="viewemp.php">View Employee</a></li>
                <li><a class="homeblack" href="assign.php">Assign Project</a></li>
                <li><a class="homeblack" href="assignproject.php">Project Status</a></li>
                <li><a class="homeblack" href="salaryemp.php">Salary Table</a></li>
                <li><a class="homeblack" href="empleave.php">Employee Leave</a></li>
                <li><a class="homeblack" href="alogin.html">Log Out</a></li>
            </ul>
        </nav>
    </header>
     
    <div class="divider"></div>
    <div id="divimg">
    <h2 style="font-family: 'Montserrat', sans-serif; font-size: 20px; text-align: left;">Welcome Admin </h2>    
    <h2 style="font-family: 'Montserrat', sans-serif; font-size: 25px; text-align: center;">All Employees </h2>
        <table>

            <tr bgcolor="#000">
                <th align="center">S/N</th>
                <th align="center">Emp. ID</th>
                <th align="center">Name</th>
            </tr>

            <?php
                $seq = 1;
                while ($employee = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$seq."</td>";
                    echo "<td>".$employee['id']."</td>";
                    echo "<td>".$employee['firstName']." ".$employee['lastName']."</td>";
                    echo "</tr>";
                    $seq += 1;
                }
            ?>

        </table>

        <!-- Black color for total employees display -->
        <p class="total-employees">Total Employees: <?php echo $totalEmployees; ?></p>
        
    </div>
</body>
</html>
