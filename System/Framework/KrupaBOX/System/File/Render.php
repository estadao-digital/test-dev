<?php

namespace File;

class Render
{
    public static function OutputByString($string, $mimeType = "text/html")
    {
        $mimeType = stringEx($mimeType)->toString();
        
        \Header::setContentType($mimeType);
        \Header::sendHeader();
        
        echo $string;
        \Kernel::close();
    }
    
    public static function Output($filePath, $mimeType = null, $forceDownload = false, $downloadFileName = null)
    {
        if (!\File::exists($filePath))
            \Kernel::close();

        $fileExtension = nul;
        
        if ($mimeType == null)
        {
            
            $fileExtension = \File::getFileExtension($filePath);
            $mimeTypes = \File\MIME::getMIMEsByExtension($fileExtension);
  
            if ($mimeTypes != null && $mimeTypes->count > 0)
                $mimeType = $mimeTypes[0];
        }

        $fileData = \File::getContents($filePath);
        
        if ($mimeType != null)
        {
            \Header::setContentType($mimeType);
            
            // Unity3D support
            if ($mimeType == "application/x-gzip")
            {
                $fileExtension = stringEx($fileExtension)->toLower();
                
                if ($fileExtension == "datagz" || $fileExtension == "jsgz" || $fileExtension == "memgz" || $fileExtension == "unity3dgz")
                { \Header::setContentEncoding(\Header::ENCODING_TYPE_GZIP); \Header::setContentType("application/octet-stream"); } 
            }
        }
            
        if ($forceDownload == true)
        {
            $downloadFileName = stringEx($downloadFileName)->toString();
        
            if (stringEx($downloadFileName)->isEmpty())
                $downloadFileName = \File::getFileName($filePath);
            
            \Header::setContentDisposition(\Header::DISPOSITION_TYPE_FILENAME, $downloadFileName);
        }

        \Header::sendHeader();

        echo $fileData;
        \Kernel::close();
    }
}