<?php
   namespace App\Mvc\View;
   class View
   {
        function __construct($view, $data = []){
            include 'partial/header.php';
            include $view . ".php";
            include 'partial/footer.php';
        }

        public function render($str)
        {
            echo $str;
        }
   }