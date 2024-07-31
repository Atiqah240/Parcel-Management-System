<?php
session_start();
include ('../../config/config.php');

// Check if the admin ID is stored in session
if (isset($_SESSION['adminid'])) {
    $adminid = $_SESSION['adminid'];

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Fetch POST data
        $adminid_post = $_POST['adminid'] ?? null;
        $admname = $_POST['admname'] ?? null;
        $admphone = $_POST['admphone'] ?? null;

        // Check if the adminid exists in the admin table
        $stmt_check_admin = $con->prepare("SELECT adminid FROM admin WHERE adminid = ?");
        $stmt_check_admin->bind_param("s", $adminid_post);
        $stmt_check_admin->execute();
        $result = $stmt_check_admin->get_result();

        if ($result->num_rows > 0) {
            // Update the admin table
            $stmt_admin = $con->prepare("UPDATE admin SET admname = ?, admphone = ? WHERE adminid = ?");
            $stmt_admin->bind_param("sss", $admname, $admphone, $adminid_post);
            $exec_admin = $stmt_admin->execute();
            $stmt_admin->close();

            if ($exec_admin === false) {
                die('Execute failed for admin update: ' . htmlspecialchars($con->error));
            }

            echo "<script type='text/javascript'>alert('Successfully updated');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Invalid admin ID');</script>";
        }

        $stmt_check_admin->close();
    }
} 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Update</title>
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'poppins', sans-serif;
        }

        body {
            font-family: 'poppins', sans-serif;
            background-color: #BFACE2;
            color: #333;
        }

        /* Banner styling */
        .banner {
            background: #BFACE2;
            color: black;
            padding: 1rem 2rem;
            text-align: center;
        }

        .banner h1 {
            margin-bottom: 0.5rem;
        }

        .image {
            width: 30px;
            display: flex;
            align-items: center;
            cursor: pointer;
            margin: 20px 10px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: #BFACE2;
        }

        .navbar img.logo {
            width: 120px;
            cursor: pointer;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 3rem;
        }

        .navbar ul button {
            width: 200px;
            background: #645CBB;
            color: black;
            border: none;
            text-align: center;
            padding: 0.5rem 2rem;
            margin: 20px 10px;
            cursor: pointer;
            border-radius: 20px;
            font-size: 1rem;
            position: relative;
        }

        .navbar ul button:hover {
            background: #645CBB;
        }

        .navbar ul img.image {
            height: 30px;
            cursor: pointer;
        }

        /* Form styling */
        .form-container {
            display: flex;
            justify-content: center;
            padding: 2rem;
            background-color: #BFACE2;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem 2rem;
            align-items: center;
        }

        .input-group {
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .input-group input[type="text"], .input-group select {
            padding: 0.75rem;
            border: 2px solid #333;
            border-radius: 4px;
            font-size: 1rem;
            background-color: #e0d4f7;
            width: 100%; /* Ensure it matches the width of the container */
        }

        /* Remove unnecessary padding and margin for select elements */
        .input-group select {
            padding: 0.75rem; /* Match the input padding */
            margin: 0; /* Remove extra margin */
        }

        .input-group label {
            margin-bottom: 0.5rem;
            font-size: 1rem;
            color: #333;
        }

        .submit-btn {
            grid-column: span 2;
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }

        .submit-btn button {
            background: #645CBB;
            color: black;
            border: none;
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            border-radius: 20px;
            font-size: 1rem;
        }

        .submit-btn button:hover {
            background: #645CBB;
        }

        button {
            width: 200px;
            padding: 15px;
            margin: 20px 5px;
            text-align: center;
            border-radius: 25px;
            color: black;
            border: 2px;
            font-size: 20px;
            cursor: pointer;
            font-weight: 600;
        }

        button:hover {
            background-color: #645CBB;
            transition: 0.3s;
        }

        button:hover {
            color: white;
        }
    </style>
</head>
<body>
    <div class="banner">
        <h1>Admin</h1>
        <div class="navbar">
            <img class="logo" src="../../pictures/logo.png" alt="Logo">
            <ul>
                <li><a href="../../pages/admin/adminupdate.php">
                <button type="button">UPDATE</button></a></li>

                <li><a href="#">
                <button type="button">REMOVE</button></a></li>

                <li><a href="../../pages/admin/admSearch.php">
                <button type="button">SEARCH</button></a></li>

                <li><a href="#">
                <button type="button">VIEWING</button></a></li>
                <img class="image" src="../../pictures/home.png" alt="Home">
            </ul>
        </div>
        </div>
        <div class="form-container">
            <form action="../../pages/admin/adminupdate.php" method="post" class="form-grid">
                <div class="input-group">
                    <input type="text" name="adminid" required>
                    <label for="adminid">Admin ID :</label>
                </div>
                <div class="input-group">
                    <input type="text" name="admname" required>
                    <label for="admname">Name :</label>
                </div>
                <div class="input-group">
                    <input type="text" name="admphone" required>
                    <label for="admphone">Phone Num :</label>
                </div>
                <div class="submit-btn">
                    <button type="submit">UPDATE</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
