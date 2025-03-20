<?php 
    session_start();
    include_once "configuration.php";

    if(isset($_POST['user_id'])){

        $user_id  = intval($_POST['user_id']);
        // echo $user_id;

        $deletePhoto_query = "UPDATE users SET img='/default.jpg' WHERE unique_id = ?";
        $stmt = mysqli_prepare($conn,$deletePhoto_query);        
        mysqli_stmt_bind_param($stmt,"i",$user_id);

        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);

            echo "photoRemoved";
            // session_unset();
            // session_destroy();
        }
        else{
            echo "photoNotRemoved";
        }
    }
    else{
        echo "INVALID USER!";
    }

    echo json_encode([
        "messages" => $output,
        "senderCount" => $senderMessage,
        "receiverCount" => $receiverMessage
    ]);
?>