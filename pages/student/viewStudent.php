<?php
session_start();
include ('../../config/config.php');

if (isset($_SESSION['studid'])) {
    $studid = $_SESSION['studid'];

// Fetch all student data from the database
$query = "SELECT * FROM student";
$result = mysqli_query($con, $query);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    echo "<h2>List of Students</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Student ID</th><th>Name</th><th>Address</th><th>Email</th><th>Phone</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["studid"] . "</td>";
        echo "<td>" . $row["studname"] . "</td>";
        echo "<td>" . $row["studaddress"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["studphone"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No students found.";
}
}
?>
