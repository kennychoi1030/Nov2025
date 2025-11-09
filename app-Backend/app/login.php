<?php
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    include "../../app-SQL/DB_connection.php";

    // Validate input
    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate_input($_POST['email']);
    $password = validate_input($_POST['password']);

    if (empty($email)) {
        $em = "Email is required";
        header("Location: ../../app-Frontend/login.php?error=$em");
        exit();
    } else if (empty($password)) {
        $em = "Password is required";
        header("Location: ../../app-Frontend/login.php?error=$em");
        exit();
    } else {
        // Check if the user exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            $email = $user["email"];
            $passwordDB = $user["password"];
            $role = $user["role"];
            $id = $user["id"];
            $username = $user["username"];

            // Verify the password
            if (password_verify($password, $passwordDB)) {
                // Set session variables
                $_SESSION['role'] = $role;
                $_SESSION['id'] = $id; // Corrected session variable
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;

                $session_id = bin2hex(random_bytes(16)); // // 生成一個安全的會話 ID
                setcookie(
                    "session_id",          // Cookie 名稱
                    $session_id,           // Cookie 值（會話 ID）
                    time() + 3600,          // 過期時間（1 小時後）
                    "/",                   // 路徑（整個域名下可用）
                    "example.com",         // 域名
                    true,                  // 僅通過 HTTPS 傳輸（Secure 標誌）
                    true                   // 禁止 JavaScript 訪問（HttpOnly 標誌）
                );

                // 將會話 ID 存儲在服務端 Session 中
                $_SESSION['session_id'] = $session_id;

                // Redirect based on role
                if ($role == "admin" || $role == "employee") {
                    header("Location: ../../app-Frontend/index.php");
                    exit();
                } else {
                    $em = "Unknown role";
                    header("Location: ../../app-Frontend/login.php?error=$em");
                    exit();
                }
            } else {
                $em = "Invalid email or password";
                header("Location: ../../app-Frontend/login.php?error=$em");
                exit();
            }
        } else {
            $em = "Invalid email";
            header("Location: ../../app-Frontend/login.php?error=$em");
            exit();
        }
    }
} else {
    $em = "Unknown error occurred";
    header("Location: ../../app-Frontend/login.php?error=$em");
    exit();
}
?>