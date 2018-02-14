<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <div class="alert">
            <a href="#" class="close">&times;</a>
            <span></span>
        </div>
            
        <div id="main-container">
            
            <div class="container">
                <div class="row">
                    <div class="panel panel-primary filterable">
                        <div class="panel-heading">
                            <h3 class="panel-title">Carros Cadastrados</h3>
                        </div>
                        <table class='table fixme'>
                            <thead>
                                <tr class="filters form-add">
                                    <th width="30%">
                                        <input name='brand_name' list="brands" type="text" class="form-control" placeholder="Marca" autofocus>
                                        <datalist id="brands">
                                        </datalist>
                                    </th>
                                    <th width="40%"><input name='model' type="text" class="form-control" placeholder="Modelo"></th>
                                    <th width="20%"><input name='year' type="text" class="form-control" placeholder="Ano"></th>
                                    <th class='buttons'>
                                        <button type="button" class="btn btn-success add" onclick="addCar(this)">
                                            <i class="fas fa-plus-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-info search">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <table class="table cars">
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script defer src="fonts/fa.js"></script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="js/main.js"></script>
        <script src="js/fixme.js"></script>
        <script src="js/filter.js"></script>
    </body>
</html>
