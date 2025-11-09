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
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">-->
    <title>Manage User</title>
    <link rel="stylesheet" href="../app-Frontend/css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">

    <?php include '../app-Frontend/include/header.php'; ?>
    
    <div class="body">
    <?php include '../app-Frontend/include/nav.php'; ?>



        <section class="section-1">
            <h4 class="title">Manage Users <a href="../app-Frontend/add-user.php">Add User</a></h4>
            <?php if($users != 0){ ?>
            <table class="main-table">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                <?php $i = 0;
                    for ($j = 0; $j < count($users); $j++) {
                        $user = $users[$j];

                        // Skip the user with id = 1 (root admin)
                        if ($user['id'] == 1) {
                            continue;
                        } ?>



                    <tr>
                        <td><?=++$i?></td>
                        <td><?=$user['full_name']?></td>
                        <td><?=$user['username']?></td>
                        <td><?=$user['role']?></td>
                        <td><?=$user['email']?></td>
                        <td>
                            <a href="../app-Frontend/edit-user.php?id=<?=$user['id']?>" class="edit-btn">Edit</a>
                            <a href="../app-Frontend/delete-user.php?id=<?=$user['id']?>" class="delete-btn">Delete</a>
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