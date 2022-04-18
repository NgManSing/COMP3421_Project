<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php"
        $out_id = mysqli_real_escape_string($conn, $_POST['out_id']);
        $in_id = mysqli_real_escape_string($conn, $_POST['in_id']);
        $output = "";

        if(!empty($message)){
            $sql = mysqli_query($conn, "SELECT * FROM messages WHERE (out_msg_id = {$out_id} AND in_msg_id = {$in_id})
                                        OR (out_msg_id = {$in_id} AND in_msg_id = {$out_id}) ORDER BY msg_id DESC")
            if(mysqli_num_rows($sql)>0){
                while($row = mysqli_fetch_assoc($query)){
                    if($row['out_msg_id'] === $out_id){
                        $output .= '<div class = "chat out">
                                    <div class="details">
                                        <p> '. $row[msg] .'</p>
                                    </div>
                                    </div>';
                    }else{
                        $output .= '<div class = "chat in">
                                    <img src="img.jpg" alt="">
                                    <div class="details">
                                        <p> '. $row[msg] .'</p>
                                    </div>
                                    </div>';
                    }
                }
                echo $output;
            }
            
            


        }else{
            header("../login.php");
        }
    }

?>
