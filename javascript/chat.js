const form = document.querySelector("form"),
inputField = form.querySelector(".input-field"),
incoming_id = form.querySelector(".incoming_id"),
sendbtn = form.querySelector("button"),
clear_chat = document.querySelector(".clear-chat i"),
chatBox = document.querySelector(".chat-box");

clear_chat.onclick=()=>{
    if (confirm("Are you sure you want to Delete Chat? This action delete chat for everyone.")) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST",'php/clear_chat.php',true);
        xhr.onload=()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    // console.log(data);
                    if(data=="chatRemoved"){
                        location.reload();
                    }
                }
            }
        }
        let formdata = new FormData(form);
        xhr.send(formdata);
    }else{
        e.preventDefault();
    }
}

form.onsubmit=(e)=>{
    e.preventDefault();
};

function scrollToBottom() {
    setTimeout(() => {
        chatBox.scrollTop = chatBox.scrollHeight;
    }, 200); // Small delay to ensure proper scrolling
}

let senderCount = 0;
let receiverCount = 0;

sendbtn.onclick=()=>{
    scrollToBottom();
    let xhr = new XMLHttpRequest();
    xhr.open("POST",'php/insert-chat.php',true);
    xhr.onload=()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                inputField.value = "";
            }
        }
    }
    let formdata = new FormData(form);
    xhr.send(formdata);
}


setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST",'php/get-chat.php',true);
    xhr.onload=()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                // let data = xhr.response;
                let data = JSON.parse(xhr.response);
                if (data.senderCount > senderCount || data.receiverCount > receiverCount) {
                    scrollToBottom(); // Scroll only when new messages arrive
                }
                chatBox.innerHTML = data.messages;
                senderCount = data.senderCount;
                receiverCount = data.receiverCount; 

            }
        }
    }
    let formdata = new FormData(form);
    xhr.send(formdata);
}, 500);
