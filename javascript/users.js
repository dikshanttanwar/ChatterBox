let userList = document.querySelector(".users .users-list");
let searchBar = document.querySelector(".users .search input");
let menuBtn = document.querySelector(".users .userButtons button");
let menuIcon = document.querySelector(".users .userButtons button i");
let menuFunctions = document.querySelector(".users .userButtons .userFunctions");

document.getElementById("menuButton").addEventListener("click", function () {
    document.querySelector(".userFunctions").classList.toggle("show");
});

// Close dropdown if clicked outside
document.addEventListener("click", function (event) {
    let userButtons = document.querySelector(".userButtons");
    if (!userButtons.contains(event.target)) {
        document.querySelector(".userFunctions").classList.remove("show");
    }
});


searchBar.onkeyup=()=>{
    // console.log("KEYDOWN!!!!!!");
    let searchTerm = searchBar.value;
    if(searchTerm != ""){
        searchBar.classList.add("active");
        // console.log("Blank nahi hai");
    }else{
        searchBar.classList.remove("active");
        // console.log("Blank!");
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST",'php/search.php',true);
    xhr.onload=()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                userList.innerHTML = data;
                // console.log("Normal Data")
            }
        }
    }
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
}

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("GET",'php/users.php',true);
    xhr.onload=()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(!searchBar.classList.contains("active")){
                    userList.innerHTML = data;
                    // userList.innerHTML = "hello nothing found!";
                }
            }
        }
    }
    xhr.send();
}, 500);