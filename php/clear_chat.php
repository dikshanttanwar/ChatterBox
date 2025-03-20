<?php 
    session_start();
    include_once "configuration.php";

    if(isset($_SESSION['unique_id'])){

        $outgoing_id = mysqli_real_escape_string($conn,$_POST["outgoing_id"]);
        $incoming_id = mysqli_real_escape_string($conn,$_POST["incoming_id"]);

        $user_id  = intval($_POST['user_id']);
        // echo "$outgoing_id <br>";
        // echo $incoming_id;

        $deleteChat_query = "DELETE from messages WHERE (outgoing_msg_id = ? AND incoming_msg_id = ?) OR (outgoing_msg_id = ? AND incoming_msg_id = ?)";
        $stmt = mysqli_prepare($conn,$deleteChat_query);        
        mysqli_stmt_bind_param($stmt,"iiii",$outgoing_id,$incoming_id,$incoming_id,$outgoing_id,);

        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);

            echo "chatRemoved";
        }
        else{
            echo "chatNotRemoved!";
        }
    }
    else{
        echo "INVALID USER!";
    }
?>