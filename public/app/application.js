var Application = function () {

    var dialogButton;
    var listCarrosView;
    var menu;

    var carrosController;
    var marcasController;


    var init = function () {

        dialogButton = document.querySelector('.dialog-button');
        listCarrosView = document.querySelector('.list-carros-view');
        menus = document.querySelectorAll('.menu');

        carrosController = new CarrosController();
        marcasController = new MarcasController();

        carrosController.init();

        carrosController.listarTodos();

        dialogButton.addEventListener('click', function() {
            marcasController.listarSelect();
            carrosController.cadastrar();
        });

        listCarrosView.addEventListener('click', function (e) {
            if (e.target.parentNode.classList.contains('carro-edit') || e.target.classList.contains('carro-edit')) {
                marcasController.listarSelect();
                carrosController.atualizar(e.target);
            }
            if (e.target.parentNode.classList.contains('carro-delete') || e.target.classList.contains('carro-delete'))
                carrosController.apagar(e.target);
        });
		
		Array.prototype.forEach.call(menus, function (menu) {
			menu.addEventListener('click', function (e) {
				if (e.target.parentNode.classList.contains('menu-carros')
				 || e.target.classList.contains('menu-carros')) {
					e.preventDefault();
					carrosController.listarTodos();
					document.querySelector('.mdl-layout__obfuscator').classList.remove('is-visible');
					document.querySelector('.mdl-layout__drawer').classList.remove('is-visible');
				 }
			});
		});
    };

    return {
        init: init
    }
};
