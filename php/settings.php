<?php 
    include_once "configuration.php";

    // if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $user_id  = $_POST['user_id'];
        $fname    = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lname    = mysqli_real_escape_string($conn, $_POST['lastname']);
        $email    = mysqli_real_escape_string($conn, $_POST['email']);
        $password = !empty($_POST['password']) ? $_POST['password'] : null;

        
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            // Prepare Update Query
            $update_query = "UPDATE users SET fname=?, lname=?, email=?";
            $params = [ucfirst($fname),ucfirst($lname), $email];
            $types  = "sss"; 
            if ($password) {
                $update_query .= ", password=?";
                $params[] = $password;
                $types .= "s";
            }

            // image update process
            if(isset($_FILES['image']) && $img_name = $_FILES['image']['name']>0){
                $img_name = $_FILES['image']['name']; // getting user image name
                $img_type = $_FILES['image']['type']; // getting user image type
                $tmp_name = $_FILES['image']['tmp_name']; // this temporary name is used to save/move file in our folder
                // let's explode image and get the extension jpg,png
                $img_explode = explode('.',$img_name);
                $img_ext = end($img_explode); // this will give us the extension of the image

                $extensions = ['png','jpeg','jpg'];
                if(in_array(strtolower($img_ext),$extensions) === true){ // if img ext matched with array extension
                    $time = time(); // this will return curret time..
                                    // we need this time because when we are uploading user img in our folder we rename user file with current time so all the image file will have a unique name

                    // let's move the user img to our particular folder
                    $newImageName = $time.$img_name;
                    if(move_uploaded_file($tmp_name,"images/".$newImageName)){
                        $status = "Online";
                        $random_id = rand(time(),10000000); // creating random id for user

                        // udpate the image data into the table
                        $update_query .= ", img=?";
                        $params[] = $newImageName;
                        $types .= "s";          
                    }
                }else{
                    echo "Error : File extension should be - jpg,png,jpeg";
                }
            }
        
            $update_query .= " WHERE unique_id=?";
            $params[] = $user_id;
            $types .= "i";

            $stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($stmt, $types, ...$params);
            mysqli_stmt_execute($stmt);
            if($stmt){
                echo "success";
            }
            else{
                echo "Something went wrong!";
            }
            mysqli_stmt_close($stmt);
        }
        else{
            echo "This email is not valid!";
        }

        // header("Location: settings.php?setting_id=$user_id");
        // exit();
        

        // Image Upload Handling
        // if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        //     $img_name = $_FILES['image']['name'];
        //     $img_tmp  = $_FILES['image']['tmp_name'];
        //     $img_size = $_FILES['image']['size'];

        //     $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        //     $allowed_ext = ['png', 'jpg', 'jpeg'];

        //     if (in_array($img_ext, $allowed_ext) && $img_size <= 2 * 1024 * 1024) { // Max 2MB
        //         $newImageName = time() . "_" . $user_id . "." . $img_ext;
        //         $image_path   = "images/" . $newImageName;

        //         if (move_uploaded_file($img_tmp, $image_path)) {
        //             // Delete old image if it's not the default
        //             if ($row['img'] !== "default.png") {
        //                 unlink("images/" . $row['img']);
        //             }

        //             // Update database with new image
        //             mysqli_query($conn, "UPDATE users SET img='$newImageName' WHERE unique_id='$user_id'");
        //         } else {
        //             echo "Error uploading the file!";
        //         }
        //     } else {
        //         echo "Invalid file! Only jpg, png, jpeg files under 2MB are allowed.";
        //     }
        // }

// 
    // }
?>