<?php
session_start();

if (isset($_SESSION["role"]) && isset($_SESSION["id"] )){
    

    if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['assigned_to']) && $_SESSION['role'] == 'admin' && isset($_POST['due_date'])) {
        
        

        include "../../app-SQL//DB_connection.php";
        //include('Model/User.php');
        //include('Model/Task.php');
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
        $id = validate_input($_POST['id']);
        $due_date = validate_input($_POST['due_date']);

        if (empty($title)) {
            $em = "Title is required";
            header("Location: ../../app-Frontend/tasks.php?error=$em&id=$id");
            exit();
        }
        else if (empty($description)) {
            $em = "Description is required";
            header("Location: ../../app-Frontend/tasks.php?error=$em&id=$id");
            exit();
        }else if ( $assigned_to == 0) {
            $em = "Select is required";
            header("Location: ../../app-Frontend/tasks.php?error=$em&id=$id");
            exit();        
        }else {
            //Check if the user exists
            include "../../app-Backend/Model/Task.php";   

            $data = array($title, $description, $assigned_to, $due_date ,$id );
            update_task($conn, $data);

            $em = "Task updated successfully";
            header("Location: ../../app-Frontend/tasks.php?success=$em&id=$id");
            exit();

            
        }
    } else {
        $em = "Unknown error occurred";
        header("Location: ../../app-Frontend/login.php?error=$em&id=$id");
        exit();
    }
}
?>