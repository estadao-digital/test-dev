<?php

namespace BaseClass
{
    trait Import
    {

    }
}

namespace
{
    class BaseClass
    {
        public static function getReflection()
        { return new ReflectionEx(static::class); }
    }
}

namespace KrupaBOX\Internal\Traits\ClassEx
{
    trait CallStatic
    {
        //protected static $onCallStaticMethod = [string, Arr];
        protected static function onCallStaticMethod($method, $arguments)
        { return null; }
        
        private static $__defaultGet = [];
        private static $__staticTypes = [];
        
        protected static function onConstructStatic() {}
        public static function __onConstructStatic()
        {
            
            self::$__staticTypes = \Arr(self::$__staticTypes);
            self::$__defaultGet = \Arr(self::$__defaultGet);
            
            $class = get_called_class();
            $reflector = new \ReflectionClass($class);
            
            $staticProperties = \Arr($reflector->getStaticProperties());
            $ERROR = "{{{..krupa.internal.invalid.get.set..}}}";

            foreach ($staticProperties as $property => $propertyValue)
            {
                $type    = self::__staticGetterSetter($property, "type");
                $default = self::__staticGetterSetter($property, "default");
                
                $typeIsDefault = false;
                

                if ($type == $ERROR || $type == ($ERROR . "{{invalid}}"))
                {
                    $possibleType = static::$$property;
                    if (\intEx::isValidationParameter($possibleType) || \Variable::getPreferredTypeByType($possibleType) != null)
                    { self::$__staticTypes[$property] = $possibleType; $typeIsDefault = true; }    
                }

                $defaultValue = ($typeIsDefault == true) ? null : static::$$property;
                
                if ($default != $ERROR)
                    $defaultValue = $default;
                    
                if ($type == ($ERROR . "{{invalid}}") && $default == ($ERROR . "{{invalid}}"))
                {
                    if ($reflector->hasMethod($property) && $reflector->getMethod($property)->isStatic())
                    {
                        $response = forward_static_call_array([$class, $property], []);
                        self::__staticGetterSetter($property, "set", $response, true);
                        self::$__defaultGet[] = $property;          
                    }
                    continue;
                }
                    
                self::__staticGetterSetter($property, "set", $defaultValue);
            }

            static::onConstructStatic();
        }
        
        public static function __callStatic($method, $arguments)
        {
            $onCallStatic = static::onCallStaticMethod($method, $arguments);
            
            if ($onCallStatic != null && $onCallStatic != false)
                return $onCallStatic;
            
            $ERROR = "{{{..krupa.internal.invalid.get.set..}}}";
            $arguments = \Arr($arguments);
            
            if ($arguments->isEmpty())
            {
                $response = self::__staticGetterSetter($method, get, null, self::$__defaultGet->contains($method));

                if ($response != $ERROR && $response != ($ERROR . "{{invalid}}"))
                    return $response;
            }
            else
            {
                $value = $arguments[0];
                
                if (stringEx($value)->toString() == $ERROR || stringEx($value)->toString() == ($ERROR . "{{invalid}}"))
                    return;
                    
                self::__staticGetterSetter($method, set, $value, self::$__defaultGet->contains($method));
            }
        }
        
        protected static function __staticGetterSetter($variable, $action, $value = null, $forceGetSet = false)
        {
            $ERROR    = "{{{..krupa.internal.invalid.get.set..}}}";
            $variable = stringEx($variable)->toString();
            
            $class = get_called_class();
            $reflector = new \ReflectionClass($class);
            $staticProperties = \Arr($reflector->getStaticProperties());
            
            if (!$staticProperties->containsKey($variable))
                return $ERROR;

            if ($reflector->hasMethod($variable) && $reflector->getMethod($variable)->isStatic())
            {
                $response = \Arr(forward_static_call_array([$class, $variable], []));
                
                if ($forceGetSet == false &&
                    !(($response->containsKey(get)        && \Variable::get($response[get])->isFunction()) ||
                    ($response->containsKey(set)        && \Variable::get($response[set])->isFunction()) ||
                    ($response->containsKey(type)       && \Variable::get($response[type])->isFunction()) ||
                    ($response->containsKey("default")  && \Variable::get($response["default"])->isFunction())))
                    return ($ERROR . "{{invalid}}");

                $type = null;
                
                if ($action == "default")
                {
                    if ($response->containsKey("default") && \Variable::get($response["default"])->isFunction())
                        return $response["default"]();

                    return $ERROR;
                }
                
                if ($action == type)
                {
                    if ($response->containsKey(type) && \Variable::get($response[type])->isFunction())
                        return $response[type]();
    
                    if (self::$__staticTypes->containsKey($variable))
                        return self::$__staticTypes[$variable];
                        
                    return $ERROR;
                }
                
                if ($action == get)
                {
                    if ($response->containsKey(get) && \Variable::get($response[get])->isFunction())
                        return $response[get](static::$$variable);
                    
                    return static::$$variable;
                }
                elseif ($action == set)
                {
                    $newValue = $value;
                    $getType = self::__staticGetterSetter($variable, type, $forceGetSet);

                    if ($getType == ($ERROR . "{{invalid}}") && self::$__staticTypes->containsKey(($variable)))
                        $getType =  self::$__staticTypes[$variable];
                    
                    if ($getType != $ERROR && $getType != ($ERROR . "{{invalid}}"))
                    {
                        if (\intEx::isValidationParameter($getType))
                        {
                            $newValue = \intEx::validate($newValue, $getType);
                        }
                        else
                        {
                            $type = \Variable::getPreferredTypeByType($getType);
                            
                            if ($type != null)
                            {
                                $newValueVar = \Variable::get($newValue);
                                $newValue = $newValueVar->convert($type);
                            }
                        }
                    }

                    if ($response->containsKey(set) && \Variable::get($response[set])->isFunction())
                        $newValue = $response[set]($value);

                    if ($getType != $ERROR && $getType != ($ERROR . "{{invalid}}"))
                    {
                        if (\intEx::isValidationParameter($getType))
                        {
                            $newValue = \intEx::validate($newValue, $getType);
                        }
                        else
                        {
                            $type = \Variable::getPreferredTypeByType($getType);
                            
                            if ($type != null)
                            {
                                $newValueVar = \Variable::get($newValue);
                                $newValue = $newValueVar->convert($type);
                            }
                        }
                    }

                    static::$$variable = $newValue;
                }
            }
            
            return $ERROR;
        }
    }
    
