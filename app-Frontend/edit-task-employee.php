<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["role"]) && !isset($_SESSION["id"])) {
    header("Location: ../app-Frontend/login.php");
    exit(); // Stop script execution
} else if (isset($_SESSION["role"]) && (/*$_SESSION["role"] == 'admin' ||*/ $_SESSION["role"] == 'employee')) {
    include('../app-SQL/DB_connection.php');
    include('../app-Backend/app/Model/User.php');
    include('../app-Backend/app/Model/Task.php');
    
    if (!isset($_GET['id'])) {
        header("Location: ../app-Frontend/tasks.php");
        exit();
    }
   

    $id = $_GET['id'];
    $task = get_task_by_id($conn, $id);
    $users = get_all_users($conn);
    //echo "ID from URL: " . $id; // 調試訊息
    
    //print_r($user['username']); 
    if (!isset($_GET['id'])) {
        echo "ID parameter is missing in the URL.";
        exit();
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">-->    <title>Edit User</title>
    <link rel="stylesheet" href="../app-Frontend/css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    
    <?php include '../app-Frontend/include/header.php'; ?>
    
    <div class="body">
    <?php include '../app-Frontend/include/nav.php'; ?>



        <section class="section-1">
            <h4 class="title">Edit Task  <a href="../app-Frontend/my_task.php">Back to Task</a></h4>
            
            <form class="form-1" method="POST" action="../app-Backend/app/update-task-employee.php">

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

                <div class="input-holder">
                    <label></label>
                    <p><b>Title: </b><?=$task['title']?></p>
                </div>
                <div class="input-holder">
                    <label></label>
                    <p><b>Desciption: </b><?=$task['description']?></p>
                </div>
                
                <div class="input-holder">
                    <label>Status</label>
                    <select name="status" class="input-1">
                                    <option 
                                        <?php if($task['status'] == "pending") echo "selected"; ?>>Pending</option>
                                    <option     
                                        <?php if($task['status'] == "in_progress") echo "selected"; ?>>in_progress</option>
                                    <option 
                                        <?php if($task['status'] == "completed") echo "selected"; ?>>completed</option>
                    </select><br>
                </div>

                <br>
                
                <input type="text" name="id" value="<?=$task['id']?>" hidden>

                <button class="edit-btn">Update</button>
            </form>



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