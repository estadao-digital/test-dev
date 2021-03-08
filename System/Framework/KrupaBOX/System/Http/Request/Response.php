<?php

namespace Http\Request
{
    class Response
    {
        protected $dataType = text;

        public $error  = null;
        public $data   = null;
        public $header = null;
        public $redirectUrl = null;

        public function __construct($dataType, $data = null, $error = null, $header = null, $redirectUrl = null)
        {
            $this->header = $header;
            $this->error  = $error;
            $this->redirectUrl = $redirectUrl;

            if ($this->error == null && $dataType != text && $dataType != json)
            { $this->error = Arr([message => "Invalid 'dataType'", errorSid => INVALID_DATATYPE, errorCode => 500]); return; }

            $this->dataType = $dataType;

            if ($dataType == json)
            {
                $json = \Serialize\Json::decode($data);
                $jsonLastError = json_last_error();

                if ($jsonLastError !== JSON_ERROR_NONE)
                {
                    $jsonErrorStr = null;

                    if ($jsonLastError === JSON_ERROR_DEPTH)
                        $jsonErrorStr = "JSON_ERROR_DEPTH";
                    elseif ($jsonLastError === JSON_ERROR_STATE_MISMATCH)
                        $jsonErrorStr = "JSON_ERROR_STATE_MISMATCH";
                    elseif ($jsonLastError === JSON_ERROR_CTRL_CHAR)
                        $jsonErrorStr = "JSON_ERROR_CTRL_CHAR";
                    elseif ($jsonLastError === JSON_ERROR_SYNTAX)
                        $jsonErrorStr = "JSON_ERROR_SYNTAX";
                    elseif ($jsonLastError === JSON_ERROR_UTF8)
                        $jsonErrorStr = "JSON_ERROR_UTF8";
                    elseif ($jsonLastError === JSON_ERROR_RECURSION)
                        $jsonErrorStr = "JSON_ERROR_RECURSION";
                    elseif ($jsonLastError === JSON_ERROR_INF_OR_NAN)
                        $jsonErrorStr = "JSON_ERROR_INF_OR_NAN";
                    elseif ($jsonLastError === JSON_ERROR_UNSUPPORTED_TYPE)
                        $jsonErrorStr = "JSON_ERROR_UNSUPPORTED_TYPE";

                    if ($this->error == null)
                        $this->error = Arr([message => "Json decode fail", errorSid => "ERROR_500", errorCode => 500, json => Arr([ errorSid => $jsonErrorStr])]);
                    else $this->error->json->errorSid = $jsonErrorStr;

                    $this->data = Arr([text => $data]);
                    return;
                }

                $this->data = Arr([text => $data, json => $json, phpJson => json_decode($data)]);
            }
            elseif ($dataType == text)
            {
                $this->data = Arr([text => $data, data => $data]);
            }
        }
    }

}