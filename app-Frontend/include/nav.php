<nav class="side-bar">
            <div class="user-picture">
                <img src="../app-Frontend/images/Chill_Guy.jpg" alt="user">
                <h4> @<?=$_SESSION['username'] ?></h4>
            </div>
            <!--Employee nav Bar -->
            <?php
            if($_SESSION["role"] == 'employee'){
            ?>            
            <ul>
                
                <li>
                    <a href="../app-Frontend/my_task.php">  
                    <i class="bi bi-house"></i>
                    <span>My Task</span>
                    </a>
                </li>
                <li>
                    <a href="../app-Frontend/profile.php">                        
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                    </a>
                </li>
                
                
                <li>
                    <a href="../app-Frontend/logout.php">                        
                    <i class="bi bi-door-open"></i>
                    <span>Logout</span>
                    </a>
                </li>
            </ul>
        <?php }else if($_SESSION["role"] == 'admin'){ ?>
        <!-- admin nav bar -->
            <ul>
                
                <li>
                    <a href="../app-Frontend/user.php">
                        <i class="bi bi-people"></i>
                        <span>Manage User</span>
                    </a>
                </li>
                <li>
                    <a href="../app-Frontend/create_Task.php">
                    <i class="bi bi-person"></i>
                    <span>Create Task</span>
                    </a>
                </li>
                
                
                <li>
                    <a href="../app-Frontend/tasks.php">
                    <i class="bi bi-folder"></i>
                    <span>All Task</span>
                    </a>
                    
                </li>
                
                <li>
                    <a href="../app-Frontend/logout.php">
                    <i class="bi bi-door-open"></i>
                    <span>Logout</span>
                    </a>
                </li>
            </ul>
        <?php } ?>



</nav>