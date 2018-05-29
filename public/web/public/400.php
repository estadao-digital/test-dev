<?php
    $serverName = $_SERVER['SERVER_ADDR'];
    $redirectLink = "https://{$serverName}:8081";

    $img_file = 'logo.png';
    $imgData = base64_encode(file_get_contents($img_file));
    $src = 'data: '.mime_content_type($img_file).';base64,'.$imgData;

    $css = base64_encode(file_get_contents('bootstrap.min.css'));
?>

<!DOCTYPE html>
<html lang="nl" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow" />
        <title>Requisição Inválida</title>
        <style type="text/css">
            <?php echo base64_decode($css); ?>

            div.jumbotron {
                margin: 50px auto;
                text-align: center;
                padding: 25px;
                max-width: 600px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="jumbotron">
                        <img src="<?php echo $src; ?>" style="max-height: 45px;">Aker Web Defender
                        <h4>
                            Requisição Inválida
                        </h4>
                        <p>
                            <a class="btn btn-lg btn-primary" href="<?php echo $redirectLink; ?>">
                                Clique aqui para ser redirecionado
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
