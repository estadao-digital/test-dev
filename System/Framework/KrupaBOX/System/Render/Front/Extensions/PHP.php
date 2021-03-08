<?php

namespace Render\Front\Extensions
{
//    spl_autoload_register(function ($class) {
//        if (!string($class)->startsWith("PHPToJavascript\\")) return false;
//
//        $class = string($class)->subString(string("PHPToJavascript\\")->length);
//        $filePath = __KRUPA_PATH_LIBRARY__ . "Danack/PHPToJavascript/" . $class . ".php";
//
//        if (string($filePath)->contains("CodeConverterState_"))
//            $filePath = string($filePath)->replace("CodeConverterState_", "CodeConverterState/");
//
//        if (\Import::PHP($filePath) == false)
//        {
//            echo $filePath; exit;
//        }
//
//        //return \Import::PHP($filePath);
//    });

    class PHP
    {
        protected static $CLASS_HR_SEPARATOR = "___INIT__KRUPABOX_FRONT__SEPARATOR__CLASS__END__";

        public static function compile($phpString)
        {
            if (stringEx($phpString)->isEmpty()) return null;

            $preCompile  = self::preCompile($phpString);
            $compiled    = self::runCompilation($preCompile->code);
            $postCompile = self::postCompile($compiled, $preCompile->uses, $preCompile->class, $preCompile->namespace);

            return $postCompile;
        }

        protected static function preCompile($phpString)
        {
            $containsConstructClass = false;

            // Make PHP constructors work
            $validatePhpStringConstructor = ("" . $phpString);
            while (stringEx($validatePhpStringConstructor)->contains("__construct"))
            {
                $indexOf = stringEx($validatePhpStringConstructor)->indexOf("__construct");

                $firstPart = stringEx($validatePhpStringConstructor)->subString(0, $indexOf);
                $lastPart  = stringEx($validatePhpStringConstructor)->subString($indexOf + 11);

                if (stringEx($firstPart)->trim("", false)->endsWith("function"))
                    $containsConstructClass = true;

                $validatePhpStringConstructor = ($firstPart . "__javascript_constructor__" . $lastPart);
            }

            if ($containsConstructClass == true)
                $phpString = $validatePhpStringConstructor;

            $phpString .= "\r\n ";
            $tokenizer = new \PHP\Interpreter\Tokenizer($phpString);

            // Extract namespace
            $namespace = $tokenizer->extractNamespace();
            $indexOfLastNS = null;

            if ($namespace != null && $namespace->tokenizer->count() > 2)
            {
                $lastToken = $namespace->tokenizer[($namespace->tokenizer->count() - 1)];
                $indexOfLastNS = $tokenizer->indexOf($lastToken);

                for ($i = 0; $i <= $indexOfLastNS; $i++)
                    $tokenizer[$i]->content = ("//" . $tokenizer[$i]->content);

                $namespaceEndId = $tokenizer->find(($tokenizer->count() - 1), T_CLOSE_CURLY, true);
                if ($namespaceEndId !== false && $namespaceEndId < $tokenizer->count())
                    for ($i = $namespaceEndId; $i < $tokenizer->count(); $i++)
                        $tokenizer[$i]->content = ("//" . $tokenizer[$i]->content);
            }

            // Extract class
            $class = $tokenizer->extractClass();
            $indexOfFirstClass = null;

            if ($class == null || $class->tokenizer == null || $class->tokenizer->count() < 2)
                return null;

            if ($class->tokenizer->count() > 2)
            {
                $firstToken = $class->tokenizer[0];
                $indexOfFirstClass = $tokenizer->indexOf($firstToken);
            } else return null;

            //extract using statements
            $getUseStatements = Arr();
            $i = 0;
            while ($i = $tokenizer->find($i, T_USE))
            {
                $find = false;
                $isAlias = false;
                $useMount = "";
                $lastClass = "";

                $j = ($i + 1);
                while(isset($tokenizer[$j]))
                {
                   // dump($tokenizer[$j]);
                    if ($tokenizer[$j]->typeSid == "T_SEMICOLON")
                    { $find = true; break; }

                    if ($tokenizer[$j]->typeSid == "T_STRING")
                    {
                        $useMount .= ($tokenizer[$j]->content . ".");
                        $lastClass = $tokenizer[$j]->content;
                    }
                    elseif ($tokenizer[$j]->typeSid == "T_AS")
                    { $find = true; $isAlias = true; break; }

                    $j++;
                }

                if ($isAlias == true)
                {
                    $alias = "";
                    while(isset($tokenizer[$j])) {
                        if ($tokenizer[$j]->typeSid == "T_STRING")
                        { $alias = $tokenizer[$j]->content; break; }
                        $j++;
                    }
                    if ($alias != "") $lastClass = $alias;
                }

                if ($useMount != "") $useMount = stringEx($useMount)->subString(0, stringEx($useMount)->count - 1);
                if ($find == true && $useMount != "" && $lastClass != "")
                    $getUseStatements[$lastClass] = $useMount;

                $i = $j;
            }

            // Merge use with code
            $i = $indexOfFirstClass;
            while ($i = $tokenizer->find($i, T_NS_SEPARATOR))
            {
                if ($i <= 0) continue;

                if ($tokenizer[($i - 1)]->typeSid == "T_STRING" && $tokenizer[($i - 2)]->typeSid != "T_NS_SEPARATOR" && $tokenizer[($i - 2)]->typeSid != "T_STRING")
                {
                    $isAliasCalling = false;
                    foreach ($getUseStatements as $alias => $_) {
                        if ($alias == $tokenizer[($i - 1)]->content)
                        { $isAliasCalling = true; break; } }

                    if ($isAliasCalling == false)
                        $tokenizer[($i - 1)]->content = stringEx((($namespace != null ? ($namespace->namespace . $tokenizer[$i]->content) : "") .
                            $class->class . self::$CLASS_HR_SEPARATOR . $tokenizer[($i - 1)]->content))->replace("\\", self::$CLASS_HR_SEPARATOR);

                    $tokenizer[$i]->type = T_COMMENT;
                }
                elseif ($tokenizer[($i - 1)]->typeSid != "T_STRING")
                {
                    $tokenizer[$i]->content = "";
                    $tokenizer[$i]->type = T_WHITESPACE;
                }
            }

            $i = $indexOfFirstClass;
            while ($i = $tokenizer->find($i, T_STRING))
            {
                if ($tokenizer[$i]->content == "self")
                    $tokenizer[$i]->content = stringEx($namespace != null ? ($namespace->namespace . self::$CLASS_HR_SEPARATOR . $class->class) : $class->class)->replace("\\", self::$CLASS_HR_SEPARATOR);
            }

            for ($i = $indexOfFirstClass; $i < $tokenizer->count(); $i++)
                if ($tokenizer[$i]->typeSid == "T_NS_SEPARATOR" && $tokenizer[$i]->content == "\\")
                    $tokenizer[$i]->content = self::$CLASS_HR_SEPARATOR;

            foreach ($class->tokenizer as $token)
                if ($token->typeSid == "T_STRING")
                { $token->content = stringEx($namespace != null ? ($namespace->namespace . self::$CLASS_HR_SEPARATOR . $class->class) : $class->class)->replace("\\", self::$CLASS_HR_SEPARATOR); break; }

            $preCode = "";
            foreach ($tokenizer as $token)
                $preCode .= $token->content;

            // extract function parameters
//            $functions = Arr();
//            $i = 0;
//            while ($i = $tokenizer->find($i, T_FUNCTION))
//            {
//                if ($i <= 0) continue;
//
//
//                $i = ($i + 1);
//                while (isset($tokenizer[$i]) && $tokenizer[$i]->typeSid == "T_WHITESPACE")
//                    $i++;
//
//                if (isset($tokenizer[$i]) && $tokenizer[$i]->typeSid == "T_STRING")
//                {
//                    $functionName = $tokenizer[$i]->content;
//                    $j = ($i - 1);
//                    while (isset($tokenizer[$j]) && $tokenizer[$j]->typeSid == "T_WHITESPACE" || $tokenizer[$j]->typeSid == "T_FUNCTION")
//                        $j--;
//                    $isStatic = ($tokenizer[$j]->typeSid == "T_STATIC");
//
//                    $i++;
//                    while (isset($tokenizer[$i]) && $tokenizer[$i]->typeSid == "T_WHITESPACE")
//                        $i++;
//
//                    if (isset($tokenizer[$i]) && $tokenizer[$i]->typeSid == "T_OPEN_ROUND")
//                    {
//                        $i++;
//                        while (isset($tokenizer[$i]) && $tokenizer[$i]->typeSid == "T_WHITESPACE")
//                            $i--;
//
//                    }
//
//                    dump($functionName);
//                    dump($tokenizer[$i]);
//                }
//
//            }
//
//dump($getUseStatements);
//            exit;


            return Arr([code => $preCode, uses => $getUseStatements, "class" => $class->class, "namespace" => $namespace]);
        }

        protected static function runCompilation($preCode)
        {
            \KrupaBOX\Internal\Library::load("Danack"); //PhpToJavascript

            $phpToJavascript = new \PHPToJavascript\PHPToJavascript();
            $phpToJavascript->addFromString($preCode);
            $compiledJS = $phpToJavascript->toJavascript();

            return $compiledJS;
        }

        protected static function postCompile($code, $uses, $class, $namespace)
        {
            // Inject uses (namespaces)
            if ($uses->count > 0)
            {
                $indexOf = stringEx($code)->indexOf("function (");
                while ($indexOf !== null)
                {
                    $injectCode = stringEx($code)->subString(0, $indexOf);
                    $injectCode .= "__INIT__KRUPABOX_INJECT_FUNCTION__END__";
                    $injectCode .= stringEx($code)->subString($indexOf + 8);

                    $preSplit = stringEx($injectCode)->subString($indexOf);
                    $indexOfStartFunc = stringEx($preSplit)->indexOf("{");

                    if ($indexOfStartFunc != null)
                    {
                        $leftSplit  = stringEx($injectCode)->subString(0, ($indexOf + $indexOfStartFunc + 1));
                        $rightSplit = stringEx($injectCode)->subString($indexOf + $indexOfStartFunc + 1);

                        $code = ($leftSplit . "\r\n");
                        foreach ($uses as $alias => $_namespace)
                            $code .= ("var " . $alias . " = " . $_namespace . "; ");
                        $code .= ("\r\n" . $rightSplit);
                    }
                    $indexOf = stringEx($code)->indexOf("function (");
                }

                $code = stringEx($code)->replace("__INIT__KRUPABOX_INJECT_FUNCTION__END__", "function");
            }

            // Correct function class caller name to __
            $fullClass = "";
            if ($namespace != null && $namespace->namespace != null && !stringEx($namespace->namespace)->isEmpty())
                $fullClass .= $namespace->namespace;
            if (!stringEx($class)->isEmpty())  {
                if ($fullClass != "") $fullClass .= "\\";
                $fullClass .= $class;
            }

            $fullClassNow = stringEx($fullClass)->replace("\\", self::$CLASS_HR_SEPARATOR);
            $fullClassFix = stringEx($fullClass)->replace("\\", "__");

            $code = stringEx($code)->replace("function " . $fullClassNow. "(", "function " . $fullClassFix. "(");

            // Add construct inject key
            while (true)
            {
                $lastCloseIndexOf = stringEx($code)->lastIndexOf("}");

                if ($lastCloseIndexOf !== false)
                {
                    if (stringEx($code)->subString($lastCloseIndexOf - 2, 2) == "//")
                    {
                        $injectCode = stringEx($code)->subString(0, $lastCloseIndexOf);
                        $injectCode .= "__INIT_KRUPABOX_INJECT_OBJECT_KEY__";
                        $injectCode .= stringEx($code)->subString($lastCloseIndexOf + 1);
                        $code = $injectCode;
                        continue;
                    }

                    $injectCode = stringEx($code)->subString(0, $lastCloseIndexOf);
                    $injectCode .= "/* __INIT_KRUPABOX_INJECT_CONSTRUCT__ */\r\n\r\n";
                    $injectCode .= stringEx($code)->subString($lastCloseIndexOf);
                    $code = $injectCode;
                    break;
                }
                break;
            }
            $code = stringEx($code)->replace("__INIT_KRUPABOX_INJECT_OBJECT_KEY__", "}");

            // Check if exists function or static vars AND insert hierarchy controllers (namespaces)
            if (stringEx($code)->contains($fullClassNow))
            {
                $firstCallIndex = stringEx($code)->indexOf($fullClassNow);

                $injectCode = stringEx($code)->subString(0, $firstCallIndex);
                $injectCode .= "/* __INIT_KRUPABOX_INJECT_NAMESPACE_SYSTEM__END__ */\r\n\r\n";
                $injectCode .= stringEx($code)->subString($firstCallIndex);

                $code = $injectCode;
            }
            else $code .= "\r\n\r\n/* __INIT_KRUPABOX_INJECT_NAMESPACE_SYSTEM__END__ */";
            
            // Replace class hierarchy split to native js split
            $code = stringEx($code)->replace(self::$CLASS_HR_SEPARATOR, ".");
            return $code;
        }
    }
}