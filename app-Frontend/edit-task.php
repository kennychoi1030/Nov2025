<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["role"]) || !isset($_SESSION["id"])) {
    header("Location: ../app-Frontend/login.php");
    exit(); // Stop script execution
} else if (isset($_SESSION["role"]) && ($_SESSION["role"] == 'admin' || $_SESSION["role"] == 'employee')) {
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Edit User</title>
    <link rel="stylesheet" href="../app-Frontend/css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    
    <?php include '../app-Frontend/include/header.php'; ?>
    
    <div class="body">
    <?php include '../app-Frontend/include/nav.php'; ?>



        <section class="section-1">
            <h4 class="title">Edit Task  <a href="../app-Frontend/tasks.php">Back to Task</a></h4>
            
            <form class="form-1" method="POST" action="../app/update-task.php">

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
                    <label>Title</label>
                    <input type="text" class="input-1" name="title" value="<?=$task['title']?>" placeholder="title"><br>
                </div>
                <div class="input-holder">
                    <label>Description</label>
                    <input type="text" class="input-1" name="description" value="<?=$task['description']?>" placeholder="description"><br>
                </div>
                <div class="input-holder">
                    <label>Snooze</label>
                    <input type="date" class="input-1" name="due_date" value="<?=$task['due_date']?>" placeholder="Snooze"><br>
                </div>
                <!--
                <div class="input-holder">
                    <label>Status</label>                    
                    <textarea type="text" class="input-1" name="status"  row="4" placeholder="status"></textarea>
                    <br>
                </div>
                -->
                <div class="input-holder">
                    <label>Assigned to</label>
                    <select name="assigned_to" class="input-1">
                        <option value="0">Select user</option>

                        <?php if(!empty($users)) { 
                            foreach($users as $user) {
                                if($task['assigned_to'] == $user['id']){ ?>
                                    <option value="<?=$user['id']?>"><?=$user['full_name']?></option>

                                <?php }else{ ?>
                            
                            <option value="<?=$user['id']?>"><?=$user['full_name']?></option>
                        <?php }} ?>


                        
                    </select>
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
}}
?>