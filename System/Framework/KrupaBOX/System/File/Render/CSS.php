<?php

namespace File\Render;

class CSS
{    
    public static function Output($filePath)
    {
        if (!\File::exists($filePath))
            \Kernel::close();
            
        $css = \File::getContents($filePath);

        // Extract var class
        $varString = null;
        $varArray = null;
        $indexOf = null;
        
        if (stringEx($css)->contains("var {"))
            $indexOf = stringEx($css)->indexOf("var {");
        elseif (stringEx($css)->contains("var{"))
            $indexOf = stringEx($css)->indexOf("var{");
        elseif (stringEx($css)->contains("var\n{"))
            $indexOf = stringEx($css)->indexOf("var\n{");
        elseif (stringEx($css)->contains("var\r\n{"))
            $indexOf = stringEx($css)->indexOf("var\r\n{");

        if ($indexOf === null)
            \File\Render::OutputByString($css, "text/css");

        $removeVar = stringEx($css)->subString($indexOf, stringEx($css)->length - $indexOf);
        $indexOf = null;
        
        if (stringEx($removeVar)->contains("}"))
            $indexOf = stringEx($removeVar)->indexOf("}");

        if ($indexOf === null)
            \File\Render::OutputByString($css, "text/css");
            
        $varString = stringEx($removeVar)->subString(0, $indexOf + 1);
        $varString = stringEx($varString)->remove("var {", false)->remove("}");
        $varString = stringEx($varString)->remove("var{", false)->remove("}");
        $varString = stringEx($varString)->remove("var\n{", false)->remove("}");
        $varString = stringEx($varString)->remove("var\n\r{", false)->remove("}");

        $split = stringEx($varString)->split(";");
        $cleanSplit = [];
        
        foreach ($split as $_split)
        {
            $__split = trim($_split);
            
            if (!stringEx($__split)->isEmpty())
                $cleanSplit[] = $__split;
        }
        
        foreach ($cleanSplit as $_cleanSplit)
        {
            $varSplit = stringEx($_cleanSplit)->split(":");
            
            $varSplit[0] = trim($varSplit[0]);
            $varSplit[1] = trim($varSplit[1]);
            
            if (\arrayk($varSplit)->count >= 2 && !stringEx($varSplit[0])->isEmpty())
                $varArray[($varSplit[0])] = $varSplit[1];
        }

        foreach ($varArray as $var => &$value)
        {
            if (stringEx($value)->startsWith("calculate("))
            {
                $value = stringEx($value)->subString(10, stringEx($value)->length - 9);
                $value = stringEx($value)->subString(0, stringEx($value)->length - 1);
                $value = preg_replace("/[^0-9-+(*)]/", "", $value);
                
                $calc = null;
                eval("\$calc = $value;");
                $value = $calc;
            }
        }

        $indexOf = 0;

        if (stringEx($css)->contains("var {"))
            $indexOf = stringEx($css)->indexOf("var {");
        elseif (stringEx($css)->contains("var{"))
            $indexOf = stringEx($css)->indexOf("var{");
        elseif (stringEx($css)->contains("var\n{"))
            $indexOf = stringEx($css)->indexOf("var\n{");
        elseif (stringEx($css)->contains("var\r\n{"))
            $indexOf = stringEx($css)->indexOf("var\r\n{");

        if (($indexOf - 1) > 0)
            $cleanCss = stringEx($css)->subString(0, $indexOf - 1);
            
        $indexOf = 0;
        
        if (stringEx($removeVar)->contains("}"))
            $indexOf = stringEx($removeVar)->indexOf("}");
        
        $cleanCss .= stringEx($removeVar)->subString($indexOf + 1, stringEx($removeVar)->length - $indexOf);

        foreach ($varArray as $var => &$value)
        {
            $cleanCss = stringEx($cleanCss)->
                replace("(var." . $var . ")", $value, false)->
                replace("var." . $var, $value);
        }
        
        \File\Render::OutputByString($cleanCss, "text/css");
    }
}