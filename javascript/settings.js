const form = document.querySelector(".form form"),
updateBtn = form.querySelector(".button input"),
deleteBtn = form.querySelector(".buttonDelete input"),
imageDelete = form.querySelector(".photoFunctions input"),
errorText = form.querySelector(".error-txt");

form.onsubmit=(e)=>{
    e.preventDefault();
}

imageDelete.onclick=()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST",'php/deletePhoto.php',true);
    xhr.onload=()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = JSON.parse(xhr.response);
                console.log(data);
                // if(!(data === "photoRemoved")){
                //     // location.href = "settings.php?setting_id=142567152";
                //     errorText.textContent = data;
                //     errorText.style.display = "block";
                // }else{
                //     console.log("Error:");
                // }
            }
        }
    }
    let formdata = new FormData(form);
    xhr.send(formdata);
}


// Account Deleting program
deleteBtn.onclick=()=>{
    if (!confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
        e.preventDefault(); // Prevent form submission if user cancels
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST",'php/deleteAccount.php',true);
    xhr.onload=()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                console.log(data);
                if(data === "AccountDeleted"){
                    location.href = "users.php";
                }else{
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    }
    let formdata = new FormData(form);
    xhr.send(formdata);
}

// Account Updation program
updateBtn.onclick=()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST",'php/settings.php',true);
    xhr.onload=()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                console.log(data);
                if(data === "success"){
                    // location.href = "settings.php?setting_id=$user_id";
                    location.href = "users.php";
                }else{
                    errorText.textContent = data;
                    errorText.style.display = "block";

                }
            }
        }
    }
    let formdata = new FormData(form);
    xhr.send(formdata);
}

document.addEventListener("DOMContentLoaded", () => {
    const photoButton = document.getElementById("photoButton");
    const photoFunctions = document.querySelector(".photoFunctions");
    const passwordField = document.querySelector("input[name='password']");
    const togglePassword = document.querySelector(".toggle-password");

    // photoButton.addEventListener("click", (e) => {
    //     e.preventDefault();
    //     photoFunctions.style.display = photoFunctions.style.display === "block" ? "none" : "block";
    // });

    togglePassword.addEventListener("click", () => {
        passwordField.type = passwordField.type === "password" ? "text" : "password";
        togglePassword.classList.toggle("fa-eye");
        togglePassword.classList.toggle("fa-eye-slash");
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const imageUpload = document.getElementById("imageUpload");
    const profileImage = document.getElementById("profileImage");

    // When the user selects a file, display preview
    imageUpload.addEventListener("change", (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                profileImage.src = e.target.result; // Update preview
            };
            reader.readAsDataURL(file);
        }
    });
});

document.getElementById("photoButton").addEventListener("click", function(){
    document.querySelector(".photoFunctions").classList.toggle("show");
});

document.addEventListener("click", function (event) {
    let userButtons = document.querySelector(".changePhoto");
    if (!userButtons.contains(event.target)) {
        document.querySelector(".photoFunctions").classList.remove("show");
    }
});
