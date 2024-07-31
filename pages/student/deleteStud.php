<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
</head>
<body>
    <?php
    session_start();
    include '../../config/config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_SESSION['studid'])) {
            $studid = $_SESSION['studid'];

            if (isset($_POST['Delete'])) {
                // Begin a transaction
                $con->begin_transaction();

                try {
                    // Delete related records in the parcel table
                    $stmt1 = $con->prepare("DELETE FROM parcel WHERE studid = ?");
                    $stmt1->bind_param("s", $studid);
                    $stmt1->execute();
                    $stmt1->close();

                    // Delete the student record
                    $stmt2 = $con->prepare("DELETE FROM student WHERE studid = ?");
                    $stmt2->bind_param("s", $studid);
                    $stmt2->execute();
                    $stmt2->close();

                    // Commit the transaction
                    $con->commit();

                    // Redirect to mainPage.php after successful deletion
                    echo "<script>
                            alert('Successfully Deleted Account');
                            window.location.href = '../../pages/other/mainPage.php';
                          </script>";
                    exit();
                } catch (mysqli_sql_exception $exception) {
                    // Rollback the transaction in case of error
                    $con->rollback();

                    echo "<script>alert('Error: " . $exception->getMessage() . "');</script>";
                }

                $con->close();
            } else {
                echo "<script>alert('Delete Unsuccessful!');</script>";
            }
        } else {
            echo "<script>alert('Student ID is not set in the session.');</script>";
        }
    }
    ?>

    <form method="post" action="">
        <input type="submit" name="Delete" value="Delete Student Record">
    </form>
</body>
</html>
