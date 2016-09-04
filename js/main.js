function sendIdModal(id_carro){
   $('#confirm-del').attr('onclick','call_ajax("GET","carros/delete",'+id_carro+')');
}

function search_car(id){
    if(id == ''){
        alert("Insira o ID do carro!");
        return false
    }else{
        call_ajax('GET', 'carros', id);    
    }
    
}

function call_ajax(method, action, par){
    if(par == '' && method == 'GET'){
        var xhttp;
        if (window.XMLHttpRequest) {
        xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                document.getElementById("retorno_base").innerHTML = xhttp.responseText;
            }
        };

        xhttp.open("GET", "/"+action, true);
        xhttp.send();

        } else {
        // code for IE6, IE5
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
             xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                document.getElementById("retorno_base").innerHTML = xhttp.responseText;
            }
        };
        xhttp.open("GET", "/"+action, true);
        xhttp.send();
        }
    }else if(method == 'POST'){
        var id = document.getElementById("id").value;
        var marca = document.getElementById("marca").value;
        var modelo = document.getElementById("modelo").value;
        var ano = document.getElementById("ano").value;
        var xhttp;

        if (modelo == '' || ano == '') {

            alert('Preencha todos os campos!');
        }else{
            if(action == 'carros'){
                if (window.XMLHttpRequest) {
                xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                            document.getElementById("retorno_base").innerHTML = xhttp.responseText;
                        }
                    };
                xhttp.open("POST", "/"+action, true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("id="+id+"&marca="+marca+"&modelo="+modelo+"&ano="+ano);
            } else {
            // code for IE6, IE5
                xhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    xhttp.onreadystatechange = function() {
                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                            document.getElementById("retorno_base").innerHTML = xhttp.responseText;
                        }
                    };
                xhttp.open("POST", "/"+action, true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("id="+id+"&marca="+marca+"&modelo="+modelo+"&ano="+ano);
                }
            }else{
                if (window.XMLHttpRequest) {
                xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                            document.getElementById("retorno_base").innerHTML = xhttp.responseText;
                        }
                    };
                xhttp.open("POST", "/"+action+"/"+id, true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("id="+id+"&marca="+marca+"&modelo="+modelo+"&ano="+ano);
            } else {
            // code for IE6, IE5
                xhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    xhttp.onreadystatechange = function() {
                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                            document.getElementById("retorno_base").innerHTML = xhttp.responseText;
                        }
                    };
                xhttp.open("POST", "/"+action+"/"+id, true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("id="+id+"&marca="+marca+"&modelo="+modelo+"&ano="+ano);
                }
            }
        }
    }else if(method == 'GET'){
        var xhttp;
        if (window.XMLHttpRequest) {
        xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                document.getElementById("retorno_base").innerHTML = xhttp.responseText;
            }
        };

        xhttp.open("GET", "/"+action+"/"+par, true);
        xhttp.send();
        } else {
        // code for IE6, IE5
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
             xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                document.getElementById("retorno_base").innerHTML = xhttp.responseText;
            }
        };
        xhttp.open("GET", "/"+action+"/"+par, true);
        xhttp.send();
        }
    }
}

function insertNewCar() {
    var id = document.getElementById("id").value;
    var marca = document.getElementById("marca").value;
    var modelo = document.getElementById("modelo").value;
    var ano = document.getElementById("ano").value;
    var xhttp;

    if (modelo == '' || ano == '') {

        alert('Preencha todos os campos!');
    }else{
        if (window.XMLHttpRequest) {
        xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.getElementById("retorno_base").innerHTML = xhttp.responseText;
            }
        };
        xhttp.open("POST", "/carros", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id="+id+"&marca="+marca+"&modelo="+modelo+"&ano="+ano);
        } else {
        // code for IE6, IE5
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
         xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.getElementById("retorno_base").innerHTML = xhttp.responseText;
            }
        };
        xhttp.open("POST", "/carros", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id="+id+"&marca="+marca+"&modelo="+modelo+"&ano="+ano);
        }
    }
}

function updateCar(){
    var id = document.getElementById("id").value;
    var marca = document.getElementById("marca").value;
    var modelo = document.getElementById("modelo").value;
    var ano = document.getElementById("ano").value;
    var xhttp;
    if (window.XMLHttpRequest) {
    xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            document.getElementById("retorno_base").innerHTML = xhttp.responseText;
        }
    };
    xhttp.open("POST", "/carros/update/"+id, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id+"&marca="+marca+"&modelo="+modelo+"&ano="+ano);
    } else {
    // code for IE6, IE5
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
     xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            document.getElementById("retorno_base").innerHTML = xhttp.responseText;
        }
    };
    xhttp.open("POST", "/carros/update/"+id, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id+"&marca="+marca+"&modelo="+modelo+"&ano="+ano);
    }
}