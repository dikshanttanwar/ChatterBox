<?php 
    include_once "configuration.php";
    $fname = mysqli_real_escape_string($conn,$_POST['fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['lname']);
    $fname = ucfirst($fname);
    $lname = ucfirst($lname);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){ // validate email
            //check mail already exist or not
            $sql = mysqli_query($conn,"SELECT email FROM users WHERE email='{$email}' ");
            if(mysqli_num_rows($sql)>0){ //if email already exist
                echo "Email already exist!";
            }
            else{
                if(isset($_FILES['image'])){
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

                            // inserting all the user data into the table
                            $sql2 = mysqli_query($conn,"INSERT INTO users (unique_id,fname,lname,email,password,img,status) VALUES ({$random_id},'{$fname}','{$lname}','{$email}','{$password}','{$newImageName}','{$status}')");
                            
                            if($sql2){ // if data inserted successfully

                                $sql3 = mysqli_query($conn,"SELECT * FROM users WHERE email='{$email}'");
                                if(mysqli_num_rows($sql3)>0){
                                    $row = mysqli_fetch_assoc($sql3);
                                    $_SESSION['unique_id'] = $row['unique_id'];
                                    echo "success";
                                }else{
                                    echo "Something went wrong!";
                                }
                            }
                        }
                    }else{
                        echo "Error : File extension should be - jpg,png,jpeg";
                    }


                }else{
                    echo "Please select file!";
                }
            }
        }
        else{
            echo "This email is not valid!";
        }
    }
    else{
        echo "All fields are required!";
    }
?>