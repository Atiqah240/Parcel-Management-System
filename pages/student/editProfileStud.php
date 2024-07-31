<?php
session_start();
include ('../../config/config.php');

// Get the student ID from session
$studid = $_SESSION['studid'];

// Fetch the student details
$sql = "SELECT * FROM student WHERE studid = '$studid'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Check if the student ID is stored in session
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve the logged-in studid from the session
    if (!isset($_SESSION['studid'])) {
        echo "<script>alert('Student ID is not set in the session');</script>";
        exit();
    }
        $studid = $_SESSION['studid'];
        $studUsername = $_POST['studUsername'] ?? null;
        $studpass = $_POST['studpass'] ?? null;
        $studname = $_POST['studname'] ?? null;
        $studaddress = $_POST['studaddress'] ?? null;
        $email = $_POST['email'] ?? null;
        $studphone = $_POST['studphone'] ?? null;

        // Check if the studid exists in the student table
        $stmt_check_student = $con->prepare("SELECT studid FROM student WHERE studid = ?");
        $stmt_check_student->bind_param("s", $studid);
        $stmt_check_student->execute();
        $result = $stmt_check_student->get_result();

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
                        
                        $fileNameNew = $studUsername.".".$fileActualExt;
                        $fileDestination = '../../ppUser/ppStudent/'. $fileNameNew;

                        move_uploaded_file($fileTmpName, $fileDestination); //to upload file to a specific folder
                        if ($result->num_rows > 0) {
                            // Update the student table
                            $stmt_student = $con->prepare("UPDATE student SET studpass = ?, studname = ?, studaddress = ?, email = ?, studphone = ?, ppStud = ? WHERE studid = ?");
                            $stmt_student->bind_param("sssssss", $studpass, $studname, $studaddress, $email, $studphone, $fileDestination ,$studid);
                            $exec_student = $stmt_student->execute();
                            $stmt_student->close();
                
                            if ($exec_student === false) {
                                die('Execute failed for student update: ' . htmlspecialchars($con->error));
                            }
                
                            echo "<script type='text/javascript'>alert('Successfully updated');</script>";
                        } else {
                            echo "<script type='text/javascript'>alert('Invalid student ID');</script>";
                        }
                
                        $stmt_check_student->close();

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>student Update</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f7;
            color: #1d1d1f;
        }
        .content {
            padding: 40px;
            text-align: center;
        }
        .content h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #1d1d1f;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }
        .form-container div {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #6e6e73;
        }
        input[type="text"] {
            max-width: 450px;
            width: 100%;
            padding: 12px 20px;
            border: 1px solid #d2d2d7;
            border-radius: 8px;
            font-size: 16px;
            color: #1d1d1f;
            background-color: #f5f5f7;
        }
        input[type="text"]:focus {
            border-color: #007aff;
            background-color: #fff;
        }
        input[type="password"] {
            max-width: 450px;
            width: 100%;
            padding: 12px 20px;
            border: 1px solid #d2d2d7;
            border-radius: 8px;
            font-size: 16px;
            color: #1d1d1f;
            background-color: #f5f5f7;
        }
        input[type="password"]:focus {
            border-color: #007aff;
            background-color: #fff;
        }
        input[type="email"] {
            max-width: 450px;
            width: 100%;
            padding: 12px 20px;
            border: 1px solid #d2d2d7;
            border-radius: 8px;
            font-size: 16px;
            color: #1d1d1f;
            background-color: #f5f5f7;
        }
        input[type="email"]:focus {
            border-color: #007aff;
            background-color: #fff;
        }
        
        button {
            margin: 2px;
            width: 100%;
            padding: 14px 20px;
            font-size: 17px;
            font-weight: 600;
            background-color: #007aff;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        button:hover {
            background-color: #005bb5;
            transform: translateY(-2px);
        }
        .pp{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .pp img {
            width: 200px;
            height: 200px;         
            border-radius: 50%;   
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="form-container">
            <h1>Update student Details</h1>
            <form method="POST" action="" enctype="multipart/form-data">

                <div class="pp">
                    <img src="<?php echo $row['ppStud']; ?>" class="student-pic">
                </div>
                
                <div class="form-text">
                    <label for="studname">Name</label>
                    <input type="text" id="studname" name="studname" style="text-transform: uppercase" required>
                </div>
                <script>
                    document.getElementById('admname').addEventListener('input', function() {
                        this.value = this.value.toUpperCase();
                    });
                </script>

                <div class="form-text">
                    <label for="studaddress">Address</label>
                    <input type="text" id="studaddress" name="studaddress" placeholder="09A 03 c09/2" pattern="\d{2}[A-Za-z] \d{2} [A-Za-z]\d{2}/\d" title="Please enter an address in the format 09A 03 c09/2" required>
                </div>

                <div class="form-text">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-text">
                    <label for="studphone">Phone Number</label>
                    <input type="text" id="studphone" name="studphone" pattern="01\d-\d{7,8}" title="Please enter a phone number in the format 01X-XXXXXXXX" required>
                </div>

                <div class="form-text">
                    <label for="studpass">Password</label>
                    <input type="password" id="studpass" name="studpass"  minlength="8" placeholder="min 8 characters" required>
                </div>

                <div class="card">
                    <img src="../../pictures/default-avatar.png" id="profile-pic" style="margin-top: 10px; width: 20px; border-radius: 50%; object-fit: cover;">
                    <label for="input-file">Profile Picture</label>
                    <input type="file" name="image" accept="image/jpeg, image/png, image/jpg" id="input-file">
                </div>

                <script>
                    let profilePic = document.getElementById("profile-pic");
                    let inputfile = document.getElementById("input-file");
                    inputFile.onchange = function(){
                        profilePic.src = URLcreateObjectURL(inputFile.files[0]);
                    }
                </script>
                
                <!--<button type="submit">Back</button>-->
                <button type="submit" onclick="window.history.back()">Back</button>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