    trait ParametersStatic
    {
        protected static function parameters(&$param1  = null, &$param2 = null, &$param3 = null, &$param4 = null, &$param5 = null, &$param6 = null, &$param7 = null, &$param8 = null, &$param9 = null, &$param10 = null, &$param11 = null, &$param12 = null, &$param13 = null, &$param14 = null, &$param15 = null, &$param16 = null, &$param17 = null, &$param18 = null, &$param19 = null, &$param20 = null, &$param21 = null, &$param22 = null, &$param23 = null, &$param24 = null, &$param25 = null, &$param26 = null, &$param27 = null, &$param28 = null, &$param29 = null, &$param30 = null, &$param31 = null, &$param32 = null)
        {
            $trace = debug_backtrace();
            $class = $trace[1]['class'];
            $caller = null;        
    
            for ($i = 1; $i < count( $trace ); $i++ )
                if (isset($trace[$i]) && $class == $trace[$i]['class'])
                { $caller = \Arr($trace[$i]); break; }
    
            if ($caller != null && ($caller->type == "static" || $caller->type == "::"))
            {
                $reflector = new \ReflectionClass($caller->class);
    
                if (!$reflector->hasMethod($caller->function))
                    return;
          
                $method = $reflector->getMethod($caller->function);
                $params = $method->getParameters();
                
                $paramKey = 0;
                
                foreach ($params as $param)
                {
                    $paramKey++;
    
                    if ($param->isDefaultValueAvailable())
                    {
                        $default = $param->getDefaultValue();
                        $variable = \Variable::get($default);
                        
                        $type = $variable->getType();
                        $detailedParam = false;
                        
                        if ($type == string)
                        {
                            if (\Variable::isValidType($default))
                                $type = $default;
                            else $detailedParam = true;
                        }
    
                        if ($paramKey >= 33)
                            break;
                            
                        $paramVar = "param" . $paramKey; 
                        $value = $$paramVar;
    
                        if ($detailedParam == true)
                        {
                            if (\intEx::isValidationParameter($default))
                            {
                                $value = \intEx::validate($value, $default);
                            }
                            else $detailedParam = false;
                        }
    
                        $$paramVar = ($detailedParam == false)
                            ? \Variable::get($value)->convert($type)
                            : $value;
                    } 
                }
            }
        }
    }
}

namespace
{
    class ClassEx
    {
        use \KrupaBOX\Internal\Traits\ClassEx\CallStatic;
        use \KrupaBOX\Internal\Traits\ClassEx\ParametersStatic;
        
        public static function getCaller($onlyName = true)
        {
           $trace = debug_backtrace();
           $class = $trace[1]['class'];
    
           for ($i = 1; $i < count( $trace ); $i++ )
               if (isset($trace[$i]))
                    if ($class != $trace[$i]['class'])
                        return ($onlyName == true) ? $trace[$i]['class'] : $trace[$i];
        }
    
        public static function getName($instance)
        {
            if ($instance == null || !\Variable::get($instance)->isObject())
                return null;
                
            $name = get_class($instance);
            if ($name == stdClass)
                $name = null;
    
            return $name;
        }

        public static function exists($class)
        {
            $class = stringEx($class)->toString();
            return (@class_exists($class));
        }


        public static function load($class)
        {
            $class = stringEx($class)->toString();
            if (self::exists($class) == false)
                return false;
            return (@class_exists($class, false));
        }

        /*protected static $testhere = \string;
        protected static function testhere($value)
        { return [
            get => function($value)
            {
                return $value;
            },
            set => function($value)
            {
                return $value;
            },
            "default" => function()
            {
                return "abc";
            }
        ]; }*/
    }
}
