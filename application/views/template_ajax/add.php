<div class="col-md-9 centered content-add widget">
	
	<form id="formAdd" action="<?= base_url().'/api/slice/carros';?>" class="col-md-9 centered" method="post">
		<label for="marca">Marca</label>
		<div class="form-group col-md-12" style="padding-left: 0;">
			
			<select name="marca" id="marca" required="required" class="form-control" >
				<option value="">Selecione uma opção…</option>
				<?php
				foreach($selectmarcas as $row):
				?>
				<option value="<?= $row->id; ?>"><?= $row->name; ?></option>
				<?php
				endforeach;
				?>
			</select>
		</div>
		
		<div class="form-group">
			<label for="modelo">Modelo</label>
			<input type="text" class="form-control" name="name" id="name" required="required" placeholder="Modelo">
		</div>
		
		<div class="form-group">
			<label for="ano">Ano</label>
			<input type="text" class="form-control" name="ano" id="ano" required="required" placeholder="Ano">
		</div>
		
		<div class="form-group align-center">
			<button type="button"  class="btn btn-danger btn-voltar"><i class="icon-chevron-left" ></i> Voltar</button>
			<button type="submit"  id="salvar" class="btn btn-success btn-delete">Salvar</button>
		</div>
	</form>
	
	<script>

        $(function(){

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

            $('#formAdd').on('submit', function(e){
                // validation code here
                e.preventDefault();
                $("#id_loaderajax").removeClass("hidden");

                $.ajax({
                    url: "<?= base_url().'api/slice/carros'; ?>",
                    type: "POST",
                    data: "name="+$("#name").val()+"&marca="+$("#marca").val()+"&ano="+$("#ano").val(),
                    dataType: "json",
                    success: function(data){
                        alert("Salvo com sucesso!")
                        if(data['name'].length > 0){
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
	</script>
</div>

