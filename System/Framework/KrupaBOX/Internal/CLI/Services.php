<?php

namespace KrupaBOX\Internal\CLI
{
    class Services
    {
        protected static $instance = null;

        protected $services = null;

        public static function run()
        {
            if (self::$instance == null)
                self::$instance = new Services();

            self::$instance->services = Arr();

            $servicePath = (SERVER_FOLDER . "Service");

            if (!\DirectoryEx::exists($servicePath))
                return null;
            self::updateServices();

            $dirFiles = \DirectoryEx::listDirectoryPaths($servicePath);
            if ($dirFiles == null) return null;

            foreach ($dirFiles as $serviceFilePath) {
                $return = self::checkService($serviceFilePath);
                if ($return == STOP)
                    return STOP;
            }

            return KEEP;
        }

        protected static function checkService($serviceFilePath)
        {
            $fileData = \File::getContents(SERVER_FOLDER . "Service/" . $serviceFilePath);
            $splitNamespace = stringEx($fileData)->split("namespace");

            foreach ($splitNamespace as $namespaceData)
            {
                if ($namespaceData == $splitNamespace[0])
                    continue;

                $indexOfPoint = stringEx($namespaceData)->indexOf(";");
                $indexOfKey = stringEx($namespaceData)->indexOf("{");

                $splitInsideNamespace = stringEx($namespaceData)->split(($indexOfPoint != null && $indexOfPoint < $indexOfKey) ? ";" : "{");
                $extractNamespace = stringEx($splitInsideNamespace[0])->removeSpaces();

                $splitClass = stringEx($fileData)->split("class");

                foreach ($splitClass as $classData)
                {
                    if ($classData == $splitClass[0])
                        continue;

                    $splitInsideClass = stringEx($classData)->split("{");
                    $splitInsideClassFix = stringEx($splitInsideClass[0])->split(" ");
                    $extractClass = stringEx($splitInsideClassFix[0])->removeSpaces();

                    if (!stringEx($extractNamespace)->isEmpty() && !stringEx($extractClass)->isEmpty())
                        $return = self::runService($serviceFilePath, $extractNamespace, $extractClass);
                        if ($return == STOP) return STOP;
                }
            }
        }

        protected static function runService($serviceFilePath, $namespace, $class)
        {
            // CHECK IF CAN RUN
            \KrupaBOX\Internal\Engine::includeInsensitive(SERVER_FOLDER . "Service/" . $serviceFilePath);
            $instanceName = "\\" . $namespace . "\\" . $class;

            $reflector = new \ReflectionClass($instanceName);
            if ($reflector->hasMethod("onAwake"))
            {
                $method = $reflector->getMethod("onAwake");

                $response = true;
                if ($method->isStatic() && $method->isPublic())
                    $response = $instanceName::onAwake();

                if ($response == false || $response == null) // If cant execute, continue running engine
                    return null;
            }

            // RUN SERVICE
            $findService = false;
            foreach (self::$instance->services as $service)
            {
                if ($service->containsKey(instanceName) && $service->instanceName == $instanceName)
                {
                    $findService = true;
                    $isRunning   = false;

                    if (($service->containsKey(running) && $service->running == false) == false && $service->containsKey(lastRun))
                    {
                        if(($service->lastRun->toTimeStamp()->get() > \DateTimeEx::now()->addSecond(-5)->toTimeStamp()->get()))
                            $isRunning = true;
                    }

                    if ($isRunning == false)
                    {
                        self::internalRunService($serviceFilePath, $namespace, $class);
                        if (\Connection::isCommandLineRequest()) return STOP;
                    }

                    break;
                }
            }

            if ($findService == false)
            {
                self::internalRunService($serviceFilePath, $namespace, $class);
                if (\Connection::isCommandLineRequest()) return STOP;
            }

            return KEEP;
        }

        protected static function updateServices()
        {
            $service = (\Cache::isCached("services") ? \Cache::get("services") : null);
            if ($service != null)
                self::$instance = $service;
            else self::$instance->services = Arr();
        }
        protected static function saveServices()
        {
            \Cache::set("services", self::$instance);
        }

        protected static function internalRunService($serviceFilePath, $namespace, $class)
        {
            if (\Connection::isCommandLineRequest())
            {
                //\KrupaBOX\Internal\Engine::includeInsensitive(SERVER_FOLDER . "Service/" . $serviceFilePath);
                $instanceName = "\\" . $namespace . "\\" . $class;

                // Service list
                $_service = null;
                foreach (self::$instance->services as $__service) {
                    if ($__service->containsKey(instanceName) && $__service->instanceName == $instanceName) {
                        $_service = $__service;
                        break;
                    }
                }

                if ($_service == null)
                {
                    $_service = Arr();
                    $_service->instanceName = $instanceName;
                    self::$instance->services->add($_service);
                }

                $_service->running = true;
                $_service->lastRun = \DateTimeEx::now();
                self::saveServices();

                // Service config
                $reflector = new \ReflectionClass($instanceName);
                if ($reflector->hasMethod("onInitialize"))
                {
                    $method = $reflector->getMethod("onInitialize");

                    if ($method->isStatic() && $method->isPublic())
                        $instanceName::onInitialize();
                }

                $hasUpdateMethod = false;
                if ($reflector->hasMethod("onUpdate"))
                {
                    $method = $reflector->getMethod("onUpdate");

                    if ($method->isStatic() && $method->isPublic())
                        $hasUpdateMethod = true;
                }

                // INSTANTIATE SERVICE
                $killService = false;

                $i = 0;
                while(true)
                {
                    if ($hasUpdateMethod == true)
                        $instanceName::onUpdate();

                    self::updateServices();
                    $findService = false;
                    foreach (self::$instance->services as $service)
                    {
                        if ($service->containsKey(instanceName) && $service->instanceName == $instanceName)
                        {
                            $findService = true;
                            $isRunning   = false;

                            if (($service->containsKey(running) && $service->running == false) == false)
                            {
                                $service->lastRun = \DateTimeEx::now();
                                self::saveServices();
                                $isRunning = true;
                            }
                            break;
                        }
                    }

                    if ($findService == false || $isRunning == false)
                    { $killService = true; break; }

                    self::saveServices();
                    sleep(1);
                }

                if ($killService == true)
                {
                    self::updateServices();
                    $_service = null;

                    foreach (self::$instance->services as $__service)
                        if ($service->containsKey(instanceName) && $service->instanceName == $instanceName)
                        {  $_service = $__service; break; }

                    if ($_service != null)
                        self::$instance->services->remove($_service);
                    self::saveServices();

                    if ($reflector->hasMethod("onFinish"))
                    {
                        $method = $reflector->getMethod("onFinish");

                        if ($method->isStatic() && $method->isPublic())
                            $instanceName::onFinish();
                    }
                }
            }
            else
            {
                $execution = \PHP\CommandLine::executeAsync(ROOT_FOLDER . "index.php");

//                if ($execution == false)
//                { echo \Serialize\Json::encode(Arr([error => INTERNAL_SERVER_ERROR, message => "Missing CLI path..."])); exit; }
//
//                echo "HERE";
//                exit;

//                echo \Serialize\Json::encode(Arr([error => INTERNAL_SERVER_ERROR, message => "Initializing services.."]));
//                exit;
            }
        }
    }
}
