<?php
session_start();

if (isset($_SESSION["role"]) && isset($_SESSION["id"] )){
    

    if (isset($_POST['id']) && isset($_POST['status'])  && $_SESSION['role'] == 'employee') {
        
        

        include "../../app-SQL/DB_connection.php";
        //include('Model/User.php');
        //include('Model/Task.php');
        // Validate input
        


        function validate_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
       
        $status = validate_input($_POST['status']);
        $id = validate_input($_POST['id']);

        if (empty($status)) {
            $em = "Status is required";
            header("Location: ../../app-Frontend/my_task.php?error=$em&id=$id");
            exit();
        }else {
            //Check if the user exists
            include "../../app-Backend/Model/Task.php";   

            $data = array($status, $id);
            update_task_status($conn, $data);

            $em = "Task updated successfully";
            header("Location: ../../app-Frontend/my_task.php?success=$em&id=$id");
            exit();

            
        }
    } else {
        $em = "Unknown error occurred";
        header("Location: ../../app-Frontend/login.php?error=$em&id=$id");
        exit();
    }
}
?>