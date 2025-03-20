<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        header("location: users.php");
        exit();
    }
?>
<?php 
    include_once "header.php";
?>
<body>
    <!-- <div id="logout-toast" class="toast">You have successfully logged out!</div> -->
    <div class="wrapper">
        <section class="form login">
            <header>Let’s Get You Started!</header>
            <form method="post">
                <div class="error-txt">This is an error message!</div>
                
                    <div class="field input">
                        <label>Email Address</label>
                        <input type="text" name='email' placeholder="Enter your email" required>
                    </div>
                    <div class="field input">
                        <label>Password</label>
                        <input type="password" name='password' placeholder="Enter your password" required>
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="field button">
                        <input type="submit" value="Continue to Chat" >
                    </div>
            </form>
            <div class="link">Not yet Signed up? <a href="index.php">Sign up Now</a></div>
        </section>
    </div>
    <script src="javascript/pass-hide-show.js"></script>
    <script src="javascript/login.js"></script>
    
</body>
</html>