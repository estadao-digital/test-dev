<?php

declare(strict_types=1);

function autoload(string $class): void
{
    $file = DIR_ROOT . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        include_once $file;
    }
}

spl_autoload_register('autoload');
