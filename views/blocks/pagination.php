<?php
$total = $viewData['total_paginas'];
$p = isset($_REQUEST['p']) ? $_REQUEST['p'] : 1;
$min = $p > 1 ? ($p > 2 ? $p - 2 : $p - 1 ) : 1;
$max = $p <  $total ? $p < ( $total - 1) ? $p + 2 : $p + 1 : $p;
$current_page = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (stripos($current_page, '?')) {
    $current_page = substr($current_page, 0, stripos($current_page, '?'));
}
?>
<div id="pagination-content">
    <ul>
      <?php if($p > $min) : ?>
        <li class="fist-page"><span  class="to-content" data-href="<?php echo BASE ?>listar?p=1">Primeira</span></li>
     <?php endif;?>
      <?php for ($i = $min; $i < $p; $i++) : ?>
        <li><span  class="to-content" data-href="<?php echo BASE ."listar?p=$i"?>"><?php echo $i ?></span></li>            
      <?php endfor; ?>
        <li class="current"><?php echo $p ?></li>
      <?php for ($i = $p + 1; $i <= $max; $i++) : ?>
        <li><span  class="to-content" data-href="<?php echo BASE ."listar?p=$i";?>"><?php echo $i ?></span></li>          
      <?php endfor; ?>   
      <?php if($p < $max) : ?>
        <li class="last-page"><span  class="to-content" data-href="<?php echo BASE ."listar?p=$total";?>">Última</span></li>         
      <?php endif;?>
    </ul>
    <div id="total-page">
        <p>  Total: <span><?php echo $total?></span></p>        
    </div>
</div>

