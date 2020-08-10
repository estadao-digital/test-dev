<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/main-mobile.css">
    <link rel="stylesheet" href="css/fontawesome.css" />
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <title>My Car Spot</title>
  </head>
  <body>
    <header>
      <img src="images/logo.png" alt="CarSpot" />
    </header>
    <main>
      <div class="container">
        <div class="car-add">
          <button type="button" id="btnCarAdd">
            <i class="fas fa-car"></i><span>+</span>
          </button>
        </div>
        <div class="car-cards">
          <div class="car-card-container">
            <div class="car-card-list"></div>
          </div>
        </div>
      </div>
    </main>
    <footer>
      &nbsp;
    </footer>
    <div class="overlay">&nbsp;</div>
    <div id="modal">
      <div class="modal-title">
        Novo Carro
      </div>
      <div class="modal-body">
        <form name="frmCar" id="frmCar" action="">
          <div class="frm-control">
            <label>Modelo: </label>
            <input
              type="text"
              id="carModel"
              name="carModel"
              size="20"
              maxlength="255"
              required
              value=""
            />
          </div>
          <div>
            <div class="frm-control">
              <label for="carYear">Ano:</label>
              <input
                type="number"
                id="carYear"
                name="carYear"
                size="20"
                value=""
                min="1900"
                max="2030"
                required
              />
            </div>
            <div class="frm-control">
              <label>Image:</label>
              <input
                type="file"
                id="carImage"
                name="carImage"
                accept="image/png, image/jpeg"
              />
            </div>
          </div>
          <div class="frm-actions">
            <button type="button" id="btnModalSave">
              <i class="fas fa-gavel"></i> Aplicar
            </button>
            <button type="button" id="btnModalClose">
              <i class="fas fa-times"></i> Fechar
            </button>
          </div>
          <input id="carId" name="carId" type="hidden" value="" />
        </form>
      </div>
      <div class="modal-footer">
        <div id="msgStatus"></div>
      </div>
    </div>

    <script src="js/main.js"></script>
  </body>
</html>
