<?php
session_start();
include ('../../config/config.php');
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Sompatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Search</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .box{
                width: 50%;
                height: 30px;
                display: flex;
                cursor: pointer;
                padding: 15px;
                background: #fff;
                border-radius: 20px;
                border: transparent;
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
        <div class="container my-5">
            <form method="POST">
                <input class="box" type="test" placeholder="Search Here..." name="search">
            </form>
            <div class="row print-container">
                <div class="container my-5">
                    <table class="table">
                        <?php
                            if(isset($_POST['search'])){
                                $search=$_POST['search'];
                                $sql="SELECT * FROM parcel WHERE courname LIKE '%$search%' OR size LIKE '%$search%' OR status LIKE '%$search%' OR payid LIKE '%$search%' ";
                                $result=mysqli_query($con, $sql);
                                if($result){
                                    if(mysqli_num_rows($result)>0){
                                        echo '<thead>
                                        <tr>
                                            <th>Parcel ID</th>
                                            <th>Courier</th>
                                            <th>Size</th>
                                            <th>Status</th>
                                            <th>Student ID</th>
                                            <th>Pay ID</th>
                                        </tr>
                                        </thead>';

                                        while($row=mysqli_fetch_assoc($result)){;
                                            echo '<tbody>
                                            <tr>
                                                <td>'.$row['parcelid'].'</td>
                                                <td>'.$row['courname'].'</td>
                                                <td>'.$row['size'].'</td>
                                                <td>'.$row['status'].'</td>
                                                <td>'.$row['studid'].'</td>
                                                <td>'.$row['payid'].'</td>
                                            </tr>
                                            </tbody>';
                                        }
                                    }
                                    else{
                                        echo '<h2 class=:text-danger>Data not found</h2>';
                                    }
                                }
                            }
                        ?>
                    </table>
                    <div class="text-center">
                            <button onclick="window.print()" class="btn btn-primary">Print</button>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>