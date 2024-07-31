<?php
session_start();
include('../../config/config.php');

// Check if the user is logged in
if (!isset($_SESSION['studid'])) {
    echo "<script type='text/javascript'>alert('Student Username is not set in the session');</script>";
    exit();
}

// Get the student username from session
$studid = $_SESSION['studid'];



// Initialize total price
$totalPrice = 0;

// Check if parcels were selected
if (!isset($_POST['parcel']) || !is_array($_POST['parcel'])) {
    echo "No parcels selected.";
    exit();
}

// Decode selected parcels
$selectedParcels = array_map('json_decode', $_POST['parcel']);

// Calculate total price
$totalPrice = array_reduce($selectedParcels, function($sum, $parcel) {
    return $sum + $parcel->price;
}, 0);

// Function to get payid based on payment method
function getPayId($payMethod) {
    $payMethods = [
        'CASH' => 1,
        'QR' => 2
    ];
    return $payMethods[$payMethod] ?? null;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['proofFile'])) {
    // Handle file upload for payment proof
    $proofFile = $_FILES['proofFile'];
    $proofFileName = $_FILES['proofFile']['name'];
    $proofFileTmpName = $_FILES['proofFile']['tmp_name'];
    $proofFileSize = $_FILES['proofFile']['size'];
    $proofFileError = $_FILES['proofFile']['error'];
    $proofFileType = $_FILES['proofFile']['type'];

    // File extension
    $fileExt = explode('.', $proofFileName);
    $fileActualExt = strtolower(end($fileExt));

    // Allowed file types
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    // Check if file type is allowed
    if (in_array($fileActualExt, $allowed)) {
        if ($proofFileError === 0) {
            if ($proofFileSize < 1000000) { // 1MB limit
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = '../../ppUser/proofpic/' . $fileNameNew;
                move_uploaded_file($proofFileTmpName, $fileDestination);

                // Insert payment method into 'payments' table
                $payMethod = mysqli_real_escape_string($con, $_POST['payMethod']);
                $payId = getPayId($payMethod);

                foreach ($selectedParcels as $parcel) {
                    $trackingNumber = mysqli_real_escape_string($con, $parcel->trackingNumber);

                    /*// Update proof of payment location and payid in 'parcel' table
                    $updateParcelQuery = "UPDATE parcel SET proof = '$fileDestination', payid = '$payId', payStatus = 'PAID' WHERE trackingNumber = '$trackingNumber' AND studid = '$studid'";
                    if (mysqli_query($con, $updateParcelQuery)) {
                        echo "<script type='text/javascript'>alert('Proof of payment saved successfully for tracking number: $trackingNumber');</script>";
                    } else {
                        echo "<script type='text/javascript'>alert('Error: Could not update proof of payment location for tracking number: $trackingNumber.');</script>";
                    }*/
                    foreach ($selectedParcels as $parcel) {
                        $trackingNumber = mysqli_real_escape_string($con, $parcel->trackingNumber);
                    
                        // Update the parcel table
                        $stmt_parcel = $con->prepare("UPDATE parcel SET proof = ?, payid = ?, payStatus = 'PAID' WHERE trackingNumber = ? AND studid = ?");
                        $stmt_parcel->bind_param("ssss", $fileDestination, $payId, $trackingNumber, $studid);
                        $exec_parcel = $stmt_parcel->execute();
                        $stmt_parcel->close();
                    
                        if ($exec_parcel === false) {
                            die('Execute failed for parcel update: ' . htmlspecialchars($con->error));
                        }
                    
                        echo "<script type='text/javascript'>alert('Successfully updated');</script>";
                    }
                    
                
                }

                // Optionally redirect after successful operations
               // header('Location: ../../pages/student/studentPay.php');
            } else {
                echo "<script type='text/javascript'>alert('Your file is too big!');</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('There was an error uploading your file!');</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('You cannot upload files of this type!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Interface</title>
    <link rel="stylesheet" href="../../css/studpay.css">
</head>
<body>
    <div class="container">
        <div class="qr-code">
            <h3>Scan QR Code for Payment</h3>
            <img src="../../pictures/qrPay.jpg" alt="QR Code for Payment" style="max-width: 100%;">
        </div>
        <div class="payment-form">
            <h2>Pay Selected Parcels</h2>
            <div class="total-price">
                Total Price: <?php echo htmlspecialchars($totalPrice); ?>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <?php foreach ($selectedParcels as $index => $parcel): ?>
                    <input type="hidden" name="parcel[<?php echo $index; ?>]" value="<?php echo htmlspecialchars(json_encode($parcel)); ?>">
                <?php endforeach; ?>

                <div class="form-group">
                    <label for="payMethod">Payment Method:</label>
                    <select name="payMethod" id="payMethod" required>
                        <option value="CASH">CASH</option>
                        <option value="QR">QR</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="proofFile">Proof of Payment:</label>
                    <input type="file" name="proofFile" accept="proofFile/jpeg, proofFile/png, proofFile/jpg" id="proofFile" required>
                </div>
                <script>
                        let profilePic = document.getElementById("profile-pic");
                        let inputfile = document.getElementById("input-file");

                        inputFile.onchange = function(){
                            profilePic.src = URLcreateObjectURL(inputFile.files[0]);
                        }
                </script>


                <button type="submit">Submit Payment</button>
                <button onclick="window.location.href='../../pages/student/studentpage.php'" class="btn btn-primary">Back</button>
            </form>
        </div>
    </div>
</body>
</html>
