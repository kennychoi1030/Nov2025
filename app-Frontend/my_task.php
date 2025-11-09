<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["role"]) || !isset($_SESSION["id"])) {
    header("Location: ../app-Frontend/login.php");
    exit(); // Stop script execution
} else if (isset($_SESSION["role"]) && ( $_SESSION["role"] == 'employee')) {
    include('../app-SQL/DB_connection.php');
    include('../app-Backend/app/Model/Task.php'); 
    include('../app-Backend/app/Model/User.php');
    $tasks = get_all_tasks_by_id($conn, $_SESSION["id"]);
    

    /* for testing
    print_r($users); 
    */


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">-->    <title>All task</title>
    <link rel="stylesheet" href="../app-Frontend/css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">

    <?php include '../app-Frontend/include/header.php'; ?>
    
    <div class="body">
    <?php include '../app-Frontend/include/nav.php'; ?>

                 


        <section class="section-1">
            <h4 class="title">My Tasks </h4>

            <?php if(isset($_GET['error'])){ ?>
                    <div class="danger" role="alert">
                        <?php echo stripcslashes($_GET['error']); ?>
                    </div>
                <?php } ?>
                <?php if(isset($_GET['success'])){ ?>
                    <div class="success" role="alert">
                        <?php echo stripcslashes($_GET['success']); ?>
                    </div>
                <?php } ?>

            <?php if($tasks != 0){ ?>
            <table class="main-table">
                <tr>
                    <th>#</th>
                    <th>title</th>
                    <th>description</th>
                    
                    <th>status</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
                <?php $i = 0; foreach($tasks as $task){ ?>



                    <tr>
                        <td><?=++$i?></td>
                        <td><?=$task['title']?></td>
                        <td><?=$task['description']?></td>
                        

                        
                        <td><?=$task['status']?></td>
                        <td><?=$task['due_date']?></td>

                        <td>
                            <a href="edit-task-employee.php?id=<?=$task['id']?>" class="edit-btn">Edit</a>
                            
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <?php }else{ ?>
                <h3>No users found</h3>
            <?php } ?>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
} else {
    // If the role is invalid, redirect to login page
    header("Location: ../app-Frontend/login.php");
    exit();
}
?>