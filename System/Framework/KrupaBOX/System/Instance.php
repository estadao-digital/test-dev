<?php

class Instance
{
    public static function getCaller($onlyName = true)
    {
       $trace = debug_backtrace();
       $class = $trace[1]['class'];

       for ($i = 1; $i < count( $trace ); $i++ )
           if (isset($trace[$i]))
                if ($class != $trace[$i]['class'])
                    return $trace[$i]['class'];
                    
       //return ($onlyName == true) ? $trace[$i]['class'] : $trace[$i];             
       return true;            
    }

    public static function getName($instance)
    {
        if ($instance == null || !Variable::get($instance)->isObject())
            return null;
            
        $name = get_class($instance);
        
        if ($name == stdClass)
            $name = null;
            
        if (stringEx($name)->isEmpty())
            return null;

        return stringEx($name)->toString();
    }
    
    public static function getNameForInstantiate($instance)
    {
        $name = self::getName($instance);
        
        if ($name == null)
            return null;

        return "\\" . $name;
    }
    
    public static function getClassName($instance)
    {
        $name = self::getName($instance);
        
        if ($name == null)
            return null;
            
        $split = stringEx($name)->split("\\");
        $split = \Arr($split); // TODO: remove
        
        return $split[$split->length - 1]; 
    }
    
    public static function getNamespace($instance)
    {
        $name = self::getName($instance);
        
        if ($name == null)
            return null;
 
        $split = stringEx($name)->split("\\");
        $split = \Arr($split); // TODO: remove
        
        $namespace = "";
        
        foreach ($split as $_split)
            if ($_split != $split[$split->length - 1])
                $namespace .= $_split . "\\";
         
        if (stringEx($namespace)->endsWith("\\"))
            $namespace = stringEx($namespace)->subString(0, stringEx($namespace)->length - 1);

        return $namespace;
    }
}