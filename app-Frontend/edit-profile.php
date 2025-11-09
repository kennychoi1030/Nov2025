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




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile</title>
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
            <h4 class="title">Edit Profile<a href="../app-Frontend/profile.php">Profile</a></h4>

            <form class="form-1" method="POST" action="../app-Backend/app/update-profile.php">

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
                    <label>Full Name</label>
                    <input type="text" class="input-1" name="full_name" value="<?=$user['full_name']?>" placeholder="Full Name"><br>
                </div>
                <div class="input-holder">
                    <label>Old Password</label>
                    <input type="password" class="input-1" name="password" placeholder="Old Password" 
                        value="" autocomplete="new-password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"  title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters"><BR>
                </div>
                <div class="input-holder">
                    <label>New Password</label>
                    <input type="password" class="input-1" name="new_password" placeholder="New Password" 
                        value="" autocomplete="new-password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"  title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters"><BR>
                </div>
                <div class="input-holder">
                    <label>Confirm Password</label>
                    <input type="password" class="input-1" name="confirm_password" placeholder="Confirm Password" 
                        value="" autocomplete="new-password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"  title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters"><BR>
                </div>


                

                <input type="text" name="id" value="<?=$user['id']?>" hidden>

                <button class="edit-btn">Change</button>
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