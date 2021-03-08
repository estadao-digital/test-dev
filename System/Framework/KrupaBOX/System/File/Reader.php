<?php

namespace File;

class Reader
{
    public static function CSV($csvFilePath, $fromLine = null, $toLine = null)
    {
        $data = [];
        $currentLine = 0;
        $isInfinite = false;
        
        if ($fromLine == null)
            $fromLine = 0;
        $fromLine = \intEx($fromLine)->toInt();

        if ($toLine != null)
        {
            $toLine = \intEx($toLine)->toInt();
            if ($toLine < 0) $isInfinite = true;
        }
        else $isInfinite = true;
        
        if (!\File::exists($csvFilePath))
            return null;
    
        $fileHandle = \fopen($csvFilePath, 'r');
        
        while (!\feof($fileHandle))
        {
            $csvData = \fgetcsv($fileHandle);
            
            if ($currentLine >= $fromLine)
            {
                if ($isInfinite == false && $currentLine >= ($toLine - 1))
                    break;
                    
                if (\Variable::get($csvData)->isArray() == true)
                    $data[$currentLine] = $csvData;
            }

            $currentLine++;
        }
        
        \fclose($fileHandle);
        return $data;
    }
    
    public static function XML($xmlFilePath)
    {
        $xmlFilePath = stringEx($xmlFilePath)->toString();
        
        if (!\File::exists($xmlFilePath))
            return null;
         
        $xmlString = \File::getContents($xmlFilePath);
        $xmlString = stringEx($xmlString)->toString();
        
        if ($xmlString == null || stringEx($xmlString)->isEmpty())
            return null;

        if (!@function_exists("simplexml_load_string"))
        { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Missing XML extension."]); \KrupaBOX\Internal\Kernel::exit(); }

        $xmlData = simplexml_load_string($xmlString, "SimpleXMLElement", LIBXML_NOCDATA);
        
        $jsonEncode = json_encode($xmlData);
        $jsonDecode = json_decode($jsonEncode);
        
        return $jsonDecode;
    }
    
    public static function CSS($cssFilePath)
    {
        if (!\File::exists($cssFilePath))
            return null;
     
        self::__loadCssClass();       
        $cssString = \File::getContents($cssFilePath);
            
        $oCssParser = new \CSS\Parser($cssString);
        return $oCssParser->parse();
    }
    
    private static $isCssClassLoaded = false;
        
    private function __loadCssClass()
    {
        if (self::$isCssClassLoaded == true)
            return;

        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/Parser.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/Settings.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/Renderable.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/Property/AtRule.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/Property/Selector.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/Value/Value.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/Value/ValueList.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/Value/RuleValueList.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/Value/CSSFunction.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/Value/Color.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/Value/PrimitiveValue.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/Value/Size.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/CSSList/CSSList.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/CSSList/CSSBlockList.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/CSSList/Document.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/Rule/Rule.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/RuleSet/RuleSet.php");
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Extension/SabberwormCSS/RuleSet/DeclarationBlock.php");

        self::$isCssClassLoaded = true;
    }
}