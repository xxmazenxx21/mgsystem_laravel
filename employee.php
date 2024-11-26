<?php

require "core/DBmanager.php";
require   "models/employees.php";
require "helpers/functions.php";

    session_start();

    $user = auth();

    $pdo = new DBManager();
   

    $employees = [];

    
    $manager_id = $_GET['managerid'] ?? null;
    
    if ($manager_id) {
        
        $sql = "SELECT * FROM `employee` WHERE managerid = ?";
        $stmt = $pdo->query($sql, $manager_id);
    } else {
    
        $stmt = $pdo->query("SELECT * FROM `employee`");
    }
    
    $employees = $stmt->fetchAll(PDO::FETCH_CLASS, 'employee');
    //if ($employee) {
       
       // $filePath = __DIR__ . '/uploads/' . $employee['picture'];
       // if (file_exists($filePath)) {
       //     unlink($filePath); 
      // }  }
    
    if (server()->isGetRequest()) {
        if (!empty($_GET['action']) && $_GET['action'] == 'delete') {
            $employee_id = $_GET['id'];
            $sql = "DELETE FROM `employee` WHERE id=?";
            $stmt = $pdo->query($sql, $employee_id);
            if ($stmt->rowCount() <= 0) {
                $_SESSION['errors'] = ['No employee with this id!'];
            } else {
                $_SESSION['done'] = ['Employee deleted successfully!'];
            }
        }
    }
    
   

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>employee Website</title>
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
            <a class="navbar-brand" href="#">emplpyee Website</a>
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
    <form class="d-flex" method="GET" action="employee.php">
    <input class="form-control me-2" type="number" name="managerid" placeholder="Manager ID" aria-label="Manager ID">
    <button class="btn btn-outline-success" type="submit">Filter</button>
</form>

    <section class="h-100 mt-5">
        <div class="card w-100 bg-transparent text-light text-center border border-light">
            <div class="card-title text-start p-3 d-flex justify-content-between" style="align-items: baseline;">
                <h1>employees</h1>
                <a href="empcreate.php" class="btn btn-success">Add employee <i class="fa fa-plus"></i></a>
            </div>
            <div class="card-body">
                <table class="table table-dark">
                    <thead>
                        <tr class="table-light">
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Picture</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td><?= $employee->id ?></td>
                            <td><?= $employee->fname ?></td>
                            <td><?= $employee->lname ?></td>
                            <td><a href="mailto:<?= $employee->email ?>"><?= $employee->email ?></a></td>
                            <td><a href="tel:<?= $employee->phone ?>"><?= $employee->phone ?></a></td>
                            <td><img src="<?= 'uploads/' . $employee->picture ?>" width="50" height="50" alt="profile image"></td>
                            <td>
                            <a href="empedit.php?id=<?= $employee->id ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="employee.php?action=delete&id=<?= $employee->id ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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