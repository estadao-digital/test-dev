var HomePage = function () {
    'use strict';

    this.apiURL = 'public/api/v1/';

    this.init();
};

HomePage.prototype.init = function () {
    var self = this;

    $(document).ready(function () {
        self.materializeComponents();
        self.bindEvents();
        self.loadCardItems();
    });
};

HomePage.prototype.changeModal = function (modal, trigger) {
    var modalTitle = modal.find('.modal-content h4');
    var modalFooter = modal.find('.modal-footer');
    var id = modal.find('input[name="id"]');
    var model = modal.find('input[name="model"]');
    var brand = modal.find('input[name="brand"]');
    var year = modal.find('input[name="year"]');
    var price = modal.find('input[name="price"]');
    var image = modal.find('input[name="image"]');

    if (trigger.hasClass('add')) {
        modalTitle.text("Adicionar Carro");
        modalFooter.find('.add').removeClass('hidden');
        modalFooter.find('.edit').addClass('hidden');
        id.val(null);
        model.val(null);
        brand.val(null);
        year.val(null);
        price.val(null);
    }
    else {
        var cardData = trigger.parents('.item').data('cart');

        modalTitle.text("Atualizar Carro");
        modalFooter.find('.add').addClass('hidden');
        modalFooter.find('.edit').removeClass('hidden');
        id.val(cardData.id);
        model.val(cardData.model);
        brand.val(cardData.brand);
        year.val(cardData.year);
        price.val(cardData.price);
    }
};

HomePage.prototype.bindEvents = function () {
    var self = this;

    $('.modal-fixed-footer .modal-footer .add .save').click(function () {
        self.createCard(this, self);
    });

    $('.modal-fixed-footer .modal-footer .edit .save').click(function () {
        self.updateCard(this, self);
    });

    $('.modal-fixed-footer .modal-footer .edit .delete').click(function () {
        self.deleteCard(this, self);
    });
};

HomePage.prototype.materializeComponents = function () {
    var self = this;

    $('.parallax').parallax();
    $('.modal').modal({
        ready: self.changeModal
    });
};

HomePage.prototype.loadCardItems = function () {
    var self = this;

    $.ajax({
        method: 'GET',
        url: this.apiURL + 'car',
        dataType: 'json',
        complete: function (response) {
            response.responseJSON.data.forEach(function (card) {
                self.addCardItem(card);
            });
        }
    });
};

HomePage.prototype.createCard = function (trigger, self) {
    var form = $(trigger).parents('.modal-fixed-footer').find('form').get(0);

    $.ajax({
        method: 'POST',
        url: self.apiURL + 'car',
        data: {
            model: form.model.value,
            brand: form.brand.value,
            year: form.year.value,
            price: form.price.value,
            image: form.image.value
        },
        complete: function (response) {
            self.addCardItem(response.responseJSON);

            Materialize.toast('Carro criado com sucesso', 4000);
        }
    });
};

HomePage.prototype.updateCard = function (trigger, self) {
    var form = $(trigger).parents('.modal-fixed-footer').find('form').get(0);

    $.ajax({
        method: 'PUT',
        url: self.apiURL + 'car/' + form.id.value,
        data: {
            model: form.model.value,
            brand: form.brand.value,
            year: form.year.value,
            price: form.price.value,
            image: form.image.value
        },
        complete: function (response) {
            self.updateCardItem(response.responseJSON);

            Materialize.toast('Carro atualizado com sucesso', 4000);
        }
    });
};

HomePage.prototype.deleteCard = function (trigger, self) {
    var form = $(trigger).parents('.modal-fixed-footer').find('form').get(0);

    $.ajax({
        method: 'DELETE',
        url: self.apiURL + 'car/' + form.id.value,
        complete: function () {
            self.deleteCartItem(form.id.value);

            Materialize.toast('Carro excluído com sucesso', 4000);
        }
    });
};

HomePage.prototype.addCardItem = function (cardData) {
    $('.card-container .row').prepend(this.getCardItem(cardData));
};

HomePage.prototype.updateCardItem = function (cardData) {
    var cardItem = $('.card-container .row').find('.item-' + cardData.id);

    cardItem.data('cart', cardData);

    cardItem.find('.card-title').text(cardData.brand + ' ' + cardData.model);
};

HomePage.prototype.deleteCartItem = function (cardDataId) {
    var cardItem = $('.card-container .row').find('.item-' + cardDataId);

    cardItem.remove();
};

HomePage.prototype.getCardItem = function (cardData) {
    var cardItem = $('<div>', {
        class: 'col s6 m4 item item-' + cardData.id
    });

    var card = $('<div>', {
        class: 'card'
    });

    var cardImage = $('<div>', {
        class: 'card-image',
        append: $('<img>', {
            src: 'public/assets/image/sample-1.jpeg'
        })
    });

    var cardLink = $('<a>', {
        class: 'btn-floating halfway-fab waves-effect waves-light red modal-trigger edit',
        href: '#modal1',
        append: $('<i>', {
            class: 'material-icons',
            text: 'edit'
        })
    });

    var cardContent = $('<div>', {
        class: 'card-content',
        append: $('<div>', {
            class: 'card-title',
            text: cardData.brand + ' ' + cardData.model
        })
    });

    cardImage.append(cardLink);

    card.append(cardImage);
    card.append(cardContent);

    cardItem.append(card);

    cardItem.data('cart', cardData);

    return cardItem;
};

(function () {
    var app = new HomePage();
})();