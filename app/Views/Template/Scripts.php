<?php 
namespace App\Views\Template;

use App\Views\Template\Styles;

class Scripts{
    public static function getScripts(){
        ?>
        <script src="assets/vendor/jquery/jquery.js?t=<?=time()?>"></script>
       <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
       
       <script src="assets/js/app.js?t=<?=time()?>"></script>
<?php
    }
}