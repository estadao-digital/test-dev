<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>CRUD of Cars</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="public/assets/css/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link rel="stylesheet" href="public/assets/css/main.css">
</head>

<body>
<nav>
    <div class="container">
        <div class="row">
            <div class="nav-wrapper">
                <a href="#" class="brand-logo right">DeividSantosR</a>
                <ul id="nav-mobile" class="left hide-on-med-and-down">
                    <li><a href="sass.html">Sass</a></li>
                    <li><a href="badges.html">Components</a></li>
                    <li><a href="collapsible.html">JavaScript</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="parallax-container">
    <div class="parallax"><img src="public/assets/image/parallax1.jpg"></div>
</div>
<div class="section white">
    <div class="row container">
        <h2 class="header">Parallax</h2>
        <p class="grey-text text-darken-3 lighten-3">Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling.</p>
    </div>
</div>


<div class="card-container container">
    <div class="row">

    </div>
</div>

<footer class="page-footer">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">Footer Content</h5>
                <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
            </div>
            <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2014 Copyright Text
            <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
        </div>
    </div>
</footer>

<!-- Modal Structure -->
<div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
        <form class="col s12">
            <div class="row">
                <div class="input-field col s12">
                    <h4>Modal Header</h4>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input id="id" name="id" type="hidden" value="1">
                    <input placeholder="1181" id="model" name="model" type="text" class="validate">
                    <label for="model">Modelo</label>
                </div>
                <div class="input-field col s6">
                    <input placeholder="BMW" id="brand" name="brand" type="text" class="validate">
                    <label for="brand">Marca</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input placeholder="2011" id="year" name="year" type="text" class="validate">
                    <label for="year">Ano</label>
                </div>
                <div class="input-field col s6">
                    <input placeholder="R$ 49.00,00" id="price" name="price" type="text" class="validate">
                    <label for="price">Preço</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input disabled value="public/assets/image/sample-1.jpeg" id="image" name="image" type="text" class="validate">
                    <label for="image">URL da imagem</label>
                </div>
            </div>
        </form>

    </div>
    <div class="modal-footer">
        <div class="edit">
            <a class="modal-action modal-close waves-effect waves-light btn red darken-1 delete"><i class="material-icons left">delete</i>Deletar</a>
            <a class="modal-action modal-close waves-effect waves-light btn save"><i class="material-icons left">save</i>Salvar</a>
        </div>
        <div class="add hidden">
            <a class="modal-action modal-close waves-effect waves-light btn grey darken-1 cancel"><i class="material-icons left">cancel</i>Cancelar</a>
            <a class="modal-action modal-close waves-effect waves-light btn save"><i class="material-icons left">save</i>Salvar</a>
        </div>
    </div>
</div>


<div class="fixed-action-btn">
    <a class="waves-effect waves-circle waves-light btn-floating btn-large red modal-trigger add" href="#modal1">
        <i class="large material-icons">add</i>
    </a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
<script src="public/assets/js/vendor/modernizr-2.8.3.min.js"></script>
<script src="public/assets/js/main.js"></script>
</body>
</html>