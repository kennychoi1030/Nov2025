
<?php
session_start();



if (isset($_SESSION["role"]) && isset($_SESSION["id"] )){

    if (isset($_POST['full_name']) && isset($_POST['password']) && isset($_POST['new_password']) && isset($_POST['confirm_password']) && $_SESSION['role'] == 'employee') {
        
        

        include "../../app-SQL/DB_connection.php";

        // Validate input
        


        function validate_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $full_name = validate_input($_POST['full_name']);
        $password = validate_input($_POST['password']);
        $new_password = validate_input($_POST['new_password']);
        $confirm_password = validate_input($_POST['confirm_password']);
        $id = $_SESSION["id"];
        

        if (empty($full_name)) {
            $em = "Full name is required";
            header("Location: ../../app-Frontend/edit-profile.php?error=$em");
            exit();
        }
        else if (empty($password) || empty($new_password) || empty($confirm_password)) {
            $em = "Password cannot empty";
            header("Location: ../../app-Frontend/edit-profile.php?error=$em");
            exit();
        }
        else if ($new_password != $confirm_password) { 
            $em = "New Password and Confirm Password do not match";
            header("Location: ../../app-Frontend/edit-profile.php?error=$em");
            exit();

        }else {
            // Check if the user exists
            include "../../app-Backend/Model/User.php";
            $user = get_user_by_id($conn, $id);
            if ($user){
                if (!password_verify($password, $user['password'])) {
                    $em = "Incorrect password";
                    header("Location: ../../edit-profile.php?error=$em");
                    exit();
                }else{
                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                }
            }

            $data = array($full_name, $new_password, $id);
            
            update_profile($conn, $data);
            $em = "Update successfully";
            header("Location: ../../app-Frontend/edit-profile.php?success=$em");
            exit();

            
        }
    } else {
        $em = "Unknown error occurred";
        header("Location: ../../app-Frontend/login.php?error=$em");
        exit();
    }
}
?>