<?php
    function get_all_users($conn){
        //$sql = "SELECT * FROM users where role = ?";
        $sql = "SELECT * FROM users WHERE role IN ('employee', 'admin')";
        $stmt= $conn->prepare($sql);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{$users = [];
        }
    return $users;
    }

    function email_exists($conn, $email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
    
        return $stmt->rowCount() > 0;
    }
    function insert_user($conn, $data){

        $email = $data[4]; // email 是 $data 數組的第 5 個元素

        // 檢查 email 是否已經存在
        if (email_exists($conn, $email)) {
            return "The email already exisit.";
        }

        $sql = "INSERT INTO users (full_name, username, password, role, email) VALUES(?,?,?,?,?)";
        $stmt= $conn->prepare($sql);
        $stmt->execute($data);
    }

    function update_user($conn, $data){
        $sql = "UPDATE users SET full_name=?, username=?, password=?, role=?, email=? WHERE id=?" ;
        $stmt= $conn->prepare($sql);
        $stmt->execute($data);
    }

    function delete_user($conn, $data){
        $sql = "DELETE FROM users WHERE id=? AND role=?";
        $stmt= $conn->prepare($sql);
        $stmt->execute($data);
    }

    function update_profile($conn, $data){
        $sql = "UPDATE users SET full_name=?, password=? WHERE id=?";
        $stmt= $conn->prepare($sql);
        $stmt->execute($data);
    }



    function get_user_by_id($conn, $id){
    $sql = "SELECT * FROM users WHERE id = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if($stmt->rowCount() > 0){
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }else $user = null;

    return $user;
    }

    function get_role_by_id($conn, $id){
        $sql = "SELECT * FROM users WHERE role = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
    
        if($stmt->rowCount() > 0){
            $role = $stmt->fetch(PDO::FETCH_ASSOC);
        }else $role = null;
    
        return $role;
        }


?>