<?php 
    session_start();
    if(!isset($_SESSION['unique_id'])){
        header("location: login.php");
        exit();
    }
?>
<?php 
    include_once "header.php";
 ?>
<body>
    <div id="success-toast" class="toast">You have successfully logged in!</div>
    <div class="wrapper">
        <section class="users">
            <header>
                <?php
                    include_once "php/configuration.php";
                    $sql = mysqli_query($conn,"SELECT * FROM users WHERE unique_id={$_SESSION['unique_id']}");
                    if(mysqli_num_rows($sql)>0){
                        $row = mysqli_fetch_assoc($sql);
                    }   
                ?> 
                <div class="content">
                    <img src="php/images/<?php echo $row['img']?>" alt="">
                    <div class="details">
                        <span><?php echo $row['fname']. " " .$row['lname'] ?></span>
                        <p><?php echo $row['status'] ?></p>
                    </div>
                </div>
                <div class="userButtons">
                    <button id="menuButton"><i class="fa-solid fa-bars"></i></button>
                    <div class="userFunctions">
                        <a href="settings.php?setting_id=<?php echo $row['unique_id'] ?>" class="settings">
                            <i class="fa-solid fa-cog"></i> Settings
                        </a>
                        <a href="php/logout.php?logout_id=<?php echo $row['unique_id'] ?>" class="logout">
                            <i class="fa-solid fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </header>
            <div class="search">
                <span class="text">Select an user to start chat</span>
                <input type="text" placeholder="Enter name to search....">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">
                    
            </div>
        </section>
    </div>
    <script src="javascript/users.js"></script>

    <?php   
        
        // if(isset($_SESSION['loginSession'])){
        //     echo "<script>console.log('Login Session hai');</script>";
        // }else{
        //     echo "<script>console.log('login session nahi hai');</script>";
        // }
        // if (isset($_SESSION['login_success'])) {
                // echo "<script>console.log('script console');</script>";
        //     // echo "<script>
        //     //     document.addEventListener('DOMContentLoaded', function () {
        //     //         var toast = document.getElementById('success-toast');
        //     //         toast.classList.add('show');
        //     //         setTimeout(function () {
        //     //             toast.classList.remove('show');
        //     //         }, 2000);
        //     //     });
        //     //     console.log('User logged out successfully.');
        //     // </script>";
        //     // unset($_SESSION['login_success']); // ✅ Clear session flag after displaying toast

        // }
    ?>

</body>
</html>