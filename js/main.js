
async  function submit_form(){
  await  fetch("/test-dev/carros", {
    method: "POST",
      headers : { 
        'Content-Type': 'application/json',
        'Accept': 'application/json'
       },    
    body:JSON.stringify({"modelo":document.getElementsByName('modelo')[0].value,"ano":document.getElementsByName('ano')[0].value,"marca":document.getElementsByName('marca')[0].value}),
  }).then(function(res){ return res.json(); })
  .then(function(data){
    console.log( data );
    atualiza_tabela();
    document.getElementsByName('modelo')[0].value='';
    document.getElementsByName('ano')[0].value='';
    document.getElementsByName('marca')[0].value='';
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    
    Toast.fire({
      type: 'success',
      title: data.message
    });
  
  });

}
async function update_data(id){
  await  fetch("/test-dev/carros/"+id, {
    method: "PUT",
      headers : { 
        'Content-Type': 'application/json',
        'Accept': 'application/json'
       },    
    body:JSON.stringify({"modelo":document.getElementsByName('modelo_edit')[0].value,"ano":document.getElementsByName('ano_edit')[0].value,"marca":document.getElementsByName('marca_edit')[0].value}),
  }).then(function(res){ return res.json(); })
  .then(function(data){
    console.log( data );
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    
    Toast.fire({
      type: 'success',
      title: data.message
    });
    $("#modal_editar").modal('hide');
    atualiza_tabela();
    document.getElementsByName('modelo_edit')[0].value='';
    document.getElementsByName('ano_edit')[0].value='';
    document.getElementsByName('marca_edit')[0].value='';
  
  });

}
function limpa_campos(){
  document.getElementsByName('modelo')[0].value='';
  document.getElementsByName('ano')[0].value='';
  document.getElementsByName('marca')[0].value='';
}

async function destroy_data(id){
  await  fetch("/test-dev/carros/"+id, {
    method: "DELETE",
      headers : { 
        'Content-Type': 'application/json',
        'Accept': 'application/json'
       },    
    body:JSON.stringify({"modelo":document.getElementsByName('modelo_edit')[0].value,"ano":document.getElementsByName('ano_edit')[0].value,"marca":document.getElementsByName('marca_edit')[0].value}),
  }).then(function(res){ return res.json(); })
  .then(function(data){
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    
    Toast.fire({
      type: 'success',
      title: data.message
    });
    $("#modal_excluir").modal('hide');
    atualiza_tabela();
  });
}




function atualiza_tabela(){
  fetch("/test-dev/carros", {
    method: "GET"}).then(function(res){ return res.json(); })
  .then(function(data){
  let tabela = document.getElementById('tabela_Carro').getElementsByTagName('tbody')[0] ;
  tabela.innerHTML = ''
  console.log(tabela);
  var string = ''
  
  for(let index=0;index< data.length; index++){
    marca=document.querySelector('#marca option[value="'+data[index]['marca']+'"]');
      string+='<tr><td>'+data[index]['id']+'</td><td>'+marca.innerHTML+'</td><td>'+data[index]['modelo']+'</td><td>'+data[index]['ano']+'</td><td>'+'<button class="btn btn-primary" onclick="editar('+data[index]['id']+')">Editar</button><button class="btn btn-danger" onclick="excluir('+data[index]['id']+')">Excluir</button>'+'</td><tr>';
  }
  tabela.innerHTML = string;
 });
}

function excluir(id){
  fetch("/test-dev/carros/"+id, {
    method: "GET"}).then(function(res){ return res.json(); })
  .then(function(data){
        document.getElementById('frase_excluir').innerHTML = 'Deseja excluir o '+ data[0]['modelo']+ '?';
     
   });
  btn_destroy= document.getElementById('btn_destroy').setAttribute('onclick','destroy_data('+id+')')
  $("#modal_excluir").modal()
}


function editar(id){
  fetch("/test-dev/carros/"+id, {
    method: "GET"}).then(function(res){ return res.json(); })
  .then(function(data){
          document.getElementsByName('marca_edit')[0].value=data[0]['marca']
          document.getElementsByName('modelo_edit')[0].value=data[0]['modelo']
          document.getElementsByName('ano_edit')[0].value=data[0]['ano']
   });
  btn_edit= document.getElementById('btn_edit').setAttribute('onclick','update_data('+id+')')
  $("#modal_editar").modal()
}
atualiza_tabela();
