$(function () {
    var customfield_id = extract_url('last');

    if (customfield_id == 'create') {
        fill_form({
            title_page: 'Criar novo campo',
            'name': ''
        });
    } else if ($.isNumeric(customfield_id)) {
        $.post('ws/customfield/get', {id: customfield_id}, function (data) {
            if (data.error) {
                alert_box(data);
            } else {
                var data = data.customfield[0];
                data.title_page = 'Alterar campo';
                $("#type option[value="+data.type+"]").attr('selected','selected');
                $("#type").trigger('chosen:updated');
                if(data.options){
                    $("#type").prop('disabled', true);
                    $("#first").parent().remove();
                    for(var i in data.options){
                        /* if(i == 0){
                           $("#first").parent().remove();
                           addListField(data.options[i].value, true);
                        } else {
                            addListField(data.options[i].value);
                        } */
                        addListField(data.options[i].value, true, data.options[i].id);
                    }
                    $("#list :input").prop('required',true);
                    $('#list').show();
                }
                fill_form(data);
            }
        });
    } else {
        alert_box({error: ["Houve um erro ao recuperar os dados."]});
    }
    
    $('#type').change(function(){
        if($(this).val() === 'list'){
            $("#list :input").prop('required',true);
            $('#list').show();
        } else {
            $("#list :input").prop('required',false);
            $('#list').hide();
        }
    });

});

function fill_form(data) {
    var $customfield = $(".customfield"),
        customfield_id = extract_url('last'),
        output = '';

    output = fill_template($customfield, data);

    $customfield.html(output);

    $customfield.find('form').submit(function () {

        var data_form = $(this).serialize(),
            action = './ws/customfield/save';

        if ($.isNumeric(customfield_id)) {
            action = './ws/customfield/update';
            data_form = data_form + '&id=' + customfield_id;
        }

        $.post(action, data_form, function (data) {
            if (data.error) {
                alert_box(data);
            } else {
                localMsg(data.customfield);
                window.location = 'adm/customfield'
            }
        });

        return false;
    });
}

function removeListField(input){
    $(input).parent().remove();
}
function addListField(texto, noDeleted, id){
    var trash = '';
    
    if(!texto){
        texto = '';
    }
    if(id){
        id = '<input type="hidden" name="option_id[]" value="'+id+'">';
    } else {
        id = '';
    }
    if(!noDeleted){
        trash = '<span class="input-group-addon" onclick="removeListField(this)"><i class="fa fa-trash"></i></span>';
    }
    var output = '<div class="input-group" style="margin-top:10px"><span class="input-group-addon">Texto</span>'+id+'<input type="text" class="form-control" name="value[]" value="'+texto+'" required>'+trash+'</div>';
    $('#list .fields').append(output);
}