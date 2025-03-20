const form = document.querySelector(".signup form"),
continuebtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-txt");

form.onsubmit=(e)=>{
    e.preventDefault();
}

continuebtn.onclick=()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST",'php/signup.php',true);
    xhr.onload=()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                console.log(data);
                if(data === "success"){
                    location.href = "login.php";
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