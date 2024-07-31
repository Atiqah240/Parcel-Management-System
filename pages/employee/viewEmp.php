<h1>List of Employees</h1>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Employee ID</th>
        <th>Employee Name</th>
        <th>Phone</th>
        <th>Job Title</th>
        <th>Options</th>
    </tr>
    <!-- Start PHP code -->
    <?php
    // Start PHP session and include config
    session_start();
    include ('../../config/config.php');

    if (isset($_SESSION['empid'])) {
        $empid = $_SESSION['empid'];
        
    // Query to select all employee information
    $sql = "SELECT * FROM employee";
    $result = mysqli_query($con, $sql);

    // Check if there are any employees
    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["empid"] . "</td>";
            echo "<td>" . $row["empname"] . "</td>";
            echo "<td>" . $row["empphone"] . "</td>";
            echo "<td>" . $row["jobtitle"] . "</td>";
            echo "<td><a href='edit_employee.php?empid=" . $row["empid"] . "'>Edit</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No employees found.</td></tr>";
    }
}

    // Close the connection
    mysqli_close($con);
    ?>
    <!-- End PHP code -->
</table>
