<?php
session_start();

if (isset($_SESSION["role"]) && isset($_SESSION["id"] )){

    if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['due_date']) && isset($_POST['assigned_to']) && $_SESSION['role'] == 'admin' ) {
        
        

        include "../../app-SQL/DB_connection.php";

        // Validate input
        


        function validate_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $title = validate_input($_POST['title']);
        $description = validate_input($_POST['description']);
        $assigned_to = validate_input($_POST['assigned_to']);
        $due_date = validate_input($_POST['due_date']);

        if (empty($title)) {
            $em = "Title is required";
            header("Location: ../../app-Frontend/create_Task.php?error=$em");
            exit();
        }
        else if (empty($description)) {
            $em = "Description is required";
            header("Location: ../../app-Frontend/create_task.php?error=$em");
            exit();
        }else if (($assigned_to)==0) {
            $em = "Select is required";
            header("Location: ../../app-Frontend/create_task.php?error=$em");
            exit();
        }else {
            // Check if the user exists
            include "Model/Task.php";
           // $password = password_hash($password, PASSWORD_DEFAULT);
            $data = array($title, $description, $assigned_to, $due_date);
            insert_task($conn, $data);

            $em = "Task Created successfully";
            header("Location: ../../app-Frontend/create_task.php?success=$em");
            exit();

            
        }
    } else {
        $em = "Unknown error occurred";
        header("Location: ../../app-Frontend/login.php?error=$em");
        exit();
    }
}
?>