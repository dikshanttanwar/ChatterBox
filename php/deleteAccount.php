<?php 
    session_start();
    include_once "configuration.php";

    if(isset($_POST['user_id'])){

        $user_id  = intval($_POST['user_id']);

        $delete_query = "DELETE FROM users WHERE unique_id = ?";
        $stmt = mysqli_prepare($conn,$delete_query);        
        mysqli_stmt_bind_param($stmt,"i",$user_id);

        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);

            echo "AccountDeleted";
            session_unset();
            session_destroy();

        }
        else{
            echo "Delete nahi hua hai!";
        }
    }
    else{
        echo "INVALID USER!";
    }
?>