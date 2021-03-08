<?php

namespace File
{
    class Wrapper
    {
        public static function parsePath($filePath)
        {
            $filePath    = stringEx($filePath)->toString();
            $filePathObj = stringEx($filePath)->toLower(false);

            if ($filePathObj->startsWith('cache://'))
                $filePath = (\Garbage\Cache::getCachePath() . stringEx($filePath)->subString(8));
            elseif ($filePathObj->startsWith('server://'))
                $filePath = (SERVER_FOLDER . stringEx($filePath)->subString(9));
            elseif ($filePathObj->startsWith('client://'))
                $filePath = (CLIENT_FOLDER . stringEx($filePath)->subString(9));
            elseif ($filePathObj->startsWith('app://'))
                $filePath = (APPLICATION_FOLDER . stringEx($filePath)->subString(6));
            elseif ($filePathObj->startsWith('config://'))
                $filePath = (APPLICATION_FOLDER . 'Config/' . stringEx($filePath)->subString(9));
            elseif ($filePathObj->startsWith('public://'))
                $filePath = (CLIENT_FOLDER . 'Public/' . stringEx($filePath)->subString(9));
            elseif ($filePathObj->startsWith('view://'))
                $filePath = (CLIENT_FOLDER . 'View/' . stringEx($filePath)->subString(7));
            elseif ($filePathObj->startsWith('tags://'))
                $filePath = (CLIENT_FOLDER . "Tags/" . stringEx($filePath)->subString(7));
            elseif ($filePathObj->startsWith('datadb://'))
                $filePath = (APPLICATION_FOLDER . 'Data/' . stringEx($filePath)->subString(9));
            elseif ($filePathObj->startsWith('root://'))
                $filePath = (ROOT_FOLDER . stringEx($filePath)->subString(7));
            elseif ($filePathObj->startsWith('build://'))
                $filePath = (APPLICATION_FOLDER . '.build/' . stringEx($filePath)->subString(8));
            elseif ($filePathObj->startsWith('composer://'))
                $filePath = (APPLICATION_FOLDER . '.composer/' . stringEx($filePath)->subString(11));

            return $filePath;
        }
    }
}