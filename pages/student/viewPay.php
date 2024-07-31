<?php
session_start();
include('../../config/config.php'); // Adjust path as necessary

// Ensure user is logged in
if (!isset($_SESSION['studid'])) {
    echo "User is not logged in.";
    exit();
}

// Retrieve parcels from the database
$query = "SELECT * FROM parcel WHERE studid = '".$_SESSION['studid']."' AND payStatus = 'UNPAID'";
$result = mysqli_query($con, $query);
$parcels = [];
while ($row = mysqli_fetch_assoc($result)) {
    $parcels[] = $row;
}



// Validate and sanitize page number
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    $page = 1;
}

// Define number of results per page
$results_per_page = 10;

// Calculate start index for pagination
$start_from = ($page - 1) * $results_per_page;

// Sanitize and prepare search query
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

// Fetch total records for the logged-in user
$studid = $_SESSION['studid'];

if (!empty($search_query)) {
    $total_query = "SELECT COUNT(*) AS total FROM parcel WHERE studid = '$studid' AND payStatus = 'UNPAID' AND (trackingNumber LIKE '%$search_query%' OR courname LIKE '%$search_query%' OR size LIKE '%$search_query%' OR status LIKE '%$search_query%' OR price LIKE '%$search_query%')";
} else {
    $total_query = "SELECT COUNT(*) AS total FROM parcel WHERE studid = '$studid' AND payStatus = 'UNPAID'";
}

$total_result = mysqli_query($con, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];

// Calculate total pages
$total_pages = ceil($total_records / $results_per_page);

// Fetch data for current page for the logged-in user
if (!empty($search_query)) {
    $query = "SELECT trackingNumber, courname, size, status, payStatus, price FROM parcel WHERE studid = '$studid' AND payStatus = 'UNPAID' AND (trackingNumber LIKE '%$search_query%' OR courname LIKE '%$search_query%' OR size LIKE '%$search_query%' OR status LIKE '%$search_query%' OR price LIKE '%$search_query%') LIMIT $start_from, $results_per_page";
} else {
    $query = "SELECT trackingNumber, courname, size, status, payStatus, price FROM parcel WHERE studid = '$studid' AND payStatus = 'UNPAID' LIMIT $start_from, $results_per_page";
}

$result = mysqli_query($con, $query);

// Fetch the unpaid parcels
$unpaidParcels = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Output results (e.g., in a table)
if (!$unpaidParcels) {
    echo "No unpaid parcels found for this user.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Unpaid Parcels</title>
    <link rel="stylesheet" href="../../css/viewpay.css">
    
</head>
<body>
    <div class="container">
        <h2>List of Unpaid Parcels</h2>
        <div class="search-container">
            <form method="get" action="viewPay.php">
                <input type="text" name="search" class="search-input" placeholder="Search parcels..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit" class="search-button">Search</button>
            </form>
        </div>
        <form method="post" action="studentPay.php" onsubmit="return validateSelection();">
            <?php if (!empty($unpaidParcels)) : ?> 
                <table>
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Tracking Number</th>
                            <th>Courier Name</th>
                            <th>Size</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($unpaidParcels as $parcel) : ?>
                            <tr>
                                <td>
                                    
                                    <div class="chip" onclick="toggleSelection(this)">
                                        
                                        <input type="checkbox" name="parcel[]" value="<?php echo htmlspecialchars(json_encode($parcel)); ?>">
                                        Select
                                    </div>
                                    <input type="hidden" name="action" value="<?php echo $parcelid ?>">
                                </td>
                                
                                <td><?php echo htmlspecialchars($parcel['trackingNumber']); ?></td>
                                <td><?php echo htmlspecialchars($parcel['courname']); ?></td>
                                <td><?php echo htmlspecialchars($parcel['size']); ?></td>
                                <td><?php echo htmlspecialchars($parcel['status']); ?></td>
                                <td><?php echo htmlspecialchars($parcel['payStatus']); ?></td>
                                <td><?php echo htmlspecialchars($parcel['price']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="message">No unpaid parcels found.</div>
            <?php endif; ?>
            <button type="submit" class="pay-button">Proceed to Payment</button>
            <button name="back" class="pay-button" onclick="window.history.back()">Back</button>
        </form>
        <div class="pagination">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo "<li><strong>$i</strong></li>";
                } else {
                    echo "<li><a href='viewPay.php?page=$i&search=" . urlencode($search_query) . "'>$i</a></li>";
                }
            }
            ?>
        </div>
    </div>
    <script>
        function toggleSelection(chip) {
            chip.classList.toggle('selected');
            const checkbox = chip.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
        }

        function validateSelection() {
            const selectedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            if (selectedCheckboxes.length === 0) {
                alert("Please select at least one parcel to pay.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
