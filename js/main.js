function atualiza_tabela(){

}

function submit_form(){
  fetch("/test-dev/carros", {
    method: "POST",
    body: {'modelo':document.getElementsByName('modelo'),'ano':document.getElementsByName('ano'),'marca':document.getElementsByName('marca')}
  }).then(function(res){ return res; })
  .then(function(data){
    console.log(data) 
    BuidertableTable()
  
  
  });

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
function BuidertableTable(){
  fetch("/test-dev/carros", {
    method: "GET"}).then(function(res){ return res.json(); })
  .then(function(data){
    let tabela = document.getElementById('tabela_Carro').getElementsByTagName('tbody')[0] ;
    tabela.innerHTML = ''
    console.log(tabela);
    var string = ''
    for(let index=0;index< data.length; index++){
        string+='<tr><td>'+data[index]['id']+'</td><td>'+data[index]['marca']+'</td><td>'+data[index]['modelo']+'</td><td>'+data[index]['ano']+'</td><td>'+'<button class="btn btn-primary" onclick="editar('+data[index]['id']+')">Editar</button><button class="btn btn-danger" onclick="excluir('+data[index]['id']+')">Excluir</button>'+'</td><tr>';
    }
    tabela.innerHTML = string;
   });
}
function excluir(id){
  $("#modal_excluir").modal()
}
function editar(id){
  $("#modal_editar").modal()
}

