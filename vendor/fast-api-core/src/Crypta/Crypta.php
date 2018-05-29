<?php
/**
 * Crypta Class.
 *
 * PHP version 5.6
 *
 * @category Utils
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
namespace FastApi\Crypta;
/**
 * Crypta Class.
 *
 * PHP version 5.6
 *
 * @category Utils
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
class Crypta
{
    public static $encryptMethod    = 'AES-256-CBC';
    private static $_secretKey        = array('ChaveSecreta',
                                            'BASTARDOSINGLORIOS',
                                            '4785699!@#$$$!',
                                            'BancosDoMundo',
                                            'Palmatoria',
                                            'a vingança nunca é plena. Mata a alma e envenena',
                                            'banana',
                                            'pluralidade das coisas',
                                            'internet das coisas',
                                            'frases sem sentido',
                                            'busca',
                                            'tangodown',
                                            'blitz',
                                            'secretachave',
                                            'paisdetodos',
                                            'brasil',
                                            '37727669',
                                            '160604102017',
                                            'AtaqueDDOS',
                                            'SQLInjection',
                                            'Anjos e demonios');
    private static $_secretIV                = 'EsteDeveSerOIV';
    public static $criptedData                = "";
    public static $timeStampHash            = 0;
    public static $secretKeyIndex            = 0;
    /**
     * Decrypts the information sent
     *
     * @param String $string String to decrypt
     * @param Int    $key    Keyword index used in encryption
     * @param Int    $time   Timestamp used at the time of encryption
     * 
     * @return String $output
     */
    public static function decrypt($string, $key, $time)
    {
        $output             = false;
        $method             = self::$encryptMethod;
        $secret_key         = self::$_secretKey[$key];
        $secret_iv          = self::$_secretIV;
        $key                = md5( md5($secret_key.$time));
        $iv                 = substr(md5( md5($secret_iv.$time)), 0, 16);
        $output             = openssl_decrypt(base64_decode($string), $method, $key, 0, $iv);
        return $output;
    }
    /**
     * Encrypts the information to be sent
     *
     * @param String $string String to encrypt
     * 
     * @return String $output
     */
    public static function encrypt($string)
    {
        $output              = false;
        $rand                = rand(0, (count(self::$_secretKey)-1));
        $method              = self::$encryptMethod;
        $secret_key          = self::$_secretKey[$rand];
        $secret_iv           = self::$_secretIV;
        $time                = time();
        $iv                  = substr(md5( md5($secret_iv.$time)), 0, 16);
        $key                 = md5( md5($secret_key.$time));
        $output              = openssl_encrypt($string, $method, $key, 0, $iv);
        $output              = base64_encode($output);
        self::$criptedData    = $output;
        self::$timeStampHash  = $time;
        self::$secretKeyIndex = $rand;
        return array($output,$rand,$time);
    }
}
