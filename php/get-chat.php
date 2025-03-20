<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "configuration.php";
        $outgoing_id = mysqli_real_escape_string($conn,$_POST["outgoing_id"]);
        $incoming_id = mysqli_real_escape_string($conn,$_POST["incoming_id"]);
        $output = "";
        
        $sql = "SELECT * FROM messages 
        LEFT JOIN users ON users.unique_id = messages.incoming_msg_id
        WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id}) OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id ASC ";

        $query = mysqli_query($conn,$sql);

        $senderMessage = 0;
        $receiverMessage = 0;

        if(mysqli_num_rows($query)>0){
            while($row = mysqli_fetch_assoc($query)){

                if($row['outgoing_msg_id'] === $outgoing_id){// he is a message sender
                    $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <p>'. $row['message'] .'</p>
                                    </div>
                                </div>';
                    $senderMessage++;
                }
                else{ // he is the message receiver
                    $output .= '<div class="chat incoming">
                    <img src="php/images/'. $row['img'].'" alt="">
                    <div class="details">
                    <p>'. $row['message'] .'</p>
                    </div>
                    </div>';
                    $receiverMessage++;
                }   

            }
            // echo $output;
            echo json_encode([
                "messages" => ($output ? $output : null),
                "senderCount" => $senderMessage,
                "receiverCount" => $receiverMessage
            ]);
        }

    }else{
        header('../login.php');
    }
?>