<?php
session_start();
include ('../../config/config.php');

// Check if the employee ID is stored in session
if (isset($_SESSION['empid'])) {
    $empid = $_SESSION['empid'];

    // Fetch tracking numbers from the database
    $stmt = $con->prepare("SELECT trackingNumber FROM parcel");
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if there are results
    $trackingNumbers = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $trackingNumbers[] = $row['trackingNumber'];
        }
    } else {
        echo "No tracking numbers found.";
    }
    $stmt->close();

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Fetch POST data with null coalescing to avoid undefined array key warnings
        $trackingNumber = $_POST['trackingNumber'] ?? null;
        $size = $_POST['size'] ?? null;
        $status = $_POST['status'] ?? null;
        $payStatus = $_POST['payStatus'] ?? null;

        // Calculate price based on size
        switch ($size) {
            case 'small':
                $price = 1;
                break;
            case 'medium':
                $price = 2;
                break;
            case 'large':
                $price = 3;
                break;
            default:
                $price = 0; // Default or error handling if necessary
                break;
        }

        // Check if the tracking number exists in the parcel table
        $stmt_check_parcel = $con->prepare("SELECT trackingNumber FROM parcel WHERE trackingNumber = ?");
        $stmt_check_parcel->bind_param("s", $trackingNumber);
        $stmt_check_parcel->execute();
        $result = $stmt_check_parcel->get_result();
        
        if ($result->num_rows > 0) {
            // Update the parcel table
            $stmt_parcel = $con->prepare("UPDATE parcel SET size = ?, status = ?, payStatus = ?, empid = ?, price = ? WHERE trackingNumber = ?");
            $stmt_parcel->bind_param("ssssss", $size, $status, $payStatus, $empid, $price, $trackingNumber);
            $exec_parcel = $stmt_parcel->execute();
            $stmt_parcel->close();

            if ($exec_parcel === false) {
                die('Execute failed for parcel update: ' . htmlspecialchars($con->error));
            }

            echo "<script type='text/javascript'>alert('Successfully updated');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Invalid tracking number');</script>";
        }

        $stmt_check_parcel->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Update Parcel</title>
    <style>
        /* General Reset and Typography */
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
        }

        /* Banner and Navbar */
        .banner {
            background: #333;
            color: white;
            padding: 1rem 2rem;
            text-align: center;
            margin-bottom: 1rem;
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

        /* Form Container and Grid */
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin: 0 auto;
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
            <a href="employeeupdate.php"><img class="logo" src="../../pictures/logoParcel.png" alt="Logo"></a>
            <ul>
                <li><a href="employeeupdate.php"><button type="button">UPDATE</button></a></li>
                <li><a href="../../pages/employee/studentslist.php"><button type="button">VIEW</button></a></li>
                <li><a href="../../pages/employee/employeepage.php"><img class="image" src="../../pictures/home.png" alt="Home"></a></li>
            </ul>
        </div>
    </div>
    <div class="form-container">
        <form action="employeeupdate.php" method="post" class="form-grid">
            <div class="input-group">
                <label for="trackingNumber">Tracking Number :</label>
                <select id="trackingNumber" name="trackingNumber" required>
                    <option value="" disabled selected>Select Tracking Number</option>
                    <?php
                    foreach ($trackingNumbers as $tn) {
                        echo "<option value='" . htmlspecialchars($tn) . "'>" . htmlspecialchars($tn) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="input-group">
                <label for="size">Parcel Size :</label>
                <select id="size" name="size" required>
                    <option value="" disabled selected>Select Parcel Size</option>
                    <option value="large">Large</option>
                    <option value="medium">Medium</option>
                    <option value="small">Small</option>
                </select>
            </div>
            <div class="input-group">
                <label for="status">Parcel Status :</label>
                <select id="status" name="status" required>
                    <option value="" disabled selected>Select Parcel Status</option>
                    <option value="waiting">Waiting</option>
                    <option value="pickup">Pickup</option>
                    <option value="delivered">Delivered</option>
                </select>
            </div>
            <div class="input-group">
                <label for="payStatus">Payment Status :</label>
                <select id="payStatus" name="payStatus" required>
                    <option value="" disabled selected>Select Payment Status</option>
                    <option value="paid">PAID</option>
                    <option value="unpaid">UNPAID</option>
                </select>
            </div>
            <div class="submit-btn">
                <button type="submit">UPDATE</button>
            </div>
        </form>
    </div>
</body>
</html>
