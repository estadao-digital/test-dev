<?php 
namespace App\Views\Template;

use App\Views\Template\Styles;

class Scripts{
    public static function getScripts(){
        ?>
        <script src="dist/vendor/jquery/jquery.js?t=<?=time()?>"></script>
       <script src="dist/vendor/bootstrap/js/bootstrap.min.js"></script>
       
       <script src="dist/js/app.js?t=<?=time()?>"></script>
<?php
    }
}