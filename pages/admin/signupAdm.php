<?php
/* include db connection file syaaaa */
session_start();
include '../../config/config.php';

if(isset($_POST['submit'])){
    /* capture values from HTML form */
    $AdmUsername = $_POST['admUsername'];
    $Admpass = $_POST['admpass'];
    $Admname = $_POST['admname'];
    $Admphone = $_POST['admphone'];
    /* execute SQL SELECT command */
    $sql = "SELECT admUsername FROM admin WHERE admUsername = '$AdmUsername'";
    //echo $sql;
    $query = mysqli_query($con, $sql);
    if (!$query) {
        die("Error: " . mysqli_error($con));
    }
    $row = mysqli_num_rows($query);
    if($row != 0){
        echo "<script>alert('The username is already existed'); 
                window.location.href = 'signupAdm.php';
                </script>";
            exit();
    }
    else{
            // Image upload handling
        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
            $file = $_FILES['image'];
            $fileName = $_FILES['image']['name'];
            $fileTmpName = $_FILES['image']['tmp_name'];
            $fileSize = $_FILES['image']['size'];
            $fileError = $_FILES['image']['error'];
            $fileType = $_FILES['image']['type'];
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array('jpg','jpeg','png');
            if(in_array($fileActualExt, $allowed)) {
                if($fileError === 0) {
                    //file size must be < 10MB
                    if($fileSize < 10485760) {
                        echo $sql;
                        $fileNameNew = $AdmUsername.".".$fileActualExt;
                        $fileDestination = '../../ppUser/ppAdmin/'. $fileNameNew;

                        move_uploaded_file($fileTmpName, $fileDestination); //to upload file to a specific folder
                        /* execute SQL INSERT commands */
                        $sql2 = "INSERT INTO admin (admUsername, admpass, admname, admphone, ppAdm) VALUES ('$AdmUsername','$Admpass', '$Admname', '$Admphone', '$fileDestination')";
                        if (mysqli_query($con, $sql2)) {
                            echo "<script>alert('Succesfully registered!'); 
                                window.location.href = 'loginAdm.php';
                                </script>";
                            exit();
                        } else {
                            echo "Error: " . mysqli_error($con);
                        }
                    } else {
                        echo "<script>
                            alert('File is too big!');
                        </script>";   
                    }
                } else {
                    echo "<script>
                        alert('There is an error in this file!');
                    </script>";  
                }
            } else {
                echo "<script>
                    alert('PNG, JPG, JPEG only!');
                </script>";  
            }
        }
    }
}
/* close db connection */
mysqli_close($con);
// create new user id
function createUserId(){
    include '../../config/config.php';
    // Find the highest current user ID
    $sqlSelectMaxId = "SELECT admUsername FROM admin ORDER BY admUsername DESC LIMIT 1";
    $result = mysqli_query($con, $sqlSelectMaxId);
    if (!$result) {
        die("Error: " . mysqli_error($con));
    }
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['admUsername'];
    
    // Extract the numeric part, increment it, and create the new ID
    $numericPart = intval(substr($lastId, 1)); // assuming the prefix "U" is always 1 character
    $newNumericPart = $numericPart + 1;
    if ($newNumericPart < 10) {
        $newUserId = 'U0' . $newNumericPart;
    } else {
        $newUserId = 'U' . $newNumericPart;
    }
    return $newUserId;
}
// create new user details id
function createUserDetailsId(){
    include '../../config/config.php';
    // Find the highest current user details ID
    $sqlSelectMaxId = "SELECT admUsername FROM parcel ORDER BY parcelid DESC LIMIT 1";
    $result = mysqli_query($con, $sqlSelectMaxId);
    if (!$result) {
        die("Error: " . mysqli_error($con));
    }
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['admUsername'];
    
    // Extract the numeric part, increment it, and create the new ID
    $numericPart = intval(substr($lastId, 2)); // assuming the prefix "UD" is always 2 characters
    $newNumericPart = $numericPart + 1;
    if ($newNumericPart < 10) {
        $newUserId = 'UD0' . $newNumericPart;
    } else {
        $newUserId = 'UD' . $newNumericPart;
    }
    return $newUserId;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style1.css">
    <title>Sign Up</title>
</head>
<style>
    .backbtn {
        display: flex;
        justify-content: center; /* Horizontally center */
        align-items: center; /* Vertically center */
        height: 3vh; /* Adjust height as needed */
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
        <!--<div class="backbtn">
            <button id="backButton" type="button" style="position: center; border: none; background: none; cursor: pointer; width: 50px; height: 50px;">
                <img src="../../pictures/back-button.png" alt="Back" style="width: 100%; height: 100%">
            </button>
        </div>
        <script>
            document.getElementById('backButton').addEventListener('click', function() {
                window.history.back();
            });
        </script> -->

        <div class="box form-box">
            <header>Admin Sign Up</header>
            <form name="spark_system" method="post" action="" enctype="multipart/form-data">

                <div class="field input">
                    <label for="admUsername">Username</label>
                    <input type="text" name="admUsername" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="admpass">Password </label>
                    <input type="password" name="admpass" autocomplete="off" minlength="8" placeholder="min 8 characters" required>
                </div>

                <div class="field input">
                    <label for="admname">Full Name</label>
                    <input type="text" name="admname" autocomplete="off" style="text-transform: uppercase" required>
                </div>
                <script>
                    document.getElementById('admname').addEventListener('input', function() {
                        this.value = this.value.toUpperCase();
                    });
                </script>

                <div class="field input">
                    <label for="admphone">Phone Number </label>
                    <input type="text" name="admphone" autocomplete="off" pattern="01\d-\d{7,8}" title="Please enter a phone number in the format 01X-XXXXXXXX" required>
                </div>

                <div class="card">
                    <img src="../../pictures/default-avatar.png" id="profile-pic" style="margin-top: 10px; width: 20px; border-radius: 50%; object-fit: cover;">
                    <label for="input-file">Profile Picture</label>
                    <input type="file" name="image" accept="image/jpeg, image/png, image/jpg" id="imput-file" required>
                </div>

                <script>
                    let profilePic = document.getElementById("profile-pic");
                    let inputfile = document.getElementById("input-file");
                    inputFile.onchange = function(){
                        profilePic.src = URLcreateObjectURL(inputFile.files[0]);
                    }
                </script>
                <!--<div class="stud-img">
                    <img src="../../pictures/default-avatar.png" id="photo">
                    <input type="file" accept="image/jpeg, image/png, image/jpg" id="file">
                    <label for="file" id="uploadbtn"><i class="fas fa-camera"></i></label>
                    
                </div>
                <script src="index.js"></script> -->
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Sign Up" required>
                </div>
            </form>

            <div class="links">
                Already a member? <a href="../../pages/admin/loginAdm.php">Login</a>
            </div>

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
    </div>
</body>
</html>