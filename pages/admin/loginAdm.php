<?php
    session_start();

    include ('../../config/config.php');

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $admUsername = $_POST['admUsername'];
        $admpass = $_POST['admpass'];

        if(!empty($admUsername) &&!empty($admpass) &&!is_numeric($admUsername)){
            $query="select * from admin where admUsername='$admUsername' limit 1";
            $result=mysqli_query($con, $query);

            if($result){
                if($result && mysqli_num_rows($result)>0){
                    $user_data=mysqli_fetch_assoc($result);

                    if ($user_data['admpass'] == $admpass) {
                        $_SESSION['adminid'] = $user_data['adminid'];  // Store studid in session
                        $_SESSION['empUsername'] = $user_data['empUsername'];  // Store studUsername in session
                        header("location: adminpage.php");  // Redirect to student page
                        die;
                    }
                }
            }
            echo "<script>alert('Oops! Wrong ID or Password')</script>";
        }
        else{
            echo "<script>alert('Oops! Wrong ID or Password')</script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../css/style1.css">
        <title>Login</title>
    </head>
    <style>
    .backbtn {
        display: flex;
        justify-content: center; /* Horizontally center */
        align-items: center; /* Vertically center */
        height: 0vh; /* Adjust height as needed */
    }

    #backButton {
        border: none;
        background: none;
        cursor: pointer;
        width: 50px;
        height: 50px;
        padding: 0; /* Remove padding */
        margin: 0; /* Remove margin */
    }

    #backButton img {
        width: 100%;
        height: 100%;
    }
</style>
    <body>
        <div class="page">
            <div class="box form-box">
                <header>Admin Login</header>
                <form action="../../pages/admin/loginAdm.php" method="POST">
                    
                    <div class="field input">
                        <label>Username </label>
                        <input type="text" name="admUsername" required>
                    </div>

                    <div class="field input">
                        <label>Password </label>
                        <input type="password" name="admpass" required>
                    </div>

                    <div class="field">
                        <input type="submit" class="btn"name="submit" value="Login" required>
                    </div>
                    <div class="links">
                        Don't have account? <a href="../../pages/admin/signupAdm.php">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="backbtn">
            <button id="backButton" type="button" >
                <img src="../../pictures/back-button.png" alt="Back" style="width: 100%; height: 100%">
            </button>
        </div>
        <script>
            document.getElementById('backButton').addEventListener('click', function() {
                window.history.back();
            });
        </script>
    </body>
</html>