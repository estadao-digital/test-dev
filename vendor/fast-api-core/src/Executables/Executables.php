<?php
/**
 * Executables Class.
 *
 * PHP version 5.6
 *
 * @category Utils
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
namespace FastApi\Executables;
/**
 * Executables Class.
 *
 * PHP version 5.6
 *
 * @category Utils
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
class Executables
{
    /**
     * Execute a binary
     * 
     * @param String $bin        The bibary
     * @param String $executable Script interpreted by binary
     * 
     * @return exec() | COM::Run
     */
    public static function execute($bin, $executable)
    {
        if (substr(PHP_OS, 0, 3) =='WIN') {
            $WshShell = new \COM("WScript.Shell");

            return $WshShell->Run($bin." ".$executable, 0, false);
        }
        return exec("nohup nice -20 ".$bin." ".$executable." > /tmp/executables.txt & echo $!");
    }
}
