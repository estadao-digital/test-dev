$(document).ready(function(){
    $("#salvar").click(function(){
        alert(1);
        var myform = document.getElementById("formCarro");
        var fd = new FormData(myform );
        $.ajax({
            url: "/carros",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (dataofconfirm) {
                alert('sucesso');
                $("#result").innerHTML('Carro adicionado com sucesso');
                $("#result").attr['class', 'col-12 mt-3'];
            }
        });
    });
});


