<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["role"]) || !isset($_SESSION["id"])) {
    header("Location: ../app-Frontend/login.php");
    exit(); // Stop script execution
} else if (isset($_SESSION["role"]) && ($_SESSION["role"] == 'admin' /*|| $_SESSION["role"] == 'employee'*/)) {
    include('../app-SQL/DB_connection.php');
    include('../app-Backend/app/Model/User.php');
    $users = get_all_users($conn);

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
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">-->    <title>Create Task</title>
    <link rel="stylesheet" href="../app-Frontend/css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">

    <?php include '../app-Frontend/include/header.php'; ?>
    
    <div class="body">
    <?php include '../app-Frontend/include/nav.php'; ?>



        <section class="section-1">
            <h4 class="title">Create Task </h4>

            <form class="form-1" method="POST" action="../app-Backend/app/add-task.php">

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
                    <input type="text" class="input-1" name="title" placeholder="Title"><br>
                </div>
                <div class="input-holder">
                    <label>Description</label>
                    <textarea type="text" row="4" class="input-1" name="description" placeholder="Title"></textarea>                   
                </div>
                <div class="input-holder">
                    <label>Due Date</label>
                    <input type="date" class="input-1" name="due_date" placeholder="Due Date"></area>                   
                </div>
                <div class="input-holder">
                    <label>Assigned to</label>
                    <select name="assigned_to" class="input-1">
                        <option value="0">Select user</option>

                        <?php if(!empty($users)) { 
                            foreach($users as $user) {
                            ?>
                            <option value="<?=$user['id']?>"><?=$user['full_name']?></option>
                        <?php } ?>


                        
                    </select>
                </div>
                <br>
                

                <button class="edit-btn">Create Task</button>
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
}
?>