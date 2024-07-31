<?php
    session_start();
    include ('../../config/config.php');
    $empid = $_SESSION['empid'];

    $sql = "SELECT * FROM employee WHERE empid = '$empid'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);


    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Retrieve the logged-in empUsername from the session
        if (!isset($_SESSION['empid'])) {
            echo "<script type='text/javascript'>alert('Employee Username is not set in the session');</script>";
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Page</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .header {
            background-color: #111;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background-color: #111;
            color: #fff;
        }
        .navbar ul {
            list-style: none;
            display: flex;
            gap: 1rem;
        }
        .navbar ul li {
            display: inline;
        }
        .navbar a {
            text-decoration: none;
            color: #fff;
        }
        .navbar a:hover {
            background-color: #645CBB;
            border-radius: 25px;
            padding: 15px 30px; /* increased padding for larger clickable area */
            transition: background-color 0.3s;
        }
        .navbar img.logo {
            width: 120px;
            cursor: pointer;
        }
        .image {
            width: 30px;
            cursor: pointer;
            margin: 0 10px;
        }
        .content {
            padding: 60px;
            text-align: center;
        }
        .content h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .content h1 img {
            width: 60px;
            margin-right: 10px;
        }
        .icon {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .icon img {
            width: 100px;
            height: 100px;
        }
        .logout-button {
            text-align: center;
            margin-top: 20px;
        }
        button {
            padding: 15px 30px;
            font-size: 18px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px); /* slight lift on hover */
        }
        .benefits {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 40px;
        }
        .benefits .benefit {
            text-align: center;
        }
        .benefits .benefit img {
            width: 150px;
            margin-bottom: 10px;
        }
        .benefits .benefit p {
            font-size: 20px;
            color: #666;
        }
        //for dropdown profile
        .dropdown {
            position: relative;
            display: inline-block;
            margin-left: -40%;
        }

        .dropdown img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            margin-left: -40%;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;

        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;

        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
            margin-left: -7%;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <img class="logo" src="../../pictures/logoParcel.png" alt="Logo">
        <ul>
            <li><a href="../../pages/employee/employeeupdate.php">UPDATE</a></li>
            <li class="dropdown">
                <a href="#">VIEW</a>
                <div class="dropdown-content">
                    <a href="../../pages/employee/parcellist.php">parcel</a>
                    <a href="../../pages/employee/studentslist.php">Student</a>
                </div>
            </li>
        </ul>
        <img class="image" src="../../pictures/home.png" alt="Home">

        <div class="dropdown">
            <img src="<?php echo $row['ppEmp']; ?>" alt="Avatar" class="emp-pic">
            <div class="dropdown-content">
                <a href="../../pages/employee/editProfileEmp.php">Edit Profile</a>
                <a href="../../pages/employee/deleteEmp.php">Delete Account</a>
                <a href="../../pages/other/logout.php">Logout</a>
            </div>
        </div>

    </div>
    <div class="content">
        <h1><img src="../../pictures/employee.png" alt="Employee Icon"> WELCOME TO EMPLOYEE PAGE</h1>
        
        <div class="benefits">
            <div class="benefit">
                <img src="../../pictures/parcel.png" alt="Parcel">
                <p>SPARK. The best way to manage the parcels you love.</p>
            </div>
            <div class="benefit">
                <img src="../../pictures/fast.png" alt="Fast">
                <p>Ensure fast delivery service for all our parcels.</p>
            </div>
            <div class="benefit">
                <img src="../../pictures/employeetask.png" alt="Employee Task">
                <p>Track parcels efficiently with our Employee Task feature.</p>
            </div>
        </div>
    </div>
    <div class="logout-button">
        <form action="../../pages/other/mainPage.php" method="post">
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>
