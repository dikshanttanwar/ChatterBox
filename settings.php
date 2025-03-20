<?php
    session_start();
    include_once "php/configuration.php";

    if (!isset($_SESSION['unique_id'])) {
        header("Location: login.php");
        exit();
    }

    $setting_id = mysqli_real_escape_string($conn, $_GET['setting_id']);
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id={$setting_id}");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
    }
?>
<?php 
    include_once "header.php";
?>

<body>
    <div class="wrapper">
        <section class="form update">
            <div class="header">
                <button onclick="window.location.href='users.php'" class="back-button">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </div>
            <header>Settings</header>
            
            
            <form action="#" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?php echo $row['unique_id']; ?>">

                <div class="update">
                    <div class="photo-details">
                        <img id="profileImage" src="php/images/<?php echo $row['img'] ?: 'default.png'; ?>" alt="Profile Picture">
                        
                        <div class="changePhoto">
                            <button id="photoButton"><i class="fa-solid fa-camera"></i> Change Photo</button>
                            <div class="photoFunctions">

                                <!-- <button type="submit" name="deletePhoto"><i class="fa-solid fa-trash"></i> Remove Photo</button>  -->

                                <label for="imageDelete" class="uploadPhoto">
                                    <i class="fa-solid fa-trash"></i> Remove Photo
                                </label>
                                <input type="button" id="imageDelete" name="imageDelete" hidden>

                                <label for="imageUpload" class="uploadPhoto">
                                    <i class="fa-solid fa-upload"></i> Upload Photo
                                </label>
                                <input type="file" id="imageUpload" name="image" accept="image/*" hidden>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                
                <div class="error-txt errorUpdateForm">This is an error message!</div>

                <div class="field input firstNameform">
                    <label>First Name</label>
                    <input type="text" name="firstname" value="<?php echo $row['fname'] ?>" required>
                </div>
                <div class="field input">
                    <label>Last Name</label>
                    <input type="text" name="lastname" value="<?php echo $row['lname'] ?>" required>
                </div>
                <div class="field input">
                    <label>Email Address</label>
                    <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="New Password (optional)">
                    <i class="fas fa-eye toggle-password"></i>
                </div>
                <div class="field button">
                    <input type="submit" name="save_changes" value="Save Changes">
                </div>
                <div class="field buttonDelete">
                    <input type="submit" name="delete_account" value="Delete Account">
                </div>
            </form>

        </section>
    </div>
    <script src="javascript/settings.js"></script>
</body>
</html>
