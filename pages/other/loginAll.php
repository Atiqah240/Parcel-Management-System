<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Choose Your Role</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 70vh;
            margin: 0;
            background-color: #BFACE2;
        }

        h1 {
            margin-top: 20px;
            font-size: 50px;
            color: black;
        }

        .container {
            display: flex;
            justify-content: center;
            gap: 70px;
            margin-top: 50px;
        }

        .role {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: black;
            width: 150px;
            height: 150px;
            justify-content: center;
            transition: transform 0.2s;
        }

        .role img {
            width: 50px;
            height: 50px;
        }

        .role p {
            margin: 10px 0 0 0;
            font-weight: bold;
        }
        .role:hover{
            transform: translateY(-10px);
        }
        .logo{
            width: 100px;
            margin-top: -25px;
            margin-left: -20px;
            cursor: pointer;
        }
        .navb{
            width: 90%;
            margin: auto;
            padding: 60px ;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <div class="navb">
        <a href="../../pages/other/mainPage.php">
        <img class="logo" src="../../pictures/logoParcel.png">
        </a>
    </div>
    <h1>Choose your role</h1>
    <div class="container">
        <a href="../../pages/admin/loginAdm.php" class="role">
            <img src="../../pictures/admin.png" alt="Admin Icon">
            <p>ADMIN</p>
        </a>
        <a href="../../pages/student/loginStud.php" class="role">
            <img src="../../pictures/customer.png" alt="Student Icon">
            <p>STUDENT</p>
        </a>
        <a href="../../pages/employee/loginEmp.php" class="role">
            <img src="../../pictures/employee.png" alt="Employee Icon">
            <p>EMPLOYEE</p>
        </a>
    </div>
</body>
</html>
