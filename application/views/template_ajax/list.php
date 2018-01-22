<?php

$this->load->model("carromodel");
$selectcarros         = $this->carromodel->list_carros();

?>

<div class="col-md-9 centered" >
	<div class="widget box ">
		<div class="widget-header">
			<h4><i class="icon-reorder"></i>  </h4>
		</div>
		<div class="widget-content">
			<table id="carros" class="table table-striped table-bordered table-hover table-checkable">
				<thead>
				<tr>
					<th >Marca</th>
					<th >Modelo</th>
					<th >Ano</th>
					<th width="110" >Ações</th>
				</tr>
				</thead>
				<tbody>
				
				<?php
				//date('j/n/Y', 287182953);
				foreach($selectcarros as $key => $row):
					?>
					<tr>
						
						<td><?= $row->marcas->name; ?></td>
						<td><?= $row->name; ?></td>
						<td><?= $row->ano; ?></td>
						<td>
							
							<button type="button" data-id="<?= $row->id; ?>" class="btn btn-warning btn-edit"><i class="icon-edit"></i></button>
							<button type="button" data-id="<?= $row->id; ?>" class="btn btn-danger btn-delete"><i class="icon-remove"></i></button>
						</td>
					
					</tr>
					<?php
				endforeach;
				?>
				
				</tbody>
			</table>
		</div>
	</div>
	
	<script>

        $(function(){

            $(".btn-edit").click(function(){

                var id = $(this).attr("data-id");

                $("#id_loaderajax").removeClass("hidden");

                $.ajax({
                    url: "<?= base_url().'editcarro/'; ?>" + id + "",
                    type: "GET",
                    success: function(data){
                        $("#page_title").text("Editar modelo");
                        $(".btn-plus").attr("disabled", "disabled");
                        $(".widget").remove();
                        $(".centered").append(data);
                        $("#id_loaderajax").addClass("hidden");
                    },
                });
                return false;
            });
	        

            $('#carros').DataTable({
                "bLengthChange": false,
                oLanguage: {
                    oPaginate: {
                        "sNext": '<i class="fa fa-chevron-right" ></i>',
                        "sPrevious": '<i class="fa fa-chevron-left" ></i>'
                    }
                },
                "bInfo" : false,
                "columnDefs": [
                    { "targets": [1], "searchable": false }
                ]
            });

            $(".btn-delete").click(function(e){

                var id = $(this).attr("data-id");

                if( confirm('Deseja apagar?') ){

                    $.ajax({
                        url: "<?= base_url() . 'api/slice/carros'; ?>",
                        method: "DELETE",
                        // contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        data: "id=" + id ,
                        dataType: "json",
                        success: function (data) {
                            alert("Deletado com sucesso!")

                            $("#id_loaderajax").removeClass("hidden");

                            $.ajax({
                                url: "<?= base_url() . 'voltarcarro'; ?>",
                                type: "GET",
                                success: function (data) {
                                    $("#page_title").text("Listagem de Carros");
                                    $(".btn-plus").removeAttr("disabled");
                                    $(".centered").remove();
                                    $(".content-ajax").append(data);
                                    $("#id_loaderajax").addClass("hidden");
                                },
                            });
                        }
                    });

                } else {
                    
                    e.preventDefault();
                }
                
            });
        })
	</script>

</div>
