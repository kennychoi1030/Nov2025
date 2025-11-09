<?php
    setcookie(
        "session_id",          // Cookie 名稱
        "",                    // 空值
        time() - 3600,         // 過期時間設為過去（立即失效）
        "/",                   // 路徑
        "example.com",         // 域名
        true,                  // Secure 標誌
        true                   // HttpOnly 標誌
    );
    
    session_unset();
    session_destroy();
    
    header("Location: ../app-Frontend/login.php");
    exit();
?>