class Table {

    clean() {
        $('tbody').empty();
    };

    setTable(data) {
        let car = new Car;
        let formCar = new FormCar;       
        let formDeleteCar = new FormDeleteCar;       
        
        let result = "";
        let count = 0;
      
        
        for (var i in data) {
            result += `<tr>
                        <td data-label="id" data-id='${data[i].id}'>${ ++count }</td>
                        <td data-label="marca">${data[i].marca}</td>
                        <td data-label="modelo">${data[i].modelo}</td>
                        <td data-label="ano">${data[i].ano}</td>
                        <td data-label="ação">
                            <a href="" class='editCar' data-id="${data[i].id}">Editar</a>
                            <a href="" class='deleteCar' data-id="${data[i].id}">Excluir</a>
                        </td>
                    </tr>`;

            result += "</td>";
        };

        $('tbody').append(result);

        $(".deleteCar").click(function (event) {
            event.preventDefault();
            
            let id = $(this).data("id");
            let dataValues = car.retrieve(id);
            
            formDeleteCar.set(dataValues);
            formDeleteCar.show();
        });

        $(".editCar").click(function (event) {
            event.preventDefault();

            let id = $(this).data("id");
            let dataValues = car.retrieve(id);
            
            formCar.set(dataValues);
        });

      
    };
}