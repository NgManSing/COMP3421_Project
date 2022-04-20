<?php 
    session_start();

    include_once "../config.php";

    // Check if user is off-online, if yes, redirect to login page
    if(!isset($_SESSION["online"]) || $_SESSION["online"] === false){
        header("location: /");
        exit;
    }

    if(!isset($_SESSION['unique_id'])){
        header("location: /");
    } else{
        $Friend_id = $_SESSION['unique_id'];
    }

    $sql = mysqli_query($link, "SELECT * FROM users WHERE id = {$Friend_id}");
    if(mysqli_num_rows($sql) > 0){
        $Friend_row = mysqli_fetch_assoc($sql);
    }else{
        header("location: /");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chatroom</title>
    <link rel="stylesheet" href="./chatroom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>
<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <a href="/"><i class="fa fa-angle-left"></i></a> 
                <img class="image-icon" src="<?php echo $Friend_row['icon']; ?>" alt="">
                <div class="details">
                    <p><?php echo $Friend_row['username'] ?></p>
                    <div id="friend-caption"><?php echo $Friend_row['caption'] ?></div>
                </div>
            </header>
                
            <div class="chat-box" id="msg-box"></div>

            <form action="./insert_chat.php" class="typing-area" method="post">
                <input class="input-field" type="text" name="message" placeholder="Type a message here..." autocomplete="off">
                <button type="submit"><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>
<script src="chatroom.js"></script>
</body>
</html>
