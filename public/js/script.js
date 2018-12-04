var table = {
        build: function () {
            this.clear();
            $.each(cars.data, function (index, car) {
                var tr = $('<tr>');
                var btnline = table.btnLine.replace(/\{id\}/g, index);
                $.each(car, function (i) {
                    tr.append($('<td>', {text: car[i]}))
                });
                tr.append($('<td>').append(btnline));
                $("#table tbody").append(tr);
            });
            return this;
        }
        ,
        clear: function () {
            var trHeader = $('<tr>');
            trHeader.append($('<th>', {text: 'Marca', scope: 'col'}))
                .append($('<th>', {text: 'Modelo', scope: 'col'}))
                .append($('<th>', {text: 'Cor', scope: 'col'}))
                .append($('<th>', {text: 'Ano', scope: 'col'}))
                .append($('<th>').append(this.btnNew));
            var thead = $("<thead>", {class: 'thead-dark'}).append(trHeader);
            $("#table").html(thead);
            $("#table").append($("<tbody>"));
            return this;
        }
        ,
        btnLine: '<div class="dropdown float-right" >' +
            '  <button class="btn btn-default dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
            '    Opções' +
            '  </button>' +
            '  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
            '<a class="btn btn-sm btn-default dropdown-item" data-toggle="modal" data-target="#carroModal" onclick="formModal.toShow({id})">Detalhes</a>' +
            '<a class="btn btn-sm btn-info dropdown-item" data-toggle="modal" data-target="#carroModal" onclick="formModal.toEdit({id})">Editar</a>' +
            '<a class="btn btn-sm btn-danger dropdown-item   " data-toggle="modal" data-target="#carroModal" onclick="formModal.toDelete({id})">Deletar</a>' +
            '  </div>' +
            '</div>'
        ,
        btnNew: "<a class='btn btn-success text-white float-right btn-sm' data-toggle='modal' data-target='#carroModal' onclick='formModal.toNew()'>Adicionar</a>"
    }
;

var cars = {
    all: function () {
        cars.request('GET', '', function () {
            table.build();
        });
    }
    , get: function (id) {
        cars.request('GET', id, function () {
            formModal.setData();
        });
    }
    , create: function () {
        cars.request('POST');
    }
    , update: function (id) {
        cars.request('POST', id)//PUT não funciona neste framework
    }
    , delete: function (id) {
        cars.request('DELETE', id);
    }
    , data: ''
    , request: function (method, id = '', callback = '') {
        var data = method != "GET" ? $("#form-car").serialize() : "";
        $.ajax({
            url: '/carros/' + id
            , type: method
            , dataType: 'json'
            , data: data
            , success: function (data) {
                if (data.success && (method === 'DELETE' || method === 'POST')) {
                    formModal.hide();
                    cars.all();
                }

                if (!data.success)
                    alert(data.message);

                if (typeof data.data !== 'undefined')
                    cars.data = data.data;

                if (callback !== '')
                    callback();
            }
            , error: function (data, text) {
                alert('Falha');
                console.log(data);
            }
        });
    }
};

var formModal = {
    clear: function () {
        this.form[0].reset();
        this.form.find('option:selected').removeAttr("selected");
        this.form.find("option").eq(0).attr('selected');
        return this;
    }
    , setData: function () {
        this.form.find("input[name='modelo']").val(cars.data.modelo);
        this.form.find("input[name='cor']").val(cars.data.cor);
        this.form.find("input[name='ano']").val(cars.data.ano);
        this.form.find("select").find("option[selected]").removeAttr('selected');
        this.form.find("select").find("option[value='" + cars.data.marca + "']").attr('selected', '');
        return this;
    }
    , toShow: function (id) {
        cars.get(id);
        formModal.readonly().title('Carro');
        formModal.cta.visibility(false);
    }
    , toEdit: function (id) {
        cars.get(id);
        formModal.readonlyRemove().setData(cars.data).title('Editar Carro');
        formModal.cta.visibility().toAction('update', id).text('Atualizar').colorType('primary');
    }
    , toNew: function () {
        formModal.readonlyRemove().clear().title('Novo Carro');
        formModal.cta.visibility().toAction('create').text('Criar').colorType('success');
    }
    , toDelete: function (id) {
        cars.get(id);
        formModal.readonly().title('Deletar Carro ?');
        formModal.cta.visibility().toAction('delete', id).text('Deletar').colorType('danger');
    }
    , readonly: function () {
        $("#form-car input").each(function () {
            $(this).removeAttr('readonly').attr("readonly", "readonly");
        });
        $("#form-car select")
            .attr('readonly', 'readonly')
            .attr('tabindex', '-1')
            .attr('aria-disabled', 'true');
        return this;
    }
    , readonlyRemove: function () {
        $("#form-car input").each(function () {
            $(this).removeAttr('readonly');
        });
        $("#form-car select")
            .removeAttr('readonly')
            .removeAttr('tabindex')
            .removeAttr('aria-disabled');
        return this;
    }
    , validate: function () {
        var keys = ['modelo', 'ano', 'cor', 'marca'];
        var ok = true;
        $.each(keys, function (index, value) {
            if ($("[name='" + value + "']").val() == "")
                ok = false;
        });
        return ok;
    }
    , submit: function () {
        var action = this.validate() ? this.cta.action : "";
        var id = this.cta.id;
        cars[action](id);
        return this;
    }
    , hide: function () {
        $("#carroModal").modal('hide');
        return this;
    }
    , title: function (text) {
        $("#modalTitle").text(text);
    }
    , cta: {
        text: function (text) {
            this.e.text(text);
            return this;
        }
        , colorType: function (type) {
            var classBasic = "btn" + " btn-" + type;
            this.e.attr('class', classBasic);
            return this;
        }
        , toAction: function (action, id = "") {
            this.action = action;
            this.id = id;
            return this;
        }
        , visibility: function (status = true) {
            if (status)
                this.e.show();
            else
                this.e.hide();

            return this;
        }
        , e: $("#btn-cta")
        , action: ""
        , id: ""
    }
    , form: $("#form-car")
};
window.onload = cars.all();