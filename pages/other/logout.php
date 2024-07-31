<?php
session_start();

// Check if the user has submitted the logout form
if (isset($_POST['confirm_logout'])) {
  // Destroy the session.
  session_destroy();

  // Redirect to the login page (or any other page).
  header("Location: ../../pages/other/mainPage.php");
  exit();
    // Perform logout actions, such as destroying session variables
    session_unset();
    session_destroy();
    header("Location: mainPage.php"); // Redirect to login page after logout
    exit();
}

// Display a confirmation message and a form to confirm logout
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        p {
            margin-bottom: 20px;
            color: #666;
        }
        input[type=submit], input[type=button] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        input[type=submit]:hover, input[type=button]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Logout</h1>
        <p>Are you sure you want to logout?</p>
        <form method="post">
            <input type="submit" name="confirm_logout" value="Yes, logout">
            <input type="button" value="No, cancel" onclick="history.go(-1)">
        </form>
    </div>
</body>
</html>