<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
?>

<?php 
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
    }else{
        header("location: users.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chatroom</title>
    <link rel="stylesheet" href="./chatroom.css">
</head>
<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <a href="#" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="php/images/<?php echo $row['icon']; ?>" alt="">
                <div class="details">
                    <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
                    <p><?php echo $row['status']; ?></p>
                </div>
            </header>
            
            <a href="user_list.php"><i class='fas fa-arrow-left'></a>
                
            //display the user informaion
            <img src="icon.jpg" alt="">
            <div class="details">
                <span>USERNAME</span>
            </div>
                
            <div class="chat-box">

                <div class="chat outgoing">
                    <div class="details">
                        <p>This is the chat content from you</p>
                    </div>
                </div>

                <div class="chat incoming">
                    <img src="" alt="icon">
                    <div class="details">
                        <p>This is the chat content from your friend</p>
                    </div>
                </div>

                <div class="chat outgoing">
                    <div class="details">
                        <p>This is the chat content from you</p>
                    </div>
                </div>

                <div class="chat incoming">
                    <img src="" alt="icon">
                    <div class="details">
                        <p>This is the chat content from your friend</p>
                    </div>
                </div>

            </div>

            <form action="#" class="typing-area">
                <input type="text" name="out_id" value="<?php echo $_SESSION['unique_id']?>" hidden>
                <input type="text" name="in_id" value="<?php echo $user_id?>" hidden>
                <input type="text" name="message" placeholder="Type a message here..." autocomplete="off">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>
<script src="javascript/users.js"></script>
</body>
</html>
