function atualiza_tabela(){

}

function submit_form(event){
  var form = new FormData(document.getElementById('login-form'));
  fetch("dev-test/carros", {
    method: "POST",
    body: form
  }).then(function(res){ return res.json(); })
  .then(function(data){ alert( JSON.stringify( data ) ) });

}

function update_data(){
  var form = new FormData(document.getElementById('login-form'));
  fetch("dev-test/carros", {
    method: "POST",
    body: form
  }).then(function(res){ return res.json(); })
  .then(function(data){ alert( JSON.stringify( data ) ) });

}

function destroy_data(id){
  var form = new FormData(document.getElementById('login-form'));
  fetch("dev-test/carros", {
    method: "POST",
    body: {'id':$id}
  }).then(function(res){ return res.json(); })
  .then(function(data){ alert( JSON.stringify( data ) ) });
}
function open_modal(modal,button,id){
    
}
