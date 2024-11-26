<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();

    require_once "core/DBmanager.php";
    require_once "helpers/functions.php";
    require_once "models/auth.php";





    $user = auth();

    $pdo = new DBManager();

    $emp_id = $_GET['id']??NULL ;
    if (!$emp_id) {
        header("Location: employee.php", true, 404);
        exit;
    }
    
    $sql = "SELECT * FROM employee WHERE id=?";
    $emp = $pdo->query($sql, $emp_id)->fetch(PDO::FETCH_ASSOC);
    
    if (!$emp) {
        header("Location: employee.php", true, 404);
        exit;
    }
    
    // Handle form submission
    if (server()->isPostRequest()) {
        extract($_POST);
    
        // Ensure you include the WHERE clause
        $sql = "UPDATE `employee` SET fname=?, lname=?, email=?, phone=? WHERE id=?";
        $pdo->query($sql, $fname, $lname, $email, $phone, $emp_id);
    
        $_SESSION['done'] = ['Employee updated successfully!'];
        header('Location: employee.php');
        exit;
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>managment Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-dark h-100">

    <?php include "components/messages/errors.php" ?>
    <?php include "components/messages/success.php" ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">managment Website</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="employee.php">employee</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manager.php">manager</a>
                    </li>
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li> -->
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>

                </form>
                
                <a href="logout.php" class="btn btn-danger ms-2" >
                    Logout
                    <i class="fa-solid fa-right-from-bracket"></i>
 </a>
            </div>
        </div>
    </nav>

    <section class="h-100 mt-5">
        <div class="card w-100 bg-transparent text-light text-center border border-light">
            <div class="card-title text-start p-3 d-flex justify-content-between" style="align-items: baseline;">
                <h1>Add New employee</h1>
            </div>
            <div class="card-body text-start">
                <form action="empedit.php?id=<?= $emp_id ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" value="<?= $emp['fname'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" value="<?= $emp['lname'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $emp['phone'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $emp['email'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="picture" class="form-label">Picture</label>
                        <input type="text" class="form-control" id="picture" name="picture">
                        
                    </div>
                    <button type="submit" class="btn btn-primary">Update <i class="fa fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"
        integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>