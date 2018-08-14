$(document).ready(function(){
    iconpost();
    $('#lista-avatares').DataTable( {
        "processing": true,
        "serverSide": true,
        "searching": false,
        "bSort" : false,
        "aaSort" : false,
        "language": {
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":    "Último",
                "sNext":    "Seguinte",
                "sPrevious": "Anterior"
            },
            "lengthMenu": "_MENU_ linhas por página",
            "sInfo": "",
            "sInfoEmpty":     "Mostrando registros de 0 até 0 de un total de 0 linhas",
            "sInfoFiltered":  "(filtrado de um total de _MAX_ linhas)",
        },
        "ajax": "./ws/useravatar/get_by_page",
        "columnDefs": [
            {
                "render": function ( data, type, row ) {
                    if (data == 'nnn') {
                        return "";
                    } else if (data){
                        return "<div id=\"divavatar"+data["id"]+"\"><a class=\"pl\" onclick=\"deleteavatar("+data["id"]+")\">"+
                            "<span class=\"delete-avatar\" data-id=\""+data["id"]+"\"><i class=\"fa fa-trash\"></i></span>"+
                            "<img src=\""+data["img"]+"\" alt=\"\">"+
                            "</a></div>";
                    }

                },
                "targets": [0,1,2,3,4,5]
            },
        ]
    } );


    function activaTab(tab){
        console.info('sss3');
        $('.nav-pills a[href="' + tab + '"]').tab('show');
    };

    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&]*)').exec(window.location.href);
        if(results){
            return results[1] || 0;
        }
    }

    var tab = decodeURIComponent($.urlParam('tab'));
    if(tab) {
        console.info('ddd'+tab);
        activaTab(tab);
    }
});

$(function () {
        $('[data-toggle="tooltip"]').tooltip({
                html: true,
                title: '<p style="text-align: left;padding: 7px 7px 1px 7px;">Esta função do Beedoo, ativa a criação e gestão automática de canais para os líderes e seus liderados. Os canais automáticos são gerenciados pelo sistema, não podendo ser editados ou excluídos. Caso a função for desativada, todos os canais serão excluídos e os dados serão perdidos.</p>'
            });

    $('.upload-avatar').hide();
    $('button#save-new').hide();
    function readFilecustom(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.upload-avatar').addClass('ready');
                $uploadCropCustom.croppie('bind', {
                    url: e.target.result
                }).then(function () {
                    console.log('custom');
                    $('#upload-avatar > .cr-slider').show();

                });

            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $uploadCropCustom = $('#upload-avatar').croppie({
        viewport: {
            width: 120,
            height: 120,
            type: 'circle'
        },
        boundary: {
            width: 120,
            height: 120
        },
        enableExif: true
    });

    $('#save-new').click(function () {
        $uploadCropCustom.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            $('.now_loading').show();
            $.ajax({
                url: 'ws/custom/save_avatar',
                type: 'POST',
                data: {img: resp},
                success: function (response) {
                    $('.now_loading').hide();
                    if (response.error) {
                        alert_box(response.error);
                    } else {
                        location.reload();
                        localMsg(response);
                        window.location = 'adm/custom?tab=#avatar'
                    }
                }
            });
        });
    });

    $('#input-avatar').on("change", function () {
        $('.upload-avatar').show();
        readFilecustom(this);
    });

    var data = me();
    var team_id = data.team_id;

    useravatar();

    $.post('ws/custom/get', function (data) {
        $.each(JSON.parse(data["visiblefields"]), function (i, item) {
            if (typeof(item.nid) == "undefined") {
                item.nid = 1;
            }
            if (item == 1) {
                $("input[type='checkbox'][name=" + i + "]").prop('checked', true);
            }
        });


        data.logo = (data.logo == undefined) ? './assets/img/logo.png' : data.logo;
        data.color1 = (data.color1 == undefined) ? getHexColor($(".custom_color1").css('background-color')) : data.color1;
        data.color2 = (data.color2 == undefined) ? getHexColor($(".custom_color2").css('background-color')) : data.color2;

        $('#input-color1').val(data.color1);
        $('#input-color2').val(data.color2);
        $('#input-text').val(data.text);
        (data.uploadlimit) ? ($('#input-uploadlimit').val(data.uploadlimit)) : ($('#input-uploadlimit').val("500"));
        (data.videouploadlimit) ? ($('#input-videouploadlimit').val(data.videouploadlimit)) : ($('#input-uploadlimit').val("15000"));
        $('#input-urlad').val(data.urlad);
        $('#input-domainad').val(data.domainad);
        $('#preview').append('<label for="input-logo"><img src="' + data.logo + '" class="img-thumbnail"></label>');

        if (data.workingaccess == 1) {
            $(".workingaccess_yes").addClass('active').find('input').attr('checked', 'checked');
        } else {
            $(".workingaccess_not").addClass('active').find('input').attr('checked', 'checked');
        }

        if (data.channel_leader == 1) {
            $(".channel_leader_yes").addClass('active').find('input').attr('checked', 'checked');
        } else {
            $(".channel_leader_not").addClass('active').find('input').attr('checked', 'checked');
        }


        if (data.blockdm == 1) {
            $(".active-blockdm").addClass('active').find('input').attr('checked', 'checked');
        } else {
            $(".inactive-blockdm").addClass('active').find('input').attr('checked', 'checked');
        }

        if (data.statusad == 1) {
            $(".active-statusad").addClass('active').find('input').attr('checked', 'checked');
        } else {
            $(".inactive-statusad").addClass('active').find('input').attr('checked', 'checked');
        }

        return false;
    });

    $('.btn-send').click(function (event) {
        $('.now_loading').show();
        event.preventDefault();
        var form = document.getElementById('customLayout');
        var data = new FormData(form);

        $.ajax({
            url: 'ws/custom/save',
            data: data,
            processData: false,
            type: 'POST',
            contentType: false,
            beforeSend: function (x) {
                if (x && x.overrideMimeType) {
                    x.overrideMimeType("multipart/form-data");
                }
            },
            mimeType: 'multipart/form-data',
            success: function (response, textStatus) {
                $('.now_loading').hide();
                var data = $.parseJSON(response);
                if (data.error) {
                    alert_box(data);
                } else {
                    localMsg(data);
                    window.location = 'adm/custom'
                }
            },
             error: function(response) {
                 window.location = 'adm/custom';
             }
        });
    });
    blueimp_load();

    $('.btn-send-logo').click(function (event) {
        $('.now_loading').show();
        event.preventDefault();
        var form = document.getElementById('customLayout');
        var data = new FormData(form);

        $.ajax({
            url: 'ws/custom/save-logo',
            data: data,
            processData: false,
            type: 'POST',
            contentType: false,
            beforeSend: function (x) {
                if (x && x.overrideMimeType) {
                    x.overrideMimeType("multipart/form-data");
                }
            },
            mimeType: 'multipart/form-data',
            success: function (response, textStatus) {
                $('.now_loading').hide();
                var data = $.parseJSON(response);
                if (data.error) {
                    alert_box(data);
                } else {
                    window.location = 'adm/custom?tab=#logo'
                }
            },
            error: function(response) {
                window.location = 'adm/custom?tab=#logo';
            }
        });
    });

    window.onload = function () {
        $('.page_loading').hide();
    }


    $("button#new-avatar").click(function () {
        $(this).addClass('hide');
        $('#save-new').show();
        $('.item.avatar').find(".new-avatar").removeClass('hide').find("input").click();
    });
});


function blueimp_load(target) {
    var attrGallery = "[data-gallery]";
    var $target = (target != undefined) ? $(target).find(attrGallery) : $(attrGallery);

    $target.click(function (event) {
        event = event || window.event;
        var target = event.target || event.srcElement,
            link = target.src ? target.parentNode : target,
            options = {index: link, event: event};
        blueimp.Gallery($target, options);
        return false;
    });
}


function useravatar() {
    // var $item = $('.item.avatar');
    // var $list_avatar = $item.find('.list-avatar')
    // $.get('./ws/useravatar/get', function (data) {
    //     var $list_avatar = $item.find('.list-avatar'),
    //         list_avatar_output = '';
    //
    //     for (i in data.useravatar) {
    //         list_avatar_output += fill_template($list_avatar, data.useravatar[i]);
    //     }
    //
    //     $list_avatar.prepend(list_avatar_output);
    //
    // });
    // $list_avatar.find('a .delete-avatar').click(function () {
    //     var useravatar_id = $(this).attr('data-id');
    //     $(this).parent('a').remove();
    //     $.post('./ws/useravatar/delete', {id: useravatar_id});
    //     return false;
    // });
}


function iconpost(icon_default_id) {
    var $item = $('.item.icons'),
        icon_default_id = (icon_default_id == undefined) ? 1 : icon_default_id;

    $.get('./ws/iconpost/get', function (data) {
        var data = data.iconpost,
            $icon_default = $item.find('.icon-default'),
            $list_icon = $icon_default.find('.list-icon'),
            list_icon_output = '',
            icon_default_output = '',
            icon_default = null;

        for (i in data) {
            var icon = {
                list_iconpost_id: data[i].id,
                list_iconpost_src: data[i].src,
                span_delete: (data[i].id != 1) ? '<span class="delete-icon"><i class="fa fa-trash"></i></span>' : ''
            };

            if (data[i].id == icon_default_id) icon_default = {
                iconpost_id: data[i].id,
                iconpost_src: data[i].src
            };

            list_icon_output += fill_template($list_icon, icon, 'template-list-icon');
        }

        $list_icon.prepend(list_icon_output);

        icon_default_output += fill_template($icon_default, icon_default, 'template-icon');

        $icon_default.html(icon_default_output);

        $icon_default.find("button#new-icon").click(function () {
            $("button#new-icon").hide();

            $(".new-icon").removeClass('hide');

            $(".new-icon input").click();

        });

        $(".new-icon button#cancel-upload-icon").click(function () {

            $("button#new-icon").show();

            $(".new-icon #input-icon").val('').change();

            $icon_default.find('.list-icon').removeClass('hide');

            $icon_default.find('div:first').removeClass('hide');

            $(".new-icon").addClass('hide');

        });

        $icon_default.find('.list-icon a').click(function (e) {
            var iconpost_id = $(this).attr('href').replace("#", ''),
                iconpost_src = $(this).find('img').attr('src');

            if (e.target.localName != 'i' && e.target.localName != 'span') {
                $icon_default.find('div:first > img').attr('src', iconpost_src);
                $icon_default.find('div:first > #iconpost_id').val(iconpost_id);
            } else {
                $(this).remove();
                $.post('./ws/iconpost/delete', {id: iconpost_id});
                $icon_default.find('.list-icon a:first').click();
            }
            return false;
        });

        if (!icon_default) {
            $icon_default.find('.list-icon').addClass('hide');

            $icon_default.find('div:first').addClass('hide');

            $(".new-icon").removeClass('hide').removeClass('input-group').find('button').remove();
            $(".new-icon").removeClass('hide').removeClass('input-group').append('');
        }

    });
}
