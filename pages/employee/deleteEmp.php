<!DOCTYPE html>
<html>
<head>
    <title>Delete Employee</title>
</head>
<body>
    <?php
    session_start();
    include '../../config/config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_SESSION['empid'])) {
            $empid = $_SESSION['empid'];

            if (isset($_POST['Delete'])) {
                // Begin a transaction
                $con->begin_transaction();

                try {
                    // Delete related records in the parcel table
                    $deleteparcel = $con->prepare("DELETE FROM parcel WHERE empid = ?");
                    $deleteparcel->bind_param("s", $empid);
                    $deleteparcel->execute();
                    $deleteparcel->close();

                    // Delete the employee record
                    $deleteemp = $con->prepare("DELETE FROM employee WHERE empid = ?");
                    $deleteemp->bind_param("s", $empid);
                    $deleteemp->execute();
                    $deleteemp->close();

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
            echo "<script>alert('employee ID is not set in the session.');</script>";
        }
    }
    ?>

    <form method="post" action="">
        <input type="submit" name="Delete" value="Delete Employee Record">
    </form>
</body>
</html>
