 <?php
session_start();
include '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve the logged-in studid from the session
    if (!isset($_SESSION['studid'])) {
        echo "<script>alert('Student ID is not set in the session');</script>";
        exit();
    }
    $studid = $_SESSION['studid'];
    $trackingNumber = $_POST['trackingNumber'];
    $courname = $_POST['courier_name'];

    // Check if the studid exists in the student table
    $stmt_check_student = $con->prepare("SELECT studid FROM student WHERE studid = ?");
    $stmt_check_student->bind_param("s", $studid);
    $stmt_check_student->execute();
    $result_student = $stmt_check_student->get_result();

    if ($result_student->num_rows == 0) {
        echo "<script>alert('Student ID does not exist');</script>";
        exit();
    }
    $stmt_check_student->close();

    // Get current date and time
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s'); 

    // Insert the data into the parcel table with the associated studid
    $stmt_insert_parcel = $con->prepare("INSERT INTO parcel (trackingNumber, courname, studid, date, time) VALUES (?, ?, ?, ?, ?)");
    $stmt_insert_parcel->bind_param("sssss", $trackingNumber, $courname, $studid, $currentDate, $currentTime);

    if ($stmt_insert_parcel->execute()) {
        echo "<script>alert('Successfully inserted');</script>";
        // Redirect to a success page or do further processing
    } else {
        echo "Error: " . $stmt_insert_parcel->error;
    }
    $stmt_insert_parcel->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Add Parcel</title>
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        /* Banner styling */
        .banner {
            background: #333;
            color: white;
            padding: 1rem 2rem;
            text-align: center;
            border-bottom: 3px solid #222;
        }

        .banner h1 {
            margin-bottom: 0.5rem;
            font-size: 2rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }

        .navbar img.logo {
            width: 120px;
            cursor: pointer;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .navbar ul button {
            background: #333;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            border-radius: 20px;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        .navbar ul button:hover {
            background: #222;
        }

        .navbar ul img.image {
            height: 30px;
            cursor: pointer;
        }

        /* Form styling */
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 600px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            color: #333;
            font-weight: bold;
        }

        .input-group input[type="text"],
        .input-group select {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f5f5f5;
            transition: border-color 0.3s ease;
        }

        .input-group input[type="text"]:focus,
        .input-group select:focus {
            outline: none;
            border-color: #333;
        }

        .submit-btn {
            text-align: center;
            margin-top: 1rem;
        }

        .submit-btn button {
            background: #333;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            cursor: pointer;
            border-radius: 20px;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        .submit-btn button:hover {
            background: #222;
        }
    </style>
</head>
<body>
    <div class="banner">
        
        <div class="navbar">
        <a href="studentpage.php"><img class="logo" src="../../pictures/logoParcel.png" alt="Logo"></a>
            <ul>
                <li><a href="studentinsert.php"><button type="button">ADD PARCEL</button></a></li>
                <li><a href="studentupdate.php"><button type="button">EDIT PARCEL</button></a></li>
                <li><a href="viewPay.php"><button type="button">PAY</button></a></li>
                <li><a href="parcellist.php"><button type="button">VIEWING</button></a></li>
                <li><a href="studentpage.php"><img class="image" src="../../pictures/home.png" alt="Home"></a></li>
            </ul>
        </div>
    </div>
    <div class="form-container">
        <form action="studentinsert.php" method="post" class="form-grid">
            <div class="input-group">
                <label for="trackingNumber">Tracking Number :</label>
                <input type="text" id="trackingNumber" name="trackingNumber" required>
            </div>
            <div class="input-group">
                <label for="courier_name">Courier Name :</label>
                <select id="courier_name" name="courier_name" required>
                    <option value="" disabled selected>Select Courier Name</option>
                    <option value="JNT">JNT</option>
                    <option value="DHL">DHL</option>
                    <option value="NINJAVAN">NINJAVAN</option>
                    <option value="POSLAJU">POSLAJU</option>
                    <option value="SHOPEEEXPRESS">SHOPEEEXPRESS</option>
                </select>
            </div>
            <div class="submit-btn">
                <button type="submit">ADD</button>
            </div>
        </form>
    </div>
</body>
</html>
