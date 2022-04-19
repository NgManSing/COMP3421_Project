<?php

// Start the session
session_start();

// Config Database
require_once "../config.php";

// Check if user is off-online, if yes, redirect to login page
if(!isset($_SESSION["online"]) || $_SESSION["online"] === false){
    header("location: /");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "GET"){

    // Store user input to search variable
    if(empty(trim($_GET["search"]))){
        $search = "";
    } else{
        $search = trim($_GET["search"]);
    }
}
?>

<!-- Friend Account Information -->
<div class="user-list">
    <?php
        // Query all users in the database
        $sql = "SELECT id, username, icon, email, caption FROM users WHERE id != ?";

        // Execute SQL
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = $_SESSION['id'];
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt, $id, $username, $icon, $email, $caption);
                $number_of_list = mysqli_stmt_num_rows($stmt);

                $counter = 0;
                // list all the query result
                for($x = 0; $x < $number_of_list; $x++){
                    if(mysqli_stmt_fetch($stmt)){
                        if(empty($search) || strpos($username, $search) !== false){
                            $counter += 1;
                            $input = empty($caption)?"":$caption;
                            echo 
                            '<a href="./redirect.php?id='.$id.'" class="accountbutton">
                                <div class="account">
                                    <div class="account-info">
                                        <img src="'.$icon.'" alt="'.$username.'" class="image-icon">
                                        <div class="content">
                                            <span class="username">'.$username.'</span>
                                            <p>'.$input.'</p>
                                        </div>
                                    </div>
                                </div>
                            </a>';
                        }
                    }
                }

                // Provide negative feedback when no user is found from the query
                if ($counter == 0){
                    echo "<h4>No user is found!</h4>";
                }
            }
        }

        mysqli_stmt_close($stmt);

    ?>
</div>
