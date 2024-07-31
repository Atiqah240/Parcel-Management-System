<?php
session_start();
include ('../../config/config.php');

// Get the employee ID from session
$empid = $_SESSION['empid'];

// Fetch the employee details
$sql = "SELECT * FROM employee WHERE empid = '$empid'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Check if the employee ID is stored in session
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve the logged-in empid from the session
    if (!isset($_SESSION['empid'])) {
        echo "<script>alert('Student ID is not set in the session');</script>";
        exit();
    }
        $empid = $_SESSION['empid'];
        $empUsername = $_POST['empUsername'] ?? null;
        $emppass = $_POST['emppass'];
        $empname = $_POST['empname'];
        $empphone = $_POST['empphone'];
        $jobtitle = $_POST['jobtitle'];

        // Check if the empid exists in the employee table
        $stmt_check_employee = $con->prepare("SELECT empid FROM employee WHERE empid = ?");
        $stmt_check_employee->bind_param("s", $empid);
        $stmt_check_employee->execute();
        $result = $stmt_check_employee->get_result();

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
                        
                        $fileNameNew = $empUsername.".".$fileActualExt;
                        $fileDestination = '../../ppUser/ppEmployee/'. $fileNameNew;

                        move_uploaded_file($fileTmpName, $fileDestination); //to upload file to a specific folder
                        if ($result->num_rows > 0) {
                            // Update the employee table
                            $stmt_employee = $con->prepare("UPDATE employee SET emppass = ?, empname = ?, empphone = ? ,ppEmp = ? WHERE empid = ?");
                            $stmt_employee->bind_param("sssss", $emppass, $empname, $empphone, $fileDestination ,$empid);
                            $exec_employee = $stmt_employee->execute();
                            $stmt_employee->close();
                
                            if ($exec_employee === false) {
                                die('Execute failed for employee update: ' . htmlspecialchars($con->error));
                            }
                
                            echo "<script type='text/javascript'>alert('Successfully updated');</script>";
                        } else {
                            echo "<script type='text/javascript'>alert('Invalid employee ID');</script>";
                        }
                
                        $stmt_check_employee->close();

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
    <title>employee Update</title>
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
            <h1>Update employee Details</h1>
            <form method="POST" action="" enctype="multipart/form-data">

                <div class="pp">
                    <img src="<?php echo $row['ppEmp']; ?>" class="employee-pic">
                </div>
                
                <div class="form-text">
                    <label for="empname">Name</label>
                    <input type="text" id="empname" name="empname" style="text-transform: uppercase" required>
                </div>
                <script>
                    document.getElementById('admname').addEventListener('input', function() {
                        this.value = this.value.toUpperCase();
                    });
                </script>

                <div class="form-text">
                    <label for="empphone">Phone Number</label>
                    <input type="text" id="empphone" name="empphone" placeholder="01X-XXXXXXXX" pattern="01\d-\d{7,8}" title="Please enter a phone number in the format 01X-XXXXXXXX" required>
                </div>

                <div class="form-text">
                        <label for="jobtitle">Job Title </label>
                        <div class="styled-select">
                            <select name="jobtitle" required>
                                <option value="" disabled selected>Choose Job Title</option>
                                <option value="Delivery Boy">Delivery Boy</option>
                                <option value="Management">Management</option>
                            </select>
                        </div>
                    </div>

                <div class="form-text">
                    <label for="emppass">Password</label>
                    <input type="password" id="emppass" name="emppass"  minlength="8" placeholder="min 8 characters" required>
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
