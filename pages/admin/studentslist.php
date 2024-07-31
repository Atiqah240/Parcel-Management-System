<?php
session_start();
include("../../config/config.php");

if (isset($_SESSION['studid'])) {
    $studid = $_SESSION['studid'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Students</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #111;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 20px 20px 0 0;
            font-size: 24px;
        }
        .header h1 {
            margin: 0;
            font-weight: 600;
        }
        .students-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .student-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            overflow: hidden;
            cursor: pointer;
        }
        .student-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
        }
        .student-card-content {
            padding: 20px;
        }
        .student-card-content h3 {
            margin-top: 0;
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }
        .student-details {
            color: #666;
            font-size: 14px;
        }
        .student-details p {
            margin: 5px 0;
        }
        .student-details strong {
            color: #111;
            font-weight: 600;
        }
        @media (max-width: 768px) {
            .container {
                border-radius: 0;
            }
        }
        img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }
        .box{
                width: 50%;
                height: 30px;
                margin-top: 20px;
                margin-left: 250px;
                display: flex;
                cursor: pointer;
                padding: 15px 20px;
                background: #fff;
                border-radius: 20px;
                border: transparent;
                justify-content: center;
                align-items: center;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
                position: center;
            }
            .container box{
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 2rem;
            }
            .text-center {
                text-align: center;
            }

            .text-center .btn {
                margin: 20px;
                display: inline-block;
                padding: 0.75rem 1.5rem;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 1rem;
                text-decoration: none;
                transition: background-color 0.3s ease;
            }

            .text-center .btn:hover {
                background-color: #0056b3;
            }

            .text-center .btn:focus {
                outline: none;
            }

            .text-center .btn:active {
                transform: translateY(1px);
            }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>List of Students</h1>
        </div>
            <form method="POST">
                <input class="box" type="test" placeholder="Search Here..." name="search">
            </form>
            <div class="students-list">
            <?php
                if(isset($_POST['search'])){
                    $search=$_POST['search'];
                    $sql="SELECT * FROM student WHERE studname LIKE '%$search%'OR studUsername LIKE '%$search%' OR studaddress LIKE '%$search%' OR studphone LIKE '%$search%'";
                    $result1=mysqli_query($con, $sql);

                    if (mysqli_num_rows($result1) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result1)) {
                            echo '<div class="student-card">';
                            echo '<div class="student-card-content">';
                            //echo "<td><img src='" . htmlspecialchars($row["ppStud"]) . "' alt='Profile Picture'></td>";
                            echo '<h3>' . htmlspecialchars($row["studname"]) . '</h3>';
                            echo '<div class="student-details">';
                            echo '<p><strong>Username:</strong> ' . htmlspecialchars($row["studUsername"]) . '</p>';
                            echo '<p><strong>Address:</strong> ' . htmlspecialchars($row["studaddress"]) . '</p>';
                            echo '<p><strong>Email:</strong> ' . htmlspecialchars($row["email"]) . '</p>';
                            echo '<p><strong>Phone:</strong> ' . htmlspecialchars($row["studphone"]) . '</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '';
                        }
                    } else {
                        echo '<p style="text-align: center; margin-top: 20px;">No students found.</p>';
                    }
                }
            ?>
        </div>

        <div class="students-list">
            <?php
                // Fetch all student data from the database
                $query = "SELECT studid, studUsername, studname, studaddress, email, studphone, ppStud FROM student";
                $result = mysqli_query($con, $query);

                // Check if any rows were returned
                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="student-card">';
                        echo '<div class="student-card-content">';
                        //echo "<td><img src='" . htmlspecialchars($row["ppStud"]) . "' alt='Profile Picture'></td>";
                        echo '<h3>' . htmlspecialchars($row["studname"]) . '</h3>';
                        echo '<div class="student-details">';
                        echo '<p><strong>Username:</strong> ' . htmlspecialchars($row["studUsername"]) . '</p>';
                        echo '<p><strong>Address:</strong> ' . htmlspecialchars($row["studaddress"]) . '</p>';
                        echo '<p><strong>Email:</strong> ' . htmlspecialchars($row["email"]) . '</p>';
                        echo '<p><strong>Phone:</strong> ' . htmlspecialchars($row["studphone"]) . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p style="text-align: center; margin-top: 20px;">No students found.</p>';
                }
            ?>
        </div>
        <div class="text-center">
            <button onclick="window.history.back()" class="btn btn-primary">Back</button>
            <button onclick="window.print()" class="btn btn-primary">Print</button>
        </div>
    </div>
</body>
</html>