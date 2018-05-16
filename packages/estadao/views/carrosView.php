<?php
class carrosView {
	
	
	function __construct() {
		
		$this->index();
		
		
	}
	
	function css() {
	    
	    $css = "

        .list-group-item.active {
             z-index: 2;
            color: #fff;
            background-color: #3a5777;
            border-color: #3a5777;
}
        body {
          background-color: #d2e7f9;
        }

        ";
	        
	       return $css;
	        
	    
	}
	
	
	function js() {
		
		
		$js = "

		function newCar() {
			
			$(\"#marca\").val('');
			$(\"#modelo\").val('');
			$(\"#cor\").val('');
			$(\"#placa\").val('');
			$(\"#ano\").val('');
			$(\"#idcarro\").val('');
			$(\"#remover\").hide('');
			$(\"#modal-container-766658\").modal();
			
		}

        function saveEditCar() {

            var urls = '" . config::siteRoot() . "/index.php/carros/' +  $(\"#idcarro\").val();
            
            car = new Object();
            car.marca =   $(\"#marca\").val();
			car.modelo =   $(\"#modelo\").val();
		    car.cor =   $(\"#cor\").val();
		    car.placa =   $(\"#placa\").val();
			car.ano =  $(\"#ano\").val();          

           

            urls = urls + '?' + $.param(car);
                $.ajax({
                	url: urls,
                	type: \"PUT\",
                	 
					
                	crossDomain: true,
                	contentType: \"application/json\",
                	processData: false,
                    
                     success: function (data) {
					$(\"#modal-container-766658\").modal('hide');
                    
					loadCars();								
					
				}
                });

        }

        function deleteCar() {
            var urls = '" . config::siteRoot() . "/index.php/carros/' +  $(\"#idcarro\").val(); 
              $.ajax({
                	url: urls,
                	type: \"DELETE\",
                	data: {},
                	crossDomain: true,
                	
                	processData: false,
                     success: function (data) {
					$(\"#modal-container-766658\").modal('hide');
                    
					loadCars();								
					
				}
                });
        
        }

		function saveCar() {
				var urls = '" . config::siteRoot() . "/index.php/carros/';				

				if ( $(\"#idcarro\").val() > 0 ) {
                    saveEditCar();
				
				} else {
                   
				
				$.ajax({
			    dataType: \"json\",
			    url: urls,
			    jsonCallback: 'json',
				type: 'POST',
			    data: { 
					marca:  $(\"#marca\").val(),
					modelo:  $(\"#modelo\").val(),
					cor:  $(\"#cor\").val(),
					placa:  $(\"#placa\").val(),
					ano:  $(\"#ano\").val()
				},
			    cache: false,
			    success: function (data) {
					$(\"#modal-container-766658\").modal('hide');
                    
					loadCars();								
					
				}
			});
			}

		}

		


		function editCar(idcarro) {
			$.ajax({
			    dataType: \"json\",
			    url: '" . config::siteRoot() . "/index.php/carros/' + idcarro,
			    jsonCallback: 'json',
			    data: { },
			    cache: false,
			    success: function (data) {
					
					$(\"#remover\").show('');
					$(\"#marca\").val(data.values.marca[0]);						
					$(\"#modelo\").val(data.values.modelo[0]);
					$(\"#cor\").val(data.values.cor[0]);
					$(\"#placa\").val(data.values.placa[0]);
					$(\"#ano\").val(data.values.ano[0]);
					$(\"#idcarro\").val(data.values.idcarro[0]);
					
					$(\"#modal-container-766658\").modal();				
	
				}
			});
		}


		function loadCars() {
	
			$.ajax({
			    dataType: \"json\",
			    url: '" . config::siteRoot() . "/index.php/carros/',
			    jsonCallback: 'json',
			    data: { },
			    cache: false,
			    success: function (data) {
					console.log(data);
					var size = data.values.idcarro.length;
					var i = 0;
					var code = '';
					for (i = 0; i < size; i++) { 
						
						code +=  '<h5 class=\"list-group-item-heading\"> <i class=\"far fa-edit\" onclick=\"editCar(' + data.values.idcarro[i] + ')\"></i> &nbsp;&nbsp;&nbsp;' + data.values.marca[i] + ' - ' + data.values.modelo[i] + ' ' + data.values.ano[i] + ' ' + data.values.cor[i] + '</h5>';
						 
					}
					$(\"#carList\").html(code);
	
				}
			});
		}
		$( document ).ready(function() {
			loadCars();
		});
	
		";
		
		return $js;
		
	}
	
	function index() {
		ini_set("allow_url_fopen", 1);
		$json = file_get_contents('http://fipeapi.appspot.com/api/1/carros/marcas.json');
		$marcas = json_decode($json,true);
		debug::log($marcas);
		
		$i=0;
		foreach ( $marcas as $m) {
			$carros[$i][0] = $m['fipe_name'];
			$carros[$i][1] = $m['fipe_name'];
			$i++;
		}
		
		
		$form = new formEasy();
		$form->id("carForm")->name("carForm")->method("post")->openform();
		$form->addSelect("Marca", 'marca', $carros, '');
		$form->addText("Modelo", 'modelo', '');
		$form->addText("Cor", 'cor', '');
		$form->addText("Placa", 'placa', '');
		$form->addText("Ano", 'ano', '');
		$form->type("hidden")->id('idcarro')->name('idcarro')->value('')->done();
		$htmlForm = $form->printform();
		
	$html = '
		<!DOCTYPE html>
		<head>
		<meta charset="UTF-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<script>' .
		$this->js()
		. '</script>
           <style>' .
           $this->css()
           . '</style>
		</head>
		<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			 
			
			<div class="modal fade" id="modal-container-766658" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="6565">
								
							</h5> 
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							' . $htmlForm . '
						</div>
						<div class="modal-footer">

							<button type="button" id="remover" onclick="deleteCar()" class="btn btn-danger">Remover</button>							 

							<button type="button" class="btn btn-primary" onclick="saveCar()">
								Salvar
							</button> 
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								Fechar
							</button>
						</div>
					</div>
					
				</div>
				
			</div>
			<br>
			<div class="btn-group" role="group">
				 
				<button class="btn btn-secondary" type="button" onclick="newCar()">
					Novo Carro
				</button> 
				
			</div>
			<br><br>
			<div class="list-group">
				 <a href="#" class="list-group-item list-group-item-action active">Carros</a>
				
				<div class="list-group-item" id="carList">
					
				</div>
				<div class="list-group-item justify-content-between">
					
				</div> <a href="#" class="list-group-item list-group-item-action active justify-content-between"></span></a>
			</div>
		</div>
	</div>
</div> ';
	
	page::addBody($html);
	page::renderAjax();
	
	}
	
	
	
}