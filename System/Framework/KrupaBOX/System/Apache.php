<?php

class Apache
{
    public static function isApache()
    {
        $software = strtolower(strval(isset($_SERVER["SERVER_SOFTWARE"]) ? @$_SERVER["SERVER_SOFTWARE"] : null));
        return stringEx($software)->startsWith("apache/2");
    }

    public static function restart()
    {
        if (\System\Shell::canExecute() == false || self::isApache() == false)
            return false;

        \System\Shell::execute('sudo /etc/init.d/apache2 reload'); \KrupaBOX\Internal\Kernel::exit();
    }
}