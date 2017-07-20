var userName = document.getElementById("name");
var userName2 = document.getElementById("name2");

userName.oninput = function() {
    userName2.value = this.value;
}


//Ajax Request
function ajaxRequest() {
    var request;
    try {
        request = new XMLHttpRequest();
    }catch(e1) {
        try {
            request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch(e2) {
            try {
                request = new ActiveXObject("Microsoft.XMLHTTP")
            } catch(e3) {
                request = false;
            }
        }
    }

    return request;
}

//Ajax
var form = document.forms.namedItem("form")

form.onsubmit = function(ev) {
   //console.log(ev);
    var url = this.action, callback = document.getElementById("callback"),data = new FormData(this),
    request = ajaxRequest(), loader = document.getElementById("loader");
    /*span = document.createElement("div"),
    text = document.createTextNode("X");
    span.appendChild(text)
    span.classList.add("cancel");
    span.id = "cancel";
    callback.appendChild(span);*/
    
    request.open("POST", url, true);
   
    request.upload.onprogress = function() {
        loader.style.display = "block";
    }

    request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            loader.style.display = "none";
            callback.style.display = "block";
            callback.innerHTML = this.responseText;

            callback.addEventListener("click", function(ev) {
                this.style.display = "none";
            })
        } 
    }

    request.send(data);

   ev.preventDefault();
}




