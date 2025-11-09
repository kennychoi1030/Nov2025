<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["role"]) && !isset($_SESSION["id"])) {
    header("Location: ../app-Frontend/login.php");
    exit(); // Stop script execution
} else if (isset($_SESSION["role"]) && (/*$_SESSION["role"] == 'admin' ||*/ $_SESSION["role"] == 'employee')) {
    include('../app-SQL/DB_connection.php');
    include('../app-Backend/app/Model/User.php');
    $user = get_user_by_id($conn, $_SESSION['id']);


/*    
    if (!isset($_GET['id'])) {
        header("Location: tasks.php");
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
*/


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
            <h4 class="title">Profile<a href="../app-Frontend/edit-profile.php">Edit Profile</a></h4>
            <table class="main-table">
                <tr>
                    <td>FullName</td>
                    <td><?=$user['full_name'] ?> </td>
                </tr>
                <tr>
                    <td>username</td>
                    <td><?=$user['username'] ?> </td>
                </tr>
                <tr>
                    <td>Account create date</td>
                    <td><?=$user['created_at'] ?> </td>
                </tr>
            </table>


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