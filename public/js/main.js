/**
 *  config
 */
const app = {
    token: "",
    axios: null,
    host: window.location.origin,
    image: {
        default: "images/gt.png",
    },
};

/**
 * Main function
 */
function main() {
    document.addEventListener("DOMContentLoaded", function(event) {
        apiStart();
        registerFormEvents();
    });
}
/**
 * Set Token and create Axios Instance
 */
function apiStart() {
    axios
        .get(app.host + "/api/v1/token")
        .then(function(res) {
            app.token = res.data.token;
            app.axios = axios.create({
                baseURL: app.host,
                timeout: 2048,
                headers: {
                    Authorization: `Bearer ${app.token}`,
                    "Content-Type": "application/json",
                },
            });
            getCarAll();
        })
        .catch(function(error) {
            console.error(error);
        });
}
/**
 *  Save car
 * @param {object} car
 */
function saveCar(car, selectedCard) {
    const endpoint = "/api/v1/car/" + (!selectedCard ? "create" : car.id);
    app
        .axios({
            method: selectedCard ? "PUT" : "POST",
            url: endpoint,
            data: car,
        })
        .then(function(res) {
            if (selectedCard) {
                updateCard(selectedCard, res.data);
            } else {
                createCard(res.data);
            }
            modalClose();
        })
        .catch(function(error) {
            console.error(error);
        });
}

/**
 * Load Car Image
 * @param {object} car
 */
function loadImage(car) {
    const file = document.querySelector("#carImage");
    const reader = new FileReader();
    const card = document.querySelector(".car-card.car-card-active");
    reader.onloadend = function() {
        car.image = reader.result;
        saveCar(car, card);
    };

    if (file && file.files.length > 0) {
        reader.readAsDataURL(file.files[0]);
    } else if (card) {
        const image = card.querySelector("img");
        car.image = image.src;
        saveCar(car, card);
    } else {
        car.image = app.image.default;
        saveCar(car);
    }
}
/**
 * Returns form data
 * @param {object} car
 */
function getFormData(car) {
    const carId = document.querySelector("#carId");
    if (carId.value.trim().length > 0) {
        car.id = carId.value;
    }

    const carModel = document.querySelector("#carModel");
    car.model = carModel.value;

    const carYear = document.querySelector("#carYear");
    car.year = carYear.value;
    if (validateForm(car)) {
        loadImage(car);
    }

}
/**
 * 
 * @param {object} car 
 */
function validateForm(car) {
    let msg = "";
    let success = true;
    if (!(car.model && car.model.trim().length > 0)) {
        msg += "<p>preencher campo modelo</p>";
        success = false;
    }
    year = Number.parseInt(car.year);

    if (!year) {
        msg += "<p>preencher campo ano</p>";
        success = false;
    }

    if (!(year >= 1900 && year <= 2030)) {
        msg += "<p>preencher campo ano entre 1900 e 2030</p>";
        success = false;
    }

    sendMessage(msg);

    return success;
}
/**
 * Update modal form
 * @param {object} car 
 */
function setFormData(car) {
    const frm = document.querySelector("#frmCar");
    frm.reset();
    const carId = document.querySelector("#carId");
    carId.value = car.id;
    const carModel = document.querySelector("#carModel");
    carModel.value = car.model;
    const carYear = document.querySelector("#carYear");
    carYear.value = car.year;
}

/**
 * Register form events
 */
function registerFormEvents() {
    const btnCarAdd = document.querySelector("#btnCarAdd");
    btnCarAdd.addEventListener("click", function() {
        deactivateCards();
        modalOpen();
    });
    const btnModalSave = document.getElementById("btnModalSave");
    btnModalSave.addEventListener("click", function() {
        const car = {};
        getFormData(car);
    });

    const btnModalClose = document.getElementById("btnModalClose");
    btnModalClose.addEventListener("click", function() {
        modalClose();
    });
}
/**
 * Close Modal
 */
function modalClose() {
    const overlay = document.querySelector(".overlay");
    overlay.style.display = "none";

    const modal = document.querySelector("#modal");
    modal.style.display = "none";

    const frm = document.querySelector("#frmCar");
    frm.reset();
}
/**
 * Open Modal
 */
