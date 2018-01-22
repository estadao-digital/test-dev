<div class="col-md-9 centered content-edi widget">

    <form id="formEdit" action="<?= base_url().'/api/slice/carros';?>" class="col-md-9 centered" method="post">
		<label for="marca">Marca</label>
		<div class="form-group col-md-12" style="padding-left: 0;">
			
			<select name="marca" id="marca"  class="form-control" >
				<option value="">Selecione uma opção…</option>
				<?php
				foreach($selectmarcas as $row):
					?>
					<option value="<?= $row->id; ?>" <?= $row->id == $selectcarrosById->marcas->id ? "selected='selected'" : "" ?>><?= $row->name; ?></option>
					<?php
				endforeach;
				?>
			</select>
		</div>
		
		<div class="form-group">
			<label for="modelo">Modelo</label>
			<input type="text" class="form-control" name="name" id="name" value="<?= $selectcarrosById->name; ?>" placeholder="Modelo">
		</div>
		
		<div class="form-group">
			<label for="ano">Ano</label>
			<input type="text" class="form-control" name="ano" id="ano"  value="<?= $selectcarrosById->ano; ?>" placeholder="Ano">
		</div>
        
        <input type="hidden" id="id" name="id" value="<?= (int)$id; ?>">
		
		<div class="form-group align-center">
			<button type="button"  class="btn btn-danger btn-voltar"><i class="icon-chevron-left" ></i> Voltar</button>
			<button id="salvar" type="submit"  class="btn btn-warning btn-delete">Editar</button>
		</div>
	</form>
	
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
                    }
                });
            });
            
            $(".btn-voltar").click(function(){
                $("#id_loaderajax").removeClass("hidden");

                $.ajax({
                    url: "<?= base_url().'voltarcarro'; ?>",
                    type: "GET",
                    success: function(data){
                        $("#page_title").text("Listagem de Carros");
                        $(".btn-plus").removeAttr("disabled");
                        $(".centered").remove();
                        $(".content-ajax").append(data);
                        $("#id_loaderajax").addClass("hidden");
                    },
                });
            });

            $("#salvar").on("click", function(){

                $('#formEdit').on('submit', function(e){
                    // validation code here
                    e.preventDefault();
                    $("#id_loaderajax").removeClass("hidden");

                    var id = $("#id").val();
                    
                    $.ajax({
                        url: "<?= base_url().'api/slice/carros'; ?>",
                        method: "PUT",
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        data: "id=" + $('#id').val() + "&name=" + $("#name").val() + "&marca=" + $("#marca").val() + "&ano=" + $("#ano").val(),
                        dataType: "json",
                        success: function(data){
                            alert("Editado com sucesso!")
                            if(data['name'].length > 0){
                                $.ajax({
                                    url: "<?= base_url().'editcarro/'; ?>" + id + "",
                                    type: "GET",
                                    success: function(data){
                                        $("#page_title").text("Editar modelo");
                                        $(".btn-plus").attr("disabled", "disabled");
                                        $(".widget").remove();
                                        $(".centered").append(data);
                                        $("#id_loaderajax").addClass("hidden");
                                    }
                                });
                            }else{
                                alert("Erro ao salvar!")
                                $.ajax({
                                    url: "<?= base_url().'addcarro'; ?>",
                                    type: "GET",
                                    success: function(data){
                                        $("#page_title").text("Adicionar novo modelo");
                                        $(".btn-plus").attr("disabled", "disabled");
                                        $(".widget").remove();
                                        $(".centered").append(data);
                                        $("#id_loaderajax").addClass("hidden");
                                    }
                                });
                            }
                        }
                    });
                    return false;
                });

            })
        })
	</script>
</div>

