var url = "http://localhost:8080/api.php";

function post() {
    var marca = $("input[name=marca]").val();
    var modelo = $("input[name=modelo]").val();
    var ano = $("input[name=ano]").val();

    var obj = {
        'marca': marca,
        'modelo': modelo,
        'ano': ano
    };

    $.ajax({
        type: "POST",
        url: url,
        data: {
            'marca': marca,
            'modelo': modelo,
            'ano': ano
        }
    });
}

function get() {
    var ajax = new XMLHttpRequest();

    ajax.open("GET", "http://localhost:8080/api.php", true);

    ajax.send();

    ajax.onreadystatechange = function () {

        if (ajax.readyState == 4 && ajax.status == 200) {

            var data = ajax.responseText;

            alert(data);
        }
    }
}

get();