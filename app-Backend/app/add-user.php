<?php
session_start();

if (isset($_SESSION["role"]) && isset($_SESSION["id"] )){

    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['full_name']) && $_SESSION['role'] == 'admin') {
        
        

        include "../../app-SQL/DB_connection.php";
        include "../../app-Backend/app/Model/User.php";
        

        // Validate input
        


        function validate_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $email = validate_input($_POST['email']);
        $user_name = validate_input($_POST['username']);
        $password = validate_input($_POST['password']);
        $full_name = validate_input($_POST['full_name']);

        if (empty($full_name)) {
            $em = "Full name is required";
            header("Location: ../../app-Frontend/add-user.php?error=$em");
            exit();
        }
        else if (empty($user_name)) {
            $em = "User name is required";
            header("Location: ../../app-Frontend/add-user.php?error=$em");
            exit();
        }else if (empty($email)) {
            $em = "Email is required";
            header("Location: ../../app-Frontend/dd-user.php?error=$em");
            exit();
        }else if (empty($password)) {
            $em = "Password is required";
            header("Location: ../../app-Frontend/add-user.php?error=$em");
            exit();   
        }else if(email_exists($conn, $email)){
            $em = "Email already exists";
            header("Location: ../../app-Frontend/add-user.php?error=$em");
            exit();

        }else {
            // Check if the user exists
            
            $password = password_hash($password, PASSWORD_DEFAULT);
            $data = array($full_name, $user_name, $password, "employee", $email);
            insert_user($conn, $data);

            $em = "Created successfully";
            header("Location: ../../app-Frontend/add-user.php?success=$em");
            exit();

            
        }
    } else {
        $em = "Unknown error occurred";
        header("Location: ../../app-Frontend/add-user.php?error=$em");
        exit();
    }
}
?>