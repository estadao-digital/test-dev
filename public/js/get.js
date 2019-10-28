function get() {
    $('#tabela').empty();
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: url,
        async: false,
        success: function (dados) {
            for (var i = 0; dados.length > i; i++) {
                $('#tabela').append(
                    `<tr>
                        <td>
                            ${dados[i].id}
                        </td>
                        <td>
                            <select name="brand_${i}" id="brand_${i}" class="form-control">
                                <option value="BMW">BMW</option>
                                <option value="Fiat">Fiat</option>
                                <option value="Jaguar">Jaguar</option>
                                <option value="Mercedes">Mercedes</option>
                            </select>
                            <script>
                                document.getElementById('brand_${i}').value = "${dados[i].brand}"
                            </script>
                        </td>
                        <td>
                            <input type="text" name="model_${i}" value="${dados[i].model}" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="year_${i}" value="${dados[i].year}" class="form-control">
                        </td>
                        <td>
                            <button onclick="
                                put(${dados[i].id},
                                    $('[name=brand_${i}]').val(),
                                    $('[name=model_${i}]').val(),
                                    $('[name=year_${i}]').val()
                                ); get();" 
                            class="btn btn-primary">Update</button>
                        </td>
                        <td>
                            <button onclick="remove(${dados[i].id}); get();" class="btn btn-danger">Deletar</button>
                        </td>
                    </tr>`
                );
            }
        }
    });
}

get();