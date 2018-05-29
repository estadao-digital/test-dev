<?php
/**
 * Logs Class.
 *
 * PHP version 5.6
 *
 * @category Utils
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
namespace FastApi\Logs;
/**
 * Logs Class.
 *
 * PHP version 5.6
 *
 * @category Utils
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
class Logs
{
    private static $_logType = array(1 => 'Notice: ',2 => 'Warning: ', 3 =>'Error: ');
    /**
     * Save the log
     * 
     * @param String $message A message to save
     * @param Int    $type    The log type
     * @param String $logFile The name to the log file
     * 
     * @return void
     */
    public static function save($message, $type, $logFile = 'api.log')
    {
        $dir        = LOG_DIR;
        $date       = date("Y-m-d H:i:s");
        $arq        = fopen($dir.$logFile, "a+");
        $requester  = '';
        $postFields = '';
        if (REQUEST_LOG == '1' || REQUEST_LOG == true) {
            $requester  = (isset($_SERVER['REMOTE_ADDR']) ? PHP_EOL."Source: ". $_SERVER['REMOTE_ADDR'].PHP_EOL : null);
            $postFields = $requester != null ? isset($_REQUEST) ? PHP_EOL."POST: ".print_r($_REQUEST, true).PHP_EOL :  '' : '';
        }
        switch ($type) {
        case 1:
        case 2:
            fwrite($arq, $date.' - '.self::$_logType[$type].$requester.$postFields.$message.PHP_EOL);
            break;
        case 3:
            fwrite($arq, $date.' - '.self::$_logType[$type].$requester.$postFields.$message.PHP_EOL."Backtrace: ".print_r(debug_backtrace(), true).PHP_EOL);
            break;
        }
        fclose($arq);
        if ((int)(filesize($dir.$logFile) / pow(1024, 2)) >= 2) {
            unlink($dir.$logFile, $dir.$logFile.'.1');
        }
    }
}
