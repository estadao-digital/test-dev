<?php

if (function_exists("shell_exec"))
{
    $software = strtolower(strval(@$_SERVER["SERVER_SOFTWARE"]));
    if (strpos($software, "apache/2") !== false)
    {
        $phpOs     = strtolower(php_uname());
        $isLinux   = (strpos($phpOs, "linux") !== false);
        $isMac     = (strpos($phpOs, "mac") !== false);
        $isWindows = (strpos($phpOs, "win") !== false);

        if ($isLinux == true || $isMac == true)
        {
            $return = strtolower(strval(shell_exec("sudo a2enmod rewrite")));
            if (strpos($return, "enabling module rewrite") !== false)
            {
                shell_exec('sudo /etc/init.d/apache2 reload');

                printf(json_encode([
                    "error"   => "INTERNAL_SERVER_ERROR",
                    "message" => "MOD_REWRITE not working",
                    "install" => "Installed, please refresh"
                ]));

                exit;
            }
        }
        elseif ($isWindow == true)
        {
            // TODO: windowWs
        }
    }
}

printf(json_encode([
    "error"   => "INTERNAL_SERVER_ERROR",
    "message" => "MOD_REWRITE not working"
]));