<?php 
    session_start();
    include_once "configuration.php";
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    if(!empty($email) && !empty($password)){
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email ='{$email}' AND password = '{$password}'");
        $sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email ='{$email}'");
        if(mysqli_num_rows($sql2)>0){
            if(mysqli_num_rows($sql)>0){
                $row = mysqli_fetch_assoc($sql);
                $status = "Online";
                $sql2 = mysqli_query($conn,"UPDATE users SET status = '{$status}' WHERE unique_id={$row['unique_id']} ");
                if($sql2){
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "success";
                }
            }else{
                echo "Email or Password is incorrect!";
            }
        }else{
            echo "This account does not exist!";
        }
    }else{
        echo "All fields are required!";
    }
?>