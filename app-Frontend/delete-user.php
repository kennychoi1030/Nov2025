<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["role"]) || !isset($_SESSION["id"])) {
    header("Location: ../app-Frontend/login.php");
    exit(); // Stop script execution
} else if (isset($_SESSION["role"]) && ($_SESSION["role"] == 'admin' /*|| $_SESSION["role"] == 'employee'*/)) {
    include('../app-SQL/DB_connection.php');
    include('../app-Backend/app/Model/User.php');
    /*
    if (!isset($_GET['id'])) {
        header("Location: user.php");
        exit();
    }*/
    if (!isset($_GET['id'])) {
        echo "ID parameter is missing in the URL.";
        exit();
    }

    $id = $_GET['id'];
    
    $user = get_user_by_id($conn, $id);
    
    $data = array($id, "employee");
    delete_user($conn, $data);
    $sm = "Deleted successfully";
    header("Location: ../app-Frontend/user.php?success=$sm");
    exit();
    
} else {
    // If the role is invalid, redirect to login page
    header("Location: ../app-Frontend/login.php");
    exit();
}
?>