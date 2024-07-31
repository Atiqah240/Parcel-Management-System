<?php
    session_start(); // Start the session
    include("config.php");
    $message = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Retrieve form data
        $dataType = $_POST['dataType'];
        $dataId = $_POST['dataId'];
        $empPassword = $_POST['empPassword'];

        // Validate the dataId
        if (!is_numeric($dataId)) {
            $message = "Invalid ID format.";
        } else {
            // Check the employee's password
            $stmt = $con->prepare("SELECT emppass FROM employee WHERE $dataId = ?");
            if ($stmt) {
                $stmt->bind_param("i", $dataId);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($storedPassword);
                    $stmt->fetch();

                    // Validate the entered password against the stored password
                    if (password_verify($empPassword, $storedPassword)) {
                        // Prepare the SQL delete statement
                        $sql = "DELETE FROM employee WHERE $dataId = ?";
                        $deleteStmt = $con->prepare($sql);
                        if ($deleteStmt) {
                            $deleteStmt->bind_param("i", $dataId);
                            if ($deleteStmt->execute()) {
                                $message = "Data has been removed successfully.";
                            } else {
                                $message = "Error removing data: " . $deleteStmt->error;
                            }
                            $deleteStmt->close();
                        } else {
                            $message = "Error preparing delete statement: " . $con->error;
                        }
                    } else {
                        /*$message = "Invalid password.";*/
                    }
                } else {
                    $message = "Employee not found.";
                }
                $stmt->close();
            } else {
                $message = "Error preparing select statement: " . $con->error;
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
    <title>SPARK SYSTEM: Employee Removal</title>
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
            margin-bottom: 5px;
        }
        .container input[type="text"], .container input[type="password"] {
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
            const dataId = form.querySelector('input[name="dataId"]').value;
            const empPassword = prompt('Please enter your password to confirm:');
            
            if (empPassword === null || empPassword.trim() === '') {
                alert('Password is required for confirmation.');
                return;
            }
            
            const formData = new FormData();
            /*formData.append('dataId', dataId);*/
            formData.append('empPassword', $empPassword);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', form.action);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
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
        <h1>SPARK SYSTEM: Employee Removal</h1>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST" onsubmit="confirmRemoval(event)">
            <input type="text" name="dataId" placeholder="Enter the Data ID">
            <p class="note">Employee can remove their data only!</p>
            <input type="submit" value="Remove">
        </form>
    </div>
</body>
</html>