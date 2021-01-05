
function getDados(){

  $.ajax({
    type: 'GET',
    url: 'http://localhost:8000/api/veiculo',
    data: {get_param: 'value'},
    dataType: 'json',
    success: function (data) {
      var names = data      
      
      var tableTeste = document.getElementById('teste');
        
          names.forEach(e => {
          
          var newRow = tableTeste.insertRow();
  
          var newCarro = newRow.insertCell();
          var newText = document.createTextNode(e.id);
          newCarro.appendChild(newText);
  
          var newCarro = newRow.insertCell();
          var newText = document.createTextNode(e.Marca);
          newCarro.appendChild(newText);
  
          var newCarro = newRow.insertCell();
          var newText = document.createTextNode(e.Modelo);
          newCarro.appendChild(newText);
          
          var newCarro = newRow.insertCell();
          var newText = document.createTextNode(e.Ano);
          newCarro.appendChild(newText);
         
           var newCarro = newRow.insertCell();
         // newCarro.innerHTML += '<a  class="btn btn-primary btn-sm" onclick="preparaAtualiza('+e.id+')" id='+e.id+' role="button">Editar</a>';
          newCarro.innerHTML += '<a  class="btn btn-primary btn-sm" href="editarVeiculo.php?id='+e.id+'" id='+e.id+' role="button">Editar</a>';

          var newCarro = newRow.insertCell();
          newCarro.innerHTML += '<button class="btn btn-primary btn-sm" onclick="deleteVeiculo('+e.id+')"  role="button">Excluir</button>' ; 
        
      });
    }
  });  
}

function preparaAtualiza(id){

  var url = 'http://localhost:8000/api/veiculo/' + id;

  $.ajax({
    type: 'GET',
    url: url,
    data: {get_param: 'value'},
    dataType: 'json',
    success: function (data) {
      var names = data            

      document.getElementById('marca').value = names.Marca;
      document.getElementById('modelo').value = names.Modelo;
      document.getElementById('ano').value = names.Ano;  
    
  }
  });  
}

function atualizaVeiculo(){

  var id = document.getElementById('id').value;
  var marca = document.getElementById('marca').value;
  var modelo = document.getElementById('modelo').value;
  var ano = document.getElementById('ano').value;  
  
  url = 'http://localhost:8000/api/veiculo/'+id+'?Marca=' + marca + '&Modelo=' + modelo + '&Ano=' + ano ;

  $.ajax({
    type: 'PUT',
    url: url,
    data: {get_param: 'value'},
    dataType: 'json',
  }).always(function (resposta) {
    if(resposta.status == 200){
      alert('Alterado com sucesso!');
      window.location.href = "index.php";

    }else{

      alert ('Verique os dados');
    }
});
}

  function cadastraVeiculo(){

    var marca = document.getElementById('marca').value;
    var modelo = document.getElementById('modelo').value;
    var ano = document.getElementById('ano').value;  
    
    url = 'http://localhost:8000/api/veiculo/?Marca=' + marca+ '&Modelo=' + modelo + '&Ano=' + ano ;
  
    $.ajax({
      type: 'POST',
      url: url,
      data: {get_param: 'value'},
      dataType: 'json',
    }).always(function (resposta) {
      if(resposta.status == 200){
        
        alert('Cadastrado com sucesso!');
        window.location.href = "index.php";
  
      }else{
  
        alert ('Verique os dados');
      }
  });
        
}
   
function deleteVeiculo(id){

  var r = confirm("Você deseja realmente excluir o veículo selecionado?");
  
  if (r==true)
    {
      var url = 'http://localhost:8000/api/veiculo/' + id;

      $.ajax({
        type: 'DELETE',
        url: url,
        data: {get_param: 'value'},
        dataType: 'json',
      }).always(function (resposta) {
        if(resposta.status == 200){
          alert ('Veículo excluído com sucesso!');
          window.location.href = "index.php";
    
        }else{
    
          alert ('Veículo não excluído');
          window.location.href = "index.php";
        }
    });
    }
    
}













       



