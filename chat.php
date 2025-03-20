<?php 
    session_start();
    if(!isset($_SESSION['unique_id'])){
        header("location: login.php");
    }
?>
<?php 
    include_once "header.php";
 ?>
<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <?php
                    include_once "php/configuration.php";
                    // if(!($incoming_id)){
                        // }
                           
                    $user_id = mysqli_real_escape_string($conn,$_GET['user_id']);
                    $sql = mysqli_query($conn,"SELECT * FROM users WHERE unique_id={$user_id}");
                    if(mysqli_num_rows($sql)>0){
                        $row = mysqli_fetch_assoc($sql);
                    }else{
                        header("Location: users.php");
                    }
                ?> 
                <a href="users.php" class="back-icon" ><i class="fas fa-arrow-left""></i></a>
                <img src="php/images/<?php echo $row['img'] ?>" alt="">
                <div class="details">
                    <span><?php echo $row['fname']. " " .$row['lname'] ?></span>
                    <p><?php echo $row['status'] ?></p>
                </div>
                <div class="clear-chat">
                    <i class="fas fa-trash-alt" title="Delete Chat"></i>
                </div>
            </header>
            <div class="chat-box">

                    <!-- all chats will be displayed here -->

            </div>
            <form action="#" class="typing-area" autocomplete="off">
                <input type="hidden" name="user_id" value="<?php echo $row['unique_id']; ?>">
                <input type="text" class="outgoing_id" name="outgoing_id" value="<?php echo $_SESSION['unique_id']; ?>" hidden>
                <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
                <input type="text" autocorrect="off" spellcheck="false" autofocus name='message' class='input-field' placeholder="Type a message here..."/>
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
            
        </section>
    </div>

    <script src="javascript/chat.js"></script>
</body>
</html>