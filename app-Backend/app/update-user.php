<?php
session_start();



if (isset($_SESSION["role"]) && isset($_SESSION["id"] )){

    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['full_name']) && isset($_POST['email']) && $_SESSION['role'] == 'admin') {
        
        

        include "../../app-SQL/DB_connection.php";

        // Validate input
        


        function validate_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $user_name = validate_input($_POST['username']);
        $password = validate_input($_POST['password']);
        $full_name = validate_input($_POST['full_name']);
        $id = validate_input($_POST['id']);
        $email = validate_input($_POST['email']);
        $role = validate_input($_POST['role']);

        if (empty($full_name)) {
            $em = "Full name is required";
            header("Location: ../../app-Frontend/edit-user.php?error=$em&id=$id");
            exit();
        }
        else if (empty($user_name)) {
            $em = "User name is required";
            header("Location: ../../app-Frontend/edit-user.php?error=$em&id=$id");
            exit();
        }
        else if (empty($email)) {
            $em = "Email is required";
            header("Location: ../../app-Frontend/edit-user.php?error=$em&id=$id");
            exit();

        }else if (empty($password)) {
            $em = "Password is required";
            header("Location: ../../app-Frontend/edit-user.php?error=$em&id=$id");
            exit();        
        }else if (empty($role)) {
            $em = "Role is required";
            header("Location: ../../app-Frontend/edit-user.php?error=$em&id=$id");
            exit(); 
        }else {
            // Check if the user exists
            include "../../app-Backend/Model/User.php";
            $password = password_hash($password, PASSWORD_DEFAULT);
            $data = array($full_name, $user_name, $password,$role, $email, $id);
            
            update_user($conn, $data);
            $em = "Update successfully";
            header("Location: ../../app-Frontend/edit-user.php?success=$em&id=$id");
            exit();

            
        }
    } else {
        $em = "Unknown error occurred";
        header("Location: ../../app-Frontend/edit-user.php?error=$em");
        exit();
    }
}
?>