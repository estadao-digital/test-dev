<?php

function dd($var)
{
    $list = func_get_args();

    print_r('<pre>');
    print_r(debug_backtrace()[0]['file'] . ': ');
    print_r(debug_backtrace()[0]['line']);
    echo '<br>' . PHP_EOL;
    
    /**
     * Se estiver em Produção ele não estoura nada
     */
    foreach($list as $c => $var ):
          var_dump($c, $var);
    endforeach;
    echo '<br>' . PHP_EOL;
    die();
}