function modalOpen() {
    const overlay = document.querySelector(".overlay");
    overlay.style.display = "block";

    const modal = document.querySelector("#modal");
    modal.style.display = "block";
}

/**
 *
 */
function getCarAll() {
    app.axios
        .get("api/v1/car")
        .then(function(res) {
            const cars = res.data;
            for (const car of res.data) {
                createCard(car);
            }
        })
        .catch(function(error) {
            console.error(error);
        });
}

/**
 * Event Edit Car
 * @param {object} card
 */
function onEditCar(card) {
    return (event) => {
        event.cancelBubble = true;
        setCardActive(card);
        const car = JSON.parse(card.dataset.car);
        setFormData(car);
        modalOpen();
    };
}

/**
 * Event delete Card
 * @param {object} card
 */
function onDeleteCar(card) {
    return (event) => {
        event.cancelBubble = true;
        const car = JSON.parse(card.dataset.car);
        setCardActive(card);
        const endpoint = `api/v1/car/${car.id}`;
        app.axios
            .delete(endpoint)
            .then(function(res) {
                deactivateCards();
                const cardList = document.querySelector(".car-card-list");
                card.style.display = "none";
                cardList.removeChild(card);
            })
            .catch(function(error) {
                console.error(error);
            });
    };
}
/**
 * Deactivate Card
 */
function deactivateCards() {
    const cards = document.getElementsByClassName("car-card-active");
    for (const elm of cards) {
        elm.classList.remove("car-card-active");
    }
}

/**
 * Active card
 * @param {object} card
 */
function setCardActive(card) {
    deactivateCards();
    card.classList.add("car-card-active");
}

/**
 * Create Card
 * @param {object} data
 */
function createCard(data) {
    const cardList = document.getElementsByClassName("car-card-list");

    const card = document.createElement("div");
    card.classList.add("car-card");
    card.addEventListener("click", function(event) {
        setCardActive(this);
    });

    const figure = document.createElement("figure");
    const image = document.createElement("img");
    image.src = data.image || app.image.default;
    figure.appendChild(image);
    card.appendChild(figure);

    const cardContent = document.createElement("div");
    cardContent.classList.add("card-content");

    const cardContentModel = document.createElement("p");
    cardContentModel.innerHTML = `<strong>modelo:</strong> ${data.model}`;
    cardContent.appendChild(cardContentModel);

    const cardContentYear = document.createElement("p");
    cardContentYear.innerHTML = `<strong>ano:</strong> ${data.year}`;
    cardContent.appendChild(cardContentYear);

    card.appendChild(cardContent);

    const cardAction = document.createElement("div");
    cardAction.classList.add("car-card-action");

    const editButton = document.createElement("button");
    editButton.addEventListener("click", onEditCar(card));
    editButton.innerHTML = `<i class="far fa-edit"></i>`;
    cardAction.appendChild(editButton);

    const deleteButton = document.createElement("button");
    deleteButton.addEventListener("click", onDeleteCar(card));
    deleteButton.innerHTML = `<i class="fas fa-trash"></i>`;
    cardAction.appendChild(deleteButton);

    card.appendChild(cardAction);
    cardList.item(0).appendChild(card);
    card.dataset.car = JSON.stringify(data);
}
/**
 * Update Card
 * @param {object} card
 * @param {object} data
 */
function updateCard(card, data) {
    const figure = card.querySelector("figure");
    const image = figure.querySelector("img");
    image.src = data.image;
    const cardContent = card.querySelector(".card-content");
    cardContent.children.item(
        0
    ).innerHTML = `<strong>modelo:</strong> ${data.model}`;
    cardContent.children.item(1).innerHTML = `<strong>ano:</strong> ${data.year}`;
    card.dataset.car = JSON.stringify(data);
}
/**
 * Modal message
 * @param {string} message 
 */
function sendMessage(message) {
    const msg = document.querySelector("#msgStatus");
    msg.innerHTML = message;
}

/**
 *
 */
main();