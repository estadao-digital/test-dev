<?php
/**
 * Sender Class.
 *
 * PHP version 5.6
 *
 * @category Utils
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
namespace FastApi\Sender;
/**
 * Sender Class.
 *
 * PHP version 5.6
 *
 * @category Utils
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
class Sender
{
    public $options = array(
                            CURLOPT_URL    =>'',
                            CURLOPT_POST => false,
                            CURLOPT_SSL_VERIFYPEER => false,
                            CURLOPT_SSL_VERIFYHOST => false,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_CONNECTTIMEOUT => 120,
                            CURLOPT_TIMEOUT => 120,
                            CURLOPT_POSTFIELDS    => '');
    private $_connection    = null;
    private $_response      = null;
    private $_httpStatus    = null;
    /**
     * Sets the CURL parameter
     * 
     * @param Int   $parameter A valid CURL parameter
     * @param mixed $value     The value for the CURL parameter
     * 
     * @return void
     */
    public function setParameters($parameter, $value)
    {
        $this->options[$parameter] = $value;
    }
    /**
     * Each the parameters of the array, called curl_setopt 
     * to define these parameters for the transmission
     * 
     * @return void
     */
    private function _setRequestParameters()
    {
        foreach ($this->options as $option => $value) {
            if ($value ===false || $value === true || $value !='') {
                curl_setopt($this->_connection, $option, $value);
            }
        }
        return true;
    }
    /**
     * Execute the CURL
     * 
     * @return String $this_response
     */
    public function send()
    {
        $this->_connection    = curl_init();
        $this->_setRequestParameters();
        $this->_response      = curl_exec($this->_connection);
        $this->_httpStatus    = curl_getinfo($this->_connection, CURLINFO_HTTP_CODE);
        $info                 = curl_getinfo($this->_connection);
        curl_close($this->_connection);
        return $this->_response;
    }
    /**
     * Returns the request's http status
     * 
     * @return Int $this->_httpStatus
     */
    public function gethttpStatusCode()
    {
        return $this->_httpStatus;
    }
}
