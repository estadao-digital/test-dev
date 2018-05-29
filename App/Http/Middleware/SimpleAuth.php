<?php
/**
 * Middleware SimpleAuth.
 *
 * PHP version 5.6
 *
 * @category Middleware
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
namespace App\Http\Middleware;

use App\Utils\Logs\Logs;
/**
 * Middleware SimpleAuth.
 *
 * PHP version 5.6
 *
 * @category Middleware
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
class SimpleAuth
{
    private $_passwd = AUTH_PWD;
    /**
     * Provide the Http Headers
     *
     * @return getallheaders()
     */
    private function _provideHeaders()
    {
        return getallheaders();
    }
    /**
     * Validate the password sent
     *
     * @return getallheaders()
     */
    private function _validatePWD()
    {
        $headers        = $this->_provideHeaders();
        $auth           = $headers['X-NSTALKER-AUTH'];
        $getTimeStamp   = trim(substr($auth, 32, 12));
        $date           = new \DateTime(null, new \DateTimeZone('UTC'));
        
        if (($date->getTimeStamp()) - $getTimeStamp > 15) {
            Logs::save('The token is invalid because it has been expired ['.$auth.']', 1);
            throw new \Exception("Not authorized [COD 002]");
        }
        if (md5($this->_passwd.$getTimeStamp).$getTimeStamp != $auth) {
            Logs::save('The token is invalid because the hash does not match ['.$auth.']', 1);
            throw new \Exception("Not authorized [COD 001]");
        }
        return true;
    }
    /**
     * Execute the middleware
     *
     * @return $this->_validatePWD()
     */
    public function run()
    {
        return $this->_validatePWD();
    }
}
