<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <title>Test-DEV</title>
    </head>
    <body>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-6">
                <h1>Teste Dev</h1>
                <div>
                    <button class="btn btn-info btn-sm" name="novo" onclick="novo()" > Novo </button>
                </div>
                <div id="content">
                    
                </div>
            </div>
            <div class="col-sm-4"></div>
        </div>




        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        <script>
            $(function () {
                listaCarros();
                $('#novo').on('click',function(){
                alert(1)
            });
            });
            
            
            
            function excluir(id){
                
                $.ajax({
                    url: 'api/carros/'+id,
                    method: 'DELETE',
                    contentType: 'application/x-www-form-urlencoded',
                    success: function(result) {
                        listaCarros();
                    },
                    error: function(request,msg,error) {
                        console.log(request,msg,error)
                    }
                });
            }
            
            function novo(){
                $.get('novo',function(data){
                    $('#content').html(data);
                });
            }
            
            function edit(id){
        
                $.get('edit/'+id,function(data){
                    $('#content').html(data);
                });
                
            }
            
            function listaCarros(){
                var tableHeader = "<table class='table table-stripped'><thead><tr><th>ID</th><th>MARCA</th><th>MODELO</th><th>ANO</th><th>AÇÕES</th></tr><thead>";
                var tableBody = '<tbody>';
                var tableContent = ''; 
                $.get('{{route("lista_carros")}}',function(data){
                    var dados = data.data;
                    //console.log(dados);return false;
                    $(dados).each(function (key,item) {
                        //console.log(item[4]);return false;
                        var veiculo = item.split(',');
                        
                        tableContent += '<tr><td>'+veiculo[0]+'</td><td>'+veiculo[1]+'</td><td>'+veiculo[2]+'</td><td>'+veiculo[3]+'</td><td><button class="btn btn-info btn-sm" name="editar" id="editar" value='+veiculo[0]+' onclick="edit('+veiculo[0]+')">Editar</button>&nbsp;<button class="btn btn-danger btn-sm" name="excluir" id="excluir" value='+veiculo[0]+' onclick="excluir('+veiculo[0]+')">Excluir</button></td></tr>';
                    });
                    tableClosed = tableHeader+tableBody+tableContent+'</tbody></table>';
                    
                    $('#content').html(tableClosed);
                    
                });
            }
            
            
        </script>
    </body>
</html>