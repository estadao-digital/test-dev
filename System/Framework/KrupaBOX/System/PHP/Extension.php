<?php

namespace PHP
{
    class Extension
    {
        protected static $extensions = null;

        public static function getAll()
        {
            if (self::$extensions != null)
                return self::$extensions;

            $extensions = get_loaded_extensions();
            if ($extensions == null) $extensions = Arr();

            self::$extensions = $extensions;
            return self::$extensions;
        }

        public static function isLoaded($extensionName)
        {
            $extensionName = stringEx($extensionName)->toLower();
            if (stringEx($extensionName)->isEmpty()) return false;

            $extensions = self::getAll();

            foreach ($extensions as $extension)
                if (stringEx($extension)->toLower() == $extensionName)
                    return true;

            if (stringEx($extensionName)->startsWith("php5_")) {
                $extensionName = stringEx($extensionName)->subString(5, stringEx($extensionName)->length);
                foreach ($extensions as $extension)
                    if (stringEx($extension)->toLower() == $extensionName)
                        return true;
            }

            if (stringEx($extensionName)->startsWith("php_")) {
                $extensionName = stringEx($extensionName)->subString(4, stringEx($extensionName)->length);
                foreach ($extensions as $extension)
                    if (stringEx($extension)->toLower() == $extensionName)
                        return true;
            }

            return false;
        }

        public static function install($extensionName)
        {
            if (self::isLoaded($extensionName))
                return true;

            if (\PHP::getMajorVersion() < 5 || !(\System::isLinux() || \System::isMacOSX()))
                return false;

            $prefix = ((\PHP::getMajorVersion() == 5) ?  "php5-" : "php-");

            if (stringEx($extensionName)->startsWith("php5-") || stringEx($extensionName)->startsWith("php5_"))
                $extensionName = stringEx($extensionName)->subString(5, stringEx($extensionName)->length);
            elseif (stringEx($extensionName)->startsWith("php-") || stringEx($extensionName)->startsWith("php_"))
                $extensionName = stringEx($extensionName)->subString(4, stringEx($extensionName)->length);

            if (stringEx($extensionName)->isEmpty() || \System\Shell::canExecute() == false) return false;

            $extensionFull = ($prefix . $extensionName);

            $return = stringEx(\System\Shell::execute("sudo apt-get install " . $extensionFull . "  --yes"))->toLower();
            if ($return == "") return false;

            $installed = (stringEx($return)->contains($extensionFull . " is already") || stringEx($return)->contains("will be installed"));
            if ($installed == true)
                \System\Shell::execute("sudo " . ((\PHP::getMajorVersion() == 5) ? "php5enmod" : "phpenmod") . " " . $extensionName);

            return $installed;
        }


    }
}