/**
 * Brands list
 */
var brands = [
    "Abarth",
    "Alfa Romeo",
    "Aston Martin",
    "Audi",
    "Bentley",
    "BMW",
    "Bugatti",
    "Cadillac",
    "Chevrolet",
    "Chrysler",
    "Citroën",
    "Dacia",
    "Daewoo",
    "Daihatsu",
    "Dodge",
    "Donkervoort",
    "DS",
    "Ferrari",
    "Fiat",
    "Fisker",
    "Ford",
    "Honda",
    "Hummer",
    "Hyundai",
    "Infiniti",
    "Iveco",
    "Jaguar",
    "Jeep",
    "Kia",
    "KTM",
    "Lada",
    "Lamborghini",
    "Lancia",
    "Land Rover",
    "Landwind",
    "Lexus",
    "Lotus",
    "Maserati",
    "Maybach",
    "Mazda",
    "McLaren",
    "Mercedes-Benz",
    "MG",
    "Mini",
    "Mitsubishi",
    "Morgan",
    "Nissan",
    "Opel",
    "Peugeot",
    "Porsche",
    "Renault",
    "Rolls-Royce",
    "Rover",
    "Saab",
    "Seat",
    "Skoda",
    "Smart",
    "SsangYong",
    "Subaru",
    "Suzuki",
    "Tesla",
    "Toyota",
    "Volkswagen",
    "Volvo"
];

/**
 * Toggle form create/edit car
 */
$('.toggleForm').on('click', function() {
    $('form[name="save_car"]')[0].reset();
    $('.btnSaveCar').show();
    $('.btnSaveEditCar').hide();
    $('#method').val('POST');
    $('.divCreateCar').toggle();
})

/**
 * Method to fill the brand input select with the brands list
 */
function fillInputBrands() {
    let brandInput = $('#brand');

    for (var i = 0; i < brands.length; i++) {
        brandInput.append(`<option value="${brands[i]}">${brands[i]}</option>`);
    }
}


/**
 * Save event - New car
 */
$('.btnSaveCar').on('click', function(e) {
    console.log('btnSaveCar');
    let serialize = $('form[name="save_car"]').serializeArray(),
        errors = [];

    $.each(serialize, function(i, field) {
        if (field.value === '') {
            errors.push(field.name);
        }
    });

    if (errors.length === 0) {
        saveCar();
    } else {
        alert(`You must fill the inputs: ${errors.toString()}`);
    }

    e.preventDefault();
});

function saveCar() {
    $.ajax({
        url: '/api/carros',
        type: 'POST',
        data: $('form[name="save_car"]').serialize(),
        async: false,
        dataType: 'json',
        success: function(resp, textStatus, xhr) {
            checkIfUserLogged(xhr.status);
            if (resp.success) {
                $('form[name="save_car"]')[0].reset();
            }
            $('.divCreateCar').hide();
            alert(resp.message);
            getAllCars();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            checkIfUserLogged(xhr.status);
            alert("Error: " + xhr.responseJSON.message);
        }
    });
}
/**
 * Save event - New car
 */


/**
 * Get all cars event
 */
function getAllCars() {
    $.ajax({
        url: '/api/carros',
        type: 'GET',
        async: false,
        dataType: 'json',
        success: function(resp, textStatus, xhr) {
            checkIfUserLogged(xhr.status);
            fillTable(resp);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            checkIfUserLogged(xhr.status);
            alert("Error: " + xhr.responseJSON.message);
        }
    });
}


function fillTable(data) {
    let rowsCars = $('.rowsCars');

    rowsCars.html('');

    $.each(data, function(i, v) {
        rowsCars.append($('<tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">')
            .append($('<td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">').append('<span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">ID</span>' + v.id.substring(0, 8) + '...'))
            .append($('<td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">').append('<span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Brand</span>' + v.brand))
            .append($('<td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">').append('<span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Model</span>' + v.model))
            .append($('<td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">').append('<span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Year</span>' + v.year))
            .append($('<td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">').append(`<span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Actions</span><button type="button" data-id="${v.id}" data-response='${JSON.stringify(v)}' class="btnEditCar inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray">Edit</button> <button type="button" data-id="${v.id}" class="btnDeleteCar inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray">Delete</button>`))
        );
    });
}
/**
 * Get all cars event
 */


/**
 * Event to edit a car
 */
$(document).on('click', '.btnEditCar', function() {
    $('.divCreateCar').show();

    let data = $(this).data('response');

    $('#method').val('PUT');
    $('#id').val(data.id);
    $('#brand').val(data.brand);
    $('#model').val(data.model);
    $('#year').val(data.year);

    $('.btnSaveCar').hide();
    $('.btnSaveEditCar').show();
});

$(document).on('click', '.btnSaveEditCar', function(e) {
    $(this).prop('disabled', true);

    setTimeout(() => {
        editCar();
    }, 200);

    e.preventDefault();
});

function editCar() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/api/carros/' + $('form[name="save_car"]').serializeArray()[0].value,
        type: 'PUT',
        async: false,
        dataType: 'json',
        data: $('form[name="save_car"]').serialize(),
        success: function(resp, textStatus, xhr) {
            checkIfUserLogged(xhr.status);
            $('.divCreateCar').hide();
            alert(resp.message);
            getAllCars();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            checkIfUserLogged(xhr.status);
            alert("Error: " + xhr.responseJSON.message);
        }
    });
}
/**
 * Event to edit a car
 */


/**
 * Event to delete a car
 */
$(document).on('click', '.btnDeleteCar', function() {
    $(this).prop('disabled', true);

    setTimeout(() => {
        deleteCar($(this).data('id'));
    }, 200);
});

function deleteCar(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/api/carros/' + id,
        type: 'DELETE',
        async: false,
        dataType: 'json',
        success: function(resp, textStatus, xhr) {
            checkIfUserLogged(xhr.status);
            alert(resp.message);
            getAllCars();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            checkIfUserLogged(xhr.status);
            alert("Error: " + xhr.responseJSON.message);
        }
    });
}
/**
 * Event to delete a car
 */


/**
 * Handle UNAUTHORIZED status
 */
function checkIfUserLogged(status) {
    status !== 401 || location.reload();
}

$(document).ready(function() {
    setTimeout(() => {
        getAllCars();
        fillInputBrands();
    }, 250);
});