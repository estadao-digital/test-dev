$(".btn-plus").click(function(){

    $("#id_loaderajax").removeClass("hidden");
    $("#url_addcarro").val();

    $.ajax({
        url: "addcarro",
        type: "GET",
        success: function(data){
            $("#page_title").text("Adicionar novo modelo");
            $(".btn-plus").attr("disabled", "disabled");
            $(".widget").remove();
            $(".centered").append(data);
            $("#id_loaderajax").addClass("hidden");
        },
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
        },
    });
});

$(".btn-edit").click(function(){

    var id = $(this).attr("data-id");

    // $("#id_loaderajax").removeClass("hidden");
    $(".widget").remove();
});

$(".btn-delete").click(function(){

    var id = $(this).attr("data-id");

    // $("#id_loaderajax").removeClass("hidden");

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