<?php
/*
namespace KrupaBOX\Internal
{   
    class Inject
    {
        protected static $masterForNamespaces = 
        [ "CodeIgniter" => [] ];
        
        protected static $pathsForNamespace = [
            "System\\Extensions\\CodeIgniter\\" => "CodeIgniter"
        ];

        
        public static function load()
        {
            
           /* function find_all_files($dir) 
            { 
                $root = scandir($dir); 
                foreach($root as $value) 
                { 
                    if($value === '.' || $value === '..') {continue;} 
                    if(is_file("$dir/$value")) {$result[]="$dir/$value";continue;} 
                    foreach(find_all_files("$dir/$value") as $value) 
                    { 
                        $result[]=$value; 
                    } 
                } 
                return $result; 
            } 


            $scan = find_all_files(__KRUPA_PATH_SYSTEM__ . "Extensions/CodeIgniter");
            
            function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

echo "oi";
            foreach ($scan as $file)
            {
            //    echo $file , "<br/>";
                
                if (!endsWith($file, ".php"))
                    continue;
                    
                echo $file , "<br/>";
                $compiled = self::compilePhp($file);
                file_put_contents($file, "<?php\r\n" . $compiled);
            }

            
            //exit;
            
            //$compiled = self::compilePhp(__KRUPA_PATH_SYSTEM__ . "Extensions/CodeIgniter/index.php");
            //echo $compiled;
            //file_put_contents(__KRUPA_PATH_SYSTEM__ . "Extensions/CodeIgniter/index.php", "<?php\r\n" . $compiled);
        
        exit;*/
            //include_once(__KRUPA_PATH_SYSTEM__ . "Extensions/CodeIgniter/index.php");
            //$CI = &codeigniter_get_instance();

            //self::$masterForNamespaces["CodeIgniter"] = (object)["config" => [], "_classes" => [] ];
            //$a = self::compilePhp(__KRUPA_PATH_SYSTEM__ . "Extensions/CodeIgniter/index.php");
            //echo $a;
            //eval($a);
            //echo "OOA";
            
            //print_r($a);
       /* }
        
        protected static function validateNamespace($namespace = null, $phpFilePath = null)
        {
            $namespace = strval($namespace);
            
            if (strlen($namespace) >= 0)
            {
                $namespace = str_replace("/", "\\", $namespace);
            
                while (strpos($namespace, "\\")  === 0) $namespace = substr($namespace, 1, strlen($namespace) - 1);
                while (strrpos($namespace, "\\") === (strlen($namespace) - 1)) $namespace = substr($namespace, 0, strlen($namespace) - 1);
            }
            
            $_phpFilePath = str_replace("/", "\\", strval($phpFilePath));

            if (strlen($namespace) <= 0)
            {
                if (strlen($_phpFilePath) <= 0)
                    return null;

                foreach (self::$pathsForNamespace as $key => $value)
                {
                    $_key = str_replace("/", "\\", $key);
                    
                    if (strpos($_phpFilePath, $_key) !== false)
                        return $value;
                }

                return null;
            }
  
            return $namespace;
        }
        
        public static function GetMaster($namespace)
        {
            if (!isset(self::$masterForNamespaces[$namespace]))
                return null;

            return self::$masterForNamespaces[$namespace];  
        }
        
        public static function RequireOnceInjected($requiredPath)
        {
            //$xnamespace = self::validateNamespace(null, $path);
            
            //echo $xnamespace . "<<<";
            //echo $requiredPath . "\n\n";
                
            $compile = self::compilePhp($requiredPath);
            echo $compile;    
            
            eval($compile);
            //exit;
            
            //$trace = debug_backtrace();
            //var_dump($trace);
            
            //echo "injected";
        }
        
        protected static function getNamespacesAndClasses($phpFile, $isCompiled = true)
        {
            $buffer = $phpFile;
            
            if ($isCompiled == true)
                $buffer = "<?php " . $phpFile . "?>";

            $lastNamespace = "";
            $fullClasses = [];
            $plainClasses = [];
;
            $tokens = token_get_all($buffer);
        
            //if (strpos($buffer, '{') === false) continue;
        
            for ($i = 0;$i<count($tokens);$i++) {
                if ($tokens[$i][0] === T_NAMESPACE) {
                    for ($j=$i+1;$j<count($tokens); $j++) {
                        if ($tokens[$j][0] === T_STRING) {
                             $findNamespace = '\\'.$tokens[$j][1];
                             $lastNamespace = $findNamespace;
                             $fullClasses[$findNamespace] = [];
                        } else if ($tokens[$j] === '{' || $tokens[$j] === ';') {
                             break;
                        }
          
                    }
                }
                elseif ($tokens[$i][0] === T_CLASS) {
                    for ($j=$i+1;$j<count($tokens);$j++) {
                        if ($tokens[$j] === '{') {
                            if (isset($tokens[$i+2][1]))
                            {
                                $findClass = $tokens[$i+2][1];
                                
                                if (strlen($lastNamespace) <= 0)
                                {
                                    if (count($plainClasses) == 0 || $plainClasses[(count($plainClasses) - 1)] != $findClass)
                                        $plainClasses[] = $findClass;
                                } 
                                else
                                {
                                    if (count($fullClasses[$lastNamespace]) == 0 || $fullClasses[$lastNamespace][(count($fullClasses[$lastNamespace]) - 1)] != $findClass)  
                                    {
                                        $fullClasses[$lastNamespace][] = $findClass;
                                    }
                                }   
                                
                            }     
                        }
                    }
                }
            }
        
            $data = [];
            $waitingInsert = null;
            
            $lastClass = end($fullClasses); 
            
            foreach ($fullClasses as $key => $fullClass)
            {
                if (count($fullClass) <= 0)
                {
                    if ($waitingInsert == null)
                        $waitingInsert = "";
                        
                    $waitingInsert .= $key;
                    continue;
                }
                
                if ($waitingInsert != null || $fullClass == $lastClass)
                {
                    $finalKey =  $waitingInsert . $key;
                    
                    if (strpos($finalKey, "\\")  === 0)
                        $finalKey = substr($finalKey, 1, strlen($finalKey));
                        
                    $data[] = ["namespace" => $finalKey, "classes" => $fullClass];
                    $waitingInsert = null;
                }  
            }
            
            if (count($plainClasses) > 0)
                $data[] = ["namespace" => "none", "classes" => $plainClasses];
                
            return $data;
        }
        
        public static function compilePhp($phpFilePath, $namespace = null)
        {
            $namespace = self::validateNamespace($namespace, $phpFilePath);
            
            if ($namespace == null)
                return null;

            if (!file_exists($phpFilePath))
                return null;
                
            $phpFile = trim(@file_get_contents($phpFilePath));
            $indexOfTagOpen = strpos($phpFile, "<?php");
            
            if ($indexOfTagOpen === false)
                return false;
            
            $phpFile = trim(substr($phpFile, $indexOfTagOpen + strlen("<?php"), strlen($phpFile)));
            
            $indexOfTagClose = strrpos($phpFile, "?>");
            
            if ($indexOfTagClose !== false)
                $phpFile = trim(substr($phpFile, 0, $indexOfTagClose));
    
            $data = self::getNamespacesAndClasses($phpFile);
            
            if (count($data) == 1 && $data[0]["namespace"] == "CodeIgniter")
                return $phpFile;
                
            if (count($data) == 0 || (count($data) == 1 && $data[0]["namespace"] == "none"))
            { $phpFile = "namespace " . $namespace . " { " . $phpFile . " \r\n}"; }
            else
            {
                foreach ($data as $_data)
                {
                    $_namespace = $_data["namespace"];
                    $phpFile = str_replace($_namespace, $namespace . "\\". $_namespace, $phpFile);
                }
            }
            
            
            
            
            $required = "\KrupaBOX\Internal\Inject::RequireOnceInjected";
            //$phpFile = str_replace("require_once", $required, $phpFile);
            return $phpFile;
        }
    }   
}