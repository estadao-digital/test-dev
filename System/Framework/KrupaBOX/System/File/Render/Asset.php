<?php

namespace File\Render;

class Asset
{    
    public static function getAssetUrl()
    {
        $CI = &get_instance();
        
        $uriString = $CI->uri->uri_string();
        $filePath = stringEx($uriString)->subString(7, stringEx($uriString)->length - 7);

        $asset = stringEx($filePath)->isEmpty()
            ? null
            : $filePath;
            
        return $asset;
    }
    
    public static function execute()
    {
        $asset = self::getAssetUrl();

        if ($asset == null)
            return;

        if (stringEx($asset)->endsWith("JavaScript.Aplication.js"))
            self::compileApplication($asset);

        $asset = "assets/" . $asset;
        
        $asset = APPPATH . $asset;

        if ($asset != null && \File::exists($asset))
        {
            if (\File::getFileExtension($asset) == CSS)
            {
                \File\Render\CSS::Output($asset);
                \KrupaBOX\Internal\Kernel::exit();
            }

            \File\Render::Output($asset);
        }  
    }
    
    private static $files = [];
    
    private static function listApplicationFiles($dir, $prefix)
    {
        $prefix = stringEx($prefix)->toString();
        
        foreach ($dir as $key => $_dir)
        {
            $_prefix = "" . $prefix;
 
            if (\Variable::get($_dir)->isArray())
            {
                $_prefix = $_prefix . $key . "/";
            
                self::listApplicationFiles($_dir, $_prefix);
                continue;
            }
                
            self::$files[] = $_prefix . $_dir;
        }
        
        return self::$files;
    }
    
    private static function compileApplication($asset)
    {
        $dir = \DirectoryEx::listDirectory(APPPATH . "javascripts");
        $files = self::listApplicationFiles($dir);
        
        $orderedFiles = [];
        $data = "";
        
        foreach ($files as $file)
        {
            $count = substr_count($file, '/');
            
            if ($orderedFiles[$count] == null)
                $orderedFiles[$count] = [];
                
            $orderedFiles[$count][] = $file;
        }
 
        $files = [];
        $masterFile = null;
        
        for ($i = 0; $i < 15; $i++)
        {
            $break = false;
            
            foreach ($orderedFiles[$i] as $file)
                if (\File::getFileName($file) == "App.js")
                { $masterFile = $file; $break = true; break; }

            if ($break == true)
                break;
        }
        
        $files[] = $masterFile;
        
        for ($i = 0; $i < 15; $i++)
            foreach ($orderedFiles[$i] as $file)
                if ($file != $masterFile)
                    $files[] = $file;
        
        $controllerCount = 0;
        
        foreach ($files as $file)
        {
            if (\File::getFileExtension($file) != JS)
                continue;
                
            $fileData = \File::getContents(APPPATH . "javascripts/" . $file);
            $fileName = \File::getFileName(APPPATH . "javascripts/" . $file);
            
            $namespace = stringEx($file)->Substring(0, stringEx($file)->length - stringEx($fileName)->length - 1);
            $fileData = stringEx($fileData)->toString() . "Kernel.register(new __CLASS__(), __NAMESPACE__);";
            $fileData = stringEx($fileData)->replace("__NAMESPACE__", "\"" . $namespace . "\"");
                
            $className = stringEx($namespace)->replace("/", "__REF__");
            $className .= "__REF__" . stringEx($fileName)->subString(0, stringEx($fileName)->length - 3);
            $fileData = stringEx($fileData)->replace("__CLASS__", "KrupaJS__" . $className);

            $_this = stringEx($file)->subString(0, stringEx($file)->length - 3);
            $_this = stringEx($_this)->replace("/", ".");
            $fileData = stringEx($fileData)->replace("__THIS__", $_this);
            $fileData = stringEx($fileData)->replace("&this", $_this);

            $data .= "" .
                "// KRUPA APPLICATION COMPILER\n" .
                "// MODULE: '" . $file . "'\n" .
                $fileData . "\n\n";
                
            $controllerCount++;
        }
        
        $compiledKrupaJS = "";
        
        foreach (self::$krupaInternalFiles as $krupaInternalFile)
        {
            $internalFile = \File::getContents(__KRUPA_PATH_INTERNAL__ . "Extension/KrupaJS/" . $krupaInternalFile);
            
            if (!stringEx($internalFile)->isEmpty())
            {
                $compiledKrupaJS .= "\n\n// KRUPA APPLICATION COMPILER\n// INTERNAL: '" . $krupaInternalFile . "'\n\n";
                $compiledKrupaJS .= $internalFile;
            }
        }

        $compiledKrupaJS = stringEx($compiledKrupaJS)->replace("{KrupaBOX::TOTAL_CONTROLLER_COUNT}", $controllerCount);
                
        $data = stringEx($compiledKrupaJS)->replace("{KrupaBOX::COMPILED_APPLICATION}", $data);
        $data = stringEx($data, \stringEx::ENCODING_UTF8);
        \File\Render::OutputByString($data, "text/javascript");
    }
    
    private static $krupaInternalFiles = [
        "jQuery.js",
        "KrupaJS.js",
        
        "Core/String.js",
        "Core/Object.js",
        "Core/Array.js",
        "Core/Function.js",
        
        "System/Kernel.js",
        "System/Input.js",
        "System/Timer.js",
        "System/Window.js",
        
        "System/DOM.js",
        "System/DOM/Class.js",
        "System/DOM/Inner.js",
        "System/DOM/Outer.js",
        "System/DOM/Event.js",
        "System/DOM/Canvas.js",
        "System/DOM/Renderer.js",
        "System/DOM/Select.js",
        
        "System/Application.js" //include Compiled
    ];
}