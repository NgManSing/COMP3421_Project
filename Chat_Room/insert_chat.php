<?php 
    session_start();

       // Check if user is off-online, if yes, redirect to login page
    if(!isset($_SESSION["online"]) || $_SESSION["online"] === false){
      header("location: /");
      exit;
    }

    if(isset($_SESSION['unique_id'])){
        include_once "../config.php";

        $From_id = $_SESSION['id'];
        $To_id = $_SESSION['unique_id'];
        $message = mysqli_real_escape_string($link, $_POST['message']);
        $sql = "INSERT INTO messages (From_id, To_id, msg) VALUES ('{$From_id}', '{$To_id}', '{$message}')";

        if (mysqli_query($link, $sql)) {
            header("location: ./chatroom.php");
          } else {
            echo "System Error, contact web admin for further assistance." . $sql . "<br>" . $link->error;
          }
    }else{
        header("location: ../login.php");
    }


    
?>
