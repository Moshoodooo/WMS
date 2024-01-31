<?php
require_once('process/dbh.php');

// Check if a delete request is made
if (isset($_GET['delete_project']) && is_numeric($_GET['delete_project'])) {
    $deleteProjectId = $_GET['delete_project'];
    $deleteSql = "DELETE FROM `project` WHERE `pid` = $deleteProjectId";
    mysqli_query($conn, $deleteSql);
    header("Location: assignproject.php"); // Redirect to refresh the page after deletion
    exit();
}

$sql = "SELECT * FROM `project` ORDER BY subdate DESC";
$result = mysqli_query($conn, $sql);

// Counters for total due and total submitted projects
$totalDueProjects = 0;
$submittedProjects = 0;

?>

<html>
<head>
    <title>Admin - Project Status</title>
    <link rel="stylesheet" type="text/css" href="styleview.css">
    <script>
        function confirmDelete(projectId) {
            var confirmDelete = confirm("Are you sure you want to delete this project?");
            if (confirmDelete) {
                window.location.href = 'assignproject.php?delete_project=' + projectId;
            }
        }
    </script>
</head>
<body>
    <header>
        <nav>
            <h1>Project Status Overview</h1>
            <ul id="navli">
                <li><a class="homeblack" href="aloginwel.php">HOME</a></li>
                <li><a class="homeblack" href="addemp.php">Add Employee</a></li>
                <li><a class="homeblack" href="viewemp.php">View Employee</a></li>
                <li><a class="homeblack" href="assign.php">Assign Project</a></li>
                <li><a class="homered" href="assignproject.php">Project Status</a></li>
                <li><a class="homeblack" href="salaryemp.php">Salary Table</a></li>
                <li><a class="homeblack" href="empleave.php">Employee Leave</a></li>
                <li><a class="homeblack" href="alogin.html">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <div class="divider"></div>

    <table>
        <tr>
            <th align="center">Project ID</th>
            <th align="center">Emp. ID</th>
            <th align="center">Project Name</th>
            <th align="center">Due Date</th>
            <th align="center">Submission Date</th>
            <th align="center">Status</th>
            <th align="center">Actions</th> <!-- New column for the delete button -->
        </tr>

        <?php
        while ($employee = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$employee['pid']."</td>";
            echo "<td>".$employee['eid']."</td>";
            echo "<td>".$employee['pname']."</td>";
            echo "<td>".$employee['duedate']."</td>";
            echo "<td>".$employee['subdate']."</td>";
            echo "<td>".$employee['status']."</td>";
            echo "<td><button onclick='confirmDelete(" . $employee['pid'] . ")'>Delete</button></td>";
            echo "</tr>";

            // Update counters based on project status
            if ($employee['status'] == 'Due') {
                $totalDueProjects++;
            } elseif ($employee['status'] == 'Submitted') {
                $submittedProjects++;
            }
        }
        ?>
    </table>

    <div style="margin-top: 20px; text-align: center;">
        <table style="border: 2px solid #555; background-color: #f2f2f2; width: 50%; margin: auto;">
            <tr>
                <th>Total Due Projects</th>
                <th>Total Submitted Projects</th>
            </tr>
            <tr>
                <td style="border: 2px solid #555;"><?php echo $totalDueProjects; ?></td>
                <td style="border: 2px solid #555;"><?php echo $submittedProjects; ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
