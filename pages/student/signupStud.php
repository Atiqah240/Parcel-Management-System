<?php
session_start();
include '../../config/config.php';

if(isset($_POST['submit'])){
    /* capture values from HTML form */
    $studUsername = $_POST['studUsername'];
    $studpass = $_POST['studpass'];
    $studname = $_POST['studname'];
    $studaddress = $_POST['studaddress'];
    $email = $_POST['email'];
    $studphone = $_POST['studphone'];

    /* execute SQL SELECT command */
    $sql = "SELECT studUsername FROM student WHERE studUsername = '$studUsername'";
    //echo $sql;
    $query = mysqli_query($con, $sql);

    if (!$query) {
        die("Error: " . mysqli_error($con));
    }

    $row = mysqli_num_rows($query);

    if($row != 0){
        echo "<script>alert('The username is already existed'); 
                window.location.href = 'signupStud.php';
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

                        $fileNameNew = $studUsername.".".$fileActualExt;

                        $fileDestination = '../../ppUser/ppStudent/'. $fileNameNew;

                        move_uploaded_file($fileTmpName, $fileDestination); //to upload file to a specific folder

                        /* execute SQL INSERT commands */

                        $sql2 = "INSERT INTO student (studUsername, studpass, studname, studaddress, email, studphone, ppStud) VALUES ('$studUsername', '$studpass', '$studname', '$studaddress', '$email', '$studphone', '$fileDestination')";

                        //if (mysqli_query($con, $sql2)) {
                            // Set session variable for the student
                            //$_SESSION['student'] = $studid;

                        if (mysqli_query($con, $sql2)) {

                            echo "<script>alert('Succesfully registered!'); 
                                window.location.href = 'loginStud.php';
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
            height: 10vh; /* Adjust height as needed */
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
                <header>Sign Up</header>
                <form name="spark_system" method="post" action="" enctype="multipart/form-data">
                    <div class="field input">
                        <label for="studUsername">Username </label>
                        <input type="text" name="studUsername" utocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="studpass">Password </label>
                        <input type="password" name="studpass" autocomplete="off" minlength="8" placeholder="min 8 characters" required>
                    </div>

                    <div class="field input">
                        <label for="studname">Name</label>
                        <input type="text" name="studname" autocomplete="off" style="text-transform: uppercase" required>
                    </div>
                    <script>
                        document.getElementById('studname').addEventListener('input', function() {
                            this.value = this.value.toUpperCase();
                        });
                    </script>

                    <div class="field input">
                        <label for="studaddress">Address </label>
                        <input type="text" name="studaddress" autocomplete="off" placeholder="09A 03 c09/2" pattern="\d{2}[A-Za-z] \d{2} [A-Za-z]\d{2}/\d" title="Please enter an address in the format 09A 03 c09/2" required>
                    </div>

                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="studphone">Phone Number</label>
                        <input type="text" name="studphone" autocomplete="off" placeholder="01X-XXXXXXXX" pattern="01\d-\d{7,8}" title="Please enter a phone number in the format 01X-XXXXXXXX" required>
                    </div>

                    <div class="card">
                        <img src="../../pictures/default-avatar.png" id="profile-pic" style="margin-top: 10px; width: 20px; border-radius: 50%; object-fit: cover;">
                        <label for="input-file">Profile Picture</label>

                        <input type="file" name="image" accept="image/jpeg, image/png, image/jpg" id="imput-file">


                    </div>

                    <script>
                        let profilePic = document.getElementById("profile-pic");
                        let inputfile = document.getElementById("input-file");

                        inputFile.onchange = function(){
                            profilePic.src = URLcreateObjectURL(inputFile.files[0]);
                        }
                    </script>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Sign Up" required>
                    </div>
                </form>
                <div class="links">
                    Already a member? <a href="../../pages/student/loginStud.php">Login</a>
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

    </body>
</html>