var uploadlimit = $("input#uploadlimit");
var videouploadlimit = $("input#videouploadlimit");
var mega = 1048576;
var mimes_aceitos = ["image/pjpeg", "image/jpeg", "image/gif", "image/png",
    "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    "application/excel", "application/vnd.ms-excel", "application/x-excel", "application/x-msexcel",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    "application/pdf", "application/msword", "application/vnd.ms-powerpoint",
    "application/vnd.openxmlformats-officedocument.presentationml.presentation"];

var imagens_aceitas = ["image/pjpeg", "image/jpeg", "image/gif", "image/png"];
var videos_aceitos = ["video/mp4"];

function checar(elemento, conj) {
    /*
     basics with video disabled  = 0
     basics with video enabled   = 1
     video only      = 2
     image only      = 3
     */

    if (typeof(conj) === 'undefined' || conj == false) {
        conj = 0;
    } else if (conj == true) {
        conj = 1;
    }

    if (conj == 1) {
        mimes_aceitos.push("video/mp4");
    } else if (conj == 2) {
        mimes_aceitos = videos_aceitos;
    } else if (conj == 3) {
        mimes_aceitos = imagens_aceitas;
    }

    var limit = null;
    var size_string = '';
    var dados = {};

    if (elemento.length > 0 && elemento[0].files.length > 0) {
         if (uploadlimit.length == 0 || videouploadlimit.length == 0 || uploadlimit.val() == '' || videouploadlimit.val() == '') {
             upvalue = 0.5;
             videoupvalue = 15;
         } else {
             upvalue = parseInt(uploadlimit.val()) / 1000;
             videoupvalue = parseInt(videouploadlimit.val()) / 1000;
         }

        if (mimes_aceitos.indexOf(elemento[0].files[0].type) == -1) {
            if (conj == 2) {
                dados.error = ["Arquivo inapropriado inserido no lugar de um vídeo. "];
            } else if (conj == 3) {
                dados.error = ["Arquivo inapropriado inserido no lugar de uma imagem. "];
            } else {
                dados.error = ["Tipos de arquivo não aceito"];
            }
            alert_box(dados);
            return false;
        } else {
            if (elemento[0].files[0].type == "video/mp4") {
                limit = videoupvalue;
                mensagem_inicio = "Não é permitido vídeo com mais de ";
            } else {
                limit = upvalue;
                mensagem_inicio = "Não é permitido arquivo com mais de ";
            }

            if (elemento[0].files[0].size > (limit * mega)) {
                if (limit < 1) {
                    size_string = (limit * 1000) + "Kb";
                } else {
                    size_string = limit + "Mb";
                }
                dados.error = [mensagem_inicio + size_string];
                alert_box(dados);
                return false;
            }

        }
    } else {
        //dados.error = ["Arquivo não carregado corretamente. "];
        //alert_box(dados);
        return true;
    }
    return true;
}