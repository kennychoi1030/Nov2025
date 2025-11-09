<?php

function insert_task($conn, $data){
        $sql = "INSERT INTO tasks (title, description, assigned_to, due_date) VALUES(?,?,?,?)";
        $stmt= $conn->prepare($sql);
        $stmt->execute($data);
    }

    function get_all_tasks($conn){
        $sql = "SELECT * FROM tasks";
        $stmt= $conn->prepare($sql);
        $stmt->execute([]);

        if($stmt->rowCount() > 0){
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{$tasks = [];
        }
    return $tasks;
    }
    function delete_task($conn, $data){
        $sql = "DELETE FROM tasks WHERE id=?";
        $stmt= $conn->prepare($sql);
        $stmt->execute($data);
    }
    function get_task_by_id($conn, $id){
        $sql = "SELECT * FROM tasks WHERE id = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
    
        if($stmt->rowCount() > 0){
            $task = $stmt->fetch(PDO::FETCH_ASSOC);
        }else $task = null;
    
        return $task;
        }
        
        function count_tasks($conn){
            $sql = "SELECT id FROM tasks";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
                            
            return $stmt->rowCount();
            }


        function update_task($conn, $data){
            $sql = "UPDATE tasks SET title=?, description=?, assigned_to=?, due_date=? WHERE id=? ";
            $stmt= $conn->prepare($sql);
            $stmt->execute($data);
        }

        function update_task_status($conn, $data){
            $sql = "UPDATE tasks SET status=? WHERE id=? ";
            $stmt= $conn->prepare($sql);
            $stmt->execute($data);
        }

        function get_all_tasks_by_id($conn, $id){
            $sql = "SELECT * FROM tasks WHERE assigned_to=?";
            $stmt= $conn->prepare($sql);
            $stmt->execute([$id]);
    
            if($stmt->rowCount() > 0){
                $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            }else{$tasks = [];
            }
        return $tasks;
        }

?>

