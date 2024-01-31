<?php 
    $id = (isset($_GET['id']) ? $_GET['id'] : '');
    require_once('process/dbh.php');
    $sql1 = "SELECT * FROM `employee` where id = '$id'";
    $result1 = mysqli_query($conn, $sql1);
    $employeen = mysqli_fetch_array($result1);
    $empName = ($employeen['firstName']);

    $sql = "SELECT id, firstName, lastName, points FROM employee, rank WHERE rank.eid = employee.id ORDER BY rank.points DESC";
    $sql1 = "SELECT `pname`, `duedate` FROM `project` WHERE eid = $id AND status = 'Due'";
    $sql2 = "SELECT * FROM employee, employee_leave WHERE employee.id = $id AND employee_leave.id = $id ORDER BY employee_leave.token";
    $sql3 = "SELECT * FROM `salary` WHERE id = $id";

    $result = mysqli_query($conn, $sql);
    $result1 = mysqli_query($conn, $sql1);
    $result2 = mysqli_query($conn, $sql2);
    $result3 = mysqli_query($conn, $sql3);
?>

<html>
<head>
    <title>Employee Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styleemplogin.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Montserrat" rel="stylesheet">
</head>
<body>
    
    <header>
        <nav>
            <h1>Dashboard</h1>
            <ul id="navli">
                <li><a class="homered" href="eloginwel.php?id=<?php echo $id?>">HOME</a></li>
                <li><a class="homeblack" href="myprofile.php?id=<?php echo $id?>">My Profile</a></li>
                <li><a class="homeblack" href="empproject.php?id=<?php echo $id?>">My Projects</a></li>
                <li><a class="homeblack" href="applyleave.php?id=<?php echo $id?>">Apply Leave</a></li>
                <li><a class="homeblack" href="elogin.html">Log Out</a></li>
            </ul>
        </nav>
    </header>
     
    <div class="divider"></div>
    <div id="divimg">
        <div>
            <h2> Welcome <?php echo "$empName"; ?> </h2> <!-- Added welcome message -->

            <h2 style="font-family: 'Montserrat', sans-serif; font-size: 25px; text-align: center;">All Employees</h2>
            <table>
                <tr bgcolor="#000">
                    <th align="center">S/N.</th>
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
                    $seq+=1;
                }
                ?>
            </table>
        </div>

        <div>
            <h2 style="font-family: 'Montserrat', sans-serif; font-size: 25px; text-align: center;">Leave Status</h2>
            <table>
                <tr>
                    <th align="center">Start Date</th>
                    <th align="center">End Date</th>
                    <th align="center">Total Days</th>
                    <th align="center">Reason</th>
                    <th align="center">Status</th>
                </tr>
                <?php
                while ($leave = mysqli_fetch_assoc($result2)) {
                    $date1 = new DateTime($leave['start']);
                    $date2 = new DateTime($leave['end']);
                    $interval = $date1->diff($date2);

                    echo "<tr>";
                    echo "<td>" . $leave['start'] . "</td>";
                    echo "<td>" . $leave['end'] . "</td>";
                    echo "<td>" . $interval->days . "</td>";
                    echo "<td>" . $leave['reason'] . "</td>";
                    echo "<td>" . $leave['status'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>

        <div>
            <h2 style="font-family: 'Montserrat', sans-serif; font-size: 25px; text-align: center;">Due Projects</h2>
            <table>
                <tr>
                    <th align="center">Project Name</th>
                    <th align="center">Due Date</th>
                </tr>
                <?php
                while ($project = mysqli_fetch_assoc($result1)) {
                    echo "<tr>";
                    echo "<td>" . $project['pname'] . "</td>";
                    echo "<td>" . $project['duedate'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>

        <!-- Your existing HTML code for Salary Status -->

        <div>
            <h2 style="font-family: 'Montserrat', sans-serif; font-size: 25px; text-align: center;">Salary Status</h2>
            <table>
                <tr>
                    <th align="center">Base Salary</th>
                </tr>
                <?php
                while ($salary = mysqli_fetch_assoc($result3)) {
                    echo "<tr>";
                    echo "<td>" . $salary['base'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>

    </div>
    </div>
</body>
</html>
