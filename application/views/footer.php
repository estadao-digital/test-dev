
<div id="id_loaderajax" class="loderajax hidden">
    <div class="content-loaderajax">
        <img src="<?= base_url("statics/load.gif") ;?>">
    </div>
</div>

<script>

    $(function(){

        $(".btn-plus").click(function(){
            
            $("#id_loaderajax").removeClass("hidden");
           
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
        });
        
        $(".btn-voltar").click(function(){
            $("#id_loaderajax").removeClass("hidden");

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
        });
        
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
        
    })
</script>
</body>
</html>