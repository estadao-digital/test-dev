<?php

namespace KrupaBOX\Internal
{
    class Library
    {
        protected static $noPharFallbackPath = null;
        protected static $loadedLibraries    = null;
        protected static $__isInitialized    = false;


        protected static function __onInitialize()
        {
            if (self::$__isInitialized == true)
                return null;

            self::$loadedLibraries    = Arr();
            self::$noPharFallbackPath = (
                stringEx(__KRUPA_PATH_LIBRARY__)->subString(0, stringEx(__KRUPA_PATH_LIBRARY__)->length - 1) .
                ".NoPHAR/"
            );

            self::$__isInitialized = true;
        }

        public static function compile($library)
        {
            if (stringEx($library)->isEmpty())
                return false;

            if (\File::exists(__KRUPA_PATH_LIBRARY__ . $library . ".phar") == true) {
                $phar = new \Phar(__KRUPA_PATH_LIBRARY__ . $library . ".phar");
                if (\DirectoryEx::exists(__KRUPA_PATH_LIBRARY__ . $library . "/") == false)
                $phar->extractTo(__KRUPA_PATH_LIBRARY__ . $library);
            }

            $phar = new \Phar(__KRUPA_PATH_LIBRARY__ . $library . ".phar");
            $phar->buildFromDirectory(__KRUPA_PATH_LIBRARY__ . $library);

            return true;
        }

        public static function load($library)
        {
            self::__onInitialize();

            $libraryLower = stringEx($library)->toLower();
            if (stringEx($libraryLower)->isEmpty() || self::$loadedLibraries->contains($libraryLower))
                return null;

            $pharEnabled = (\Connection::isCommandLineRequest() == false);


            $basePath   = (__KRUPA_PATH_LIBRARY__ . ".loader/");
            $isImported = \Import::PHP($basePath . $libraryLower . ".php");
            $namespace  = ("\\KrupaBOX\\Internal\\Library\\" . $libraryLower);

            if ($isImported == true && \ClassEx::exists($namespace) && @method_exists($namespace, "onLoad"))
                $namespace::onLoad(Arr([pharEnabled => $pharEnabled]));
            else
            {
                Library::defaultLoader([
                    name         => $library,
                    pharEnabled  => $pharEnabled,
                    preNamespace => ($library . "\\"),
                    libraryFilePath => ($library . ".phar"),
                    libraryLoadingPath  => ($library . ".phar/"),
                ]);
            }

            self::$loadedLibraries->add($library);
        }

//        protected static function loadAuraRouter($pharEnabled)
//        {
//            spl_autoload_register(function ($class) {
//                if (!stringEx($class)->startsWith("Aura\\Router\\")) return false;
//
//                $class = stringEx($class)->subString(stringEx("Aura\\Router\\")->length);
//
//                dump("try here");
//                exit;
//
//                $filePath = (APPLICATION_FOLDER . ".cache/.phar/ByteUnits.phar/" . $class . ".php");
//                $filePath = stringEx($filePath)->replace("\\", "/");
//
//                return \Import::PHP($filePath);
//            });
//        }

        public static function defaultLoader($data)
        {
            $data = Arr($data);
            $data->cacheFilePath      = (\Garbage\Cache::getCachePath() . ".phar/" . $data->libraryFilePath);
            $data->cacheLoadingPath   = (\Garbage\Cache::getCachePath() . ".phar/" . $data->libraryLoadingPath);

            $data->libraryFilePath    = (__KRUPA_PATH_LIBRARY__ . $data->libraryFilePath);
            $data->libraryLoadingPath = (__KRUPA_PATH_LIBRARY__ . $data->libraryLoadingPath);

            if (!$data->containsKey(classDelegate))
                $data->classDelegate = null;

            if ($data->pharEnabled == true)
            {
                \PHP\Loader::autoLoader(
                    $data->preNamespace,
                    [preNamespace => $data->preNamespace, libraryLoadingPath => $data->libraryLoadingPath, classDelegate => $data->classDelegate],
                    function($class, $data) {

                        $class = stringEx($class)->subString(stringEx($data->preNamespace)->length);
                        $class = stringEx($class)->replace("_", "/");

                        if ($data->classDelegate != null && \FunctionEx::isFunction($data->classDelegate)) {
                            $classDelegate = $data->classDelegate;
                            $class = $classDelegate($class);
                        }

                        $filePath = ($data->libraryLoadingPath . $class . ".php");
                        $filePath = stringEx($filePath)->replace("\\", "/");

                        return \Import::PHAR($filePath);
                    });
                return null;
            }

            $cachePath = $data->cacheFilePath;

            if (!\File::exists($cachePath . ".installed"))
            {
                \DirectoryEx::createDirectory($cachePath);
                $phar = new \Phar($data->libraryFilePath, 0);
                $extracted = $phar->extractTo($cachePath, null, true);
                if ($extracted == true)
                    \File::setContents($cachePath . ".installed", "OK");

                if (!\File::exists($cachePath . ".installed"))
                {
                    \Header::getContentType("application/json");
                    \Header::sendHeader();
                    echo \Serialize\Json::encode([error => INTERNAL_SERVER_ERROR, message => "Missing " . $data->name . "  lib."]);
                    exit;
                }
            }

            \PHP\Loader::autoLoader(
                $data->preNamespace,
                [preNamespace => $data->preNamespace, cacheLoadingPath => $data->cacheLoadingPath, classDelegate => $data->classDelegate],
                function($class, $data) {

                    $class = stringEx($class)->subString(stringEx($data->preNamespace)->length);
                    $class = stringEx($class)->replace("_", "/");

                    if ($data->classDelegate != null && \FunctionEx::isFunction($data->classDelegate)) {
                        $classDelegate = $data->classDelegate;
                        $class = $classDelegate($class);
                    }

                    $filePath = ($data->cacheLoadingPath . $class . ".php");
                    $filePath = stringEx($filePath)->replace("\\", "/");

                    return \Import::PHP($filePath);
                });
        }
    }
}
