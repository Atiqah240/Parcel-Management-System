<?php
    $message = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        include("config.php");

        // Retrieve form data
        $dataType = $_POST['dataType'];
        $dataId = $_POST['dataId'];

        // Validate the dataId
        if (!is_numeric($dataId)) {
            $message = "Invalid ID format.";
        } else {
            // Determine the table to delete from based on the dataType
            switch ($dataType) {
                case 'admin':
                    $table = 'admin';
                    break;
                case 'employee':
                    $table = 'employee';
                    break;
                case 'student':
                    $table = 'student';
                    break;
                default:
                    $message = "Invalid data type.";
                    $table = ''; // Ensure table is not set for invalid data type
            }

            if ($table) {
                // Prepare the SQL delete statement
                $sql = "DELETE FROM $table WHERE $dataId = ?";
                $stmt = $con->prepare($sql);
                
                // Check if the statement was prepared successfully
                if (!$stmt) {
                    $message = "Error preparing statement: " . $con->error;
                } else {
                    $stmt->bind_param("i", $dataId);

                    // Execute the statement and check for success
                    if ($stmt->execute()) {
                        $message = "Data has been removed successfully.";
                        //echo $message;
                        //successful execution, no message needed
                    } else{
                       $message = "Error removing data: ". $con->error;
                    }

                    // Close the statement and connection
                    $stmt->close();
                }
            }
        }

        $con->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPARK SYSTEM: Admin Removal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #BFACE2;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
        }
        .logo img {
            height: 125px; /* Adjust as needed */
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .container h1 {
            margin-bottom: 20px;
        }
        .container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container select, .container input[type="text"] {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            max-width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .container input[type="submit"] {
            padding: 10px 20px;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .note {
            font-size: 0.7em;
            color: #555;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function confirmRemoval(event) {
            event.preventDefault();
            const form = event.target;
            const dataType = form.querySelector('select[name="dataType"]').value;
            const dataId = form.querySelector('input[name="dataId"]').value;
            const adminPassword = prompt('Please enter your password to confirm:');
            
            if (adminPassword === null || adminPassword.trim() === '') {
                alert('Password is required for confirmation.');
                return;
            }
            
            const formData = new FormData();
            formData.append('dataType', dataType);
            formData.append('dataId', dataId);
            formData.append('adminPassword', adminPassword);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', form.action);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert('Data has been removed successfully.');
                    //alert(xhr.responseText); // Display the server response
                    // Optionally, reload the page or update UI based on success
                } else {
                   alert('Error: ' + xhr.statusText);
                }
                
            };
            xhr.onerror = function() {
                alert('Request failed.');
            };
            xhr.send(formData);
        }
    </script>
</head>
<body>
    <div class="logo">
        <img src="img/spark(no bg).png" alt="SPARK Logo">
    </div>
    <div class="container">
        <h1>SPARK SYSTEM: Admin Removal</h1>
    
        <form method="POST" onsubmit="confirmRemoval(event)">
            <select name="dataType">
                <option value="">Select Data Type</option>
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
                <option value="student">Student</option>
            </select>
            <input type="text" name="dataId" placeholder="Enter the Data ID">
            <p class="note">Admin can remove admin, employee and student data only!</p>
            <input type="submit" value="Remove">
        </form>
    </div>
    
</body>
</html>
