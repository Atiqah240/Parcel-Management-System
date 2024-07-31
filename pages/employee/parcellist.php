<?php
    session_start();
    include("../../config/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Parcels</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #111;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 20px 20px 0 0;
            font-size: 24px;
        }
        .header h1 {
            margin: 0;
            font-weight: 600;
        }
        .parcel-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .parcel-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            overflow: hidden;
            cursor: pointer;
        }
        .parcel-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
        }
        .parcel-card-content {
            padding: 20px;
        }
        .parcel-card-content h3 {
            margin-top: 0;
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }
        .parcel-details {
            color: #666;
            font-size: 14px;
        }
        .parcel-details p {
            margin: 5px 0;
        }
        .parcel-details strong {
            color: #111;
            font-weight: 600;
        }
        @media (max-width: 768px) {
            .container {
                border-radius: 0;
            }
        }
        .box{
                width: 50%;
                height: 30px;
                margin-top: 20px;
                margin-left: 250px;
                display: flex;
                cursor: pointer;
                padding: 15px 20px;
                background: #fff;
                border-radius: 20px;
                border: transparent;
                justify-content: center;
                align-items: center;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
                position: center;
            }
            .container box{
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 2rem;
            }
            .text-center {
                text-align: center;
            }

            .text-center .btn {
                margin: 20px;
                display: inline-block;
                padding: 0.75rem 1.5rem;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 1rem;
                text-decoration: none;
                transition: background-color 0.3s ease;
            }

            .text-center .btn:hover {
                background-color: #0056b3;
            }

            .text-center .btn:focus {
                outline: none;
            }

            .text-center .btn:active {
                transform: translateY(1px);
            }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>List of Parcels</h1>
        </div>
        <form method="POST">
            <input class="box" type="test" placeholder="Search Here..." name="search">
        </form>
        <div class="parcel-list">
        <?php
                if(isset($_POST['search'])){
                    $search=$_POST['search'];
                    $sql="SELECT * FROM parcel WHERE trackingNumber LIKE '%$search%'OR size LIKE '%$search%' OR courname LIKE '%$search%' OR price LIKE '%$search%' OR status LIKE '%$search%' OR payStatus LIKE '%$search%'";
                    $result1=mysqli_query($con, $sql);

                    if (mysqli_num_rows($result1) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result1)) {
                            echo '<div class="parcel-card">';
                            echo '<div class="parcel-card-content">';
                            //echo "<td><img src='" . htmlspecialchars($row["ppStud"]) . "' alt='Profile Picture'></td>";
                            echo '<h3>' . htmlspecialchars($row["trackingNumber"]) . '</h3>';
                            echo '<div class="parcel-details">';
                            echo '<p><strong>Size</strong> ' . htmlspecialchars($row["size"]) . '</p>';
                            echo '<p><strong>Courier:</strong> ' . htmlspecialchars($row["courname"]) . '</p>';
                            echo '<p><strong>Status:</strong> ' . htmlspecialchars($row["status"]) . '</p>';
                            echo '<p><strong>Payment Status:</strong> ' . htmlspecialchars($row["payStatus"]) . '</p>';
                            echo '<p><strong>Price: RM</strong> ' . htmlspecialchars($row["price"]) . '</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '';
                        }
                    } else {
                        echo '<p style="text-align: center; margin-top: 20px;">No parcels found.</p>';
                    }
                }
            ?>
            <div class="parcels-list">
            <?php
                // Fetch all parcel data from the database
                $query = "SELECT parcelid, size, trackingNumber, courname, status, price, payStatus, proof FROM parcel";
                $result = mysqli_query($con, $query);

                // Check if any rows were returned
                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="parcel-card">';
                        echo '<div class="parcel-card-content">';
                        //echo "<td><img src='" . htmlspecialchars($row["proof"]) . "' alt='Profile Picture'></td>";
                        echo '<h3>' . htmlspecialchars($row["trackingNumber"]) . '</h3>';
                        echo '<div class="parcel-details">';
                        echo '<p><strong>Size</strong> ' . htmlspecialchars($row["size"]) . '</p>';
                            echo '<p><strong>Courier:</strong> ' . htmlspecialchars($row["courname"]) . '</p>';
                            echo '<p><strong>Status:</strong> ' . htmlspecialchars($row["status"]) . '</p>';
                            echo '<p><strong>Payment Status:</strong> ' . htmlspecialchars($row["payStatus"]) . '</p>';
                            echo '<p><strong>Price: RM</strong> ' . htmlspecialchars($row["price"]) . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p style="text-align: center; margin-top: 20px;">No parcels found.</p>';
                }
            ?>
        </div>
        </div>
        <div class="text-center">
            <button onclick="window.history.back()" class="btn btn-primary">Back</button>
            <button onclick="window.print()" class="btn btn-primary">Print</button>
        </div>
    </div>
</body>
</html>
