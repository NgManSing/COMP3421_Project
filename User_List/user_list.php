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

// Query database for user icon
$result = mysqli_query($link, "SELECT icon, caption FROM users WHERE id = '".$_SESSION['id']."'");
$currentuser = mysqli_fetch_array($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Together</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./user_list.css">
</head>
<body>
    <div class="wrapper">
        <section class="user-page">

            <!-- User Account Information -->
            <div class="my-account">
                <div class="my-account-info">
                    <?php echo '<img src="'.$currentuser["icon"].'" alt="'.$_SESSION['username'].'" class="image-icon">'; ?>
					<div class="content">
                        <div class="username"><?php echo $_SESSION['username']?></div>
                        <div id="caption"><?php echo empty($currentuser["caption"])?"Welcome to use Chat Together!":$currentuser["caption"];?><span><button id="pen-button" onclick="clicked_pen()"><i class="fa fa-pencil"></i></button></span></div>
                        <p><i class="fa fa-circle" id="my-status-indicator"></i> &nbsp Active</p>
                    </div>
                </div>
                <div class="button">
                    <a id="logout-button" href="/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a> 
                </div>
            </div>

            <!-- Search -->
            <div class="search">
                <input type="text" placeholder="Enter name to search...." name="search" value="<?php echo isset($search)?$search:""; ?>" onkeyup="showUsers(this.value)" id="search-input">
                <!-- <button type="submit"><i class="fa fa-search"></i></button> -->
            </div>

            <div class="user-list" id="user-list">
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
                                    if(empty($search) || str_contains($username, $search)){
                                        $counter += 1;
                                        $input = empty($caption)?"Welcome to use Chat Together!":$caption;
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

            <!-- The pop-up -->
            <div id="pop-up">

                <!-- pop-up content -->
                <div class="pop-up-content">
                    <form action="./change_caption.php" method="POST">
                        <div class="pop-up-header">
                            <h5>Edit Caption</h5>
                            <button type="button" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="input-group mb-3 ">
                            <input type="text" class="form-control" placeholder="New caption" name="new-caption">
                            <input class="btn btn-outline-secondary" type="submit" value="Submit">
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
</body>
<script src="user_list.js"></script>
</html>
