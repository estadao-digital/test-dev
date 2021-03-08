<?php

namespace TCP
{
    class Server
    {
        protected $host = null;
        protected $port = null;

        protected $serverLoop = null;
        protected $serverSocket = null;

        protected $onInitialize = null;
        protected $onConnection = null;
        protected $onMessage    = null;
        protected $onError      = null;
        protected $onClose      = null;

        protected $lastConnectionId = 0;
        protected $connections      = null;


        public function __construct($host = null, $port = null)
        {
            $host = stringEx($host)->toLower();
            if (stringEx($host)->isEmpty() || $host == "localhost")
                $host = "127.0.0.1";

            $port = intEx($port)->toInt();
            if ($port <= 0) $port = 80;

            $this->host = $host;
            $this->port = $port;

            $this->connections = Arr();
            $this->setup();
        }

        protected function setup()
        {
            \KrupaBOX\Internal\Library::load("ReactPHP");

            $this->serverLoop = \React\EventLoop\Factory::create();
            if ($this->serverLoop == null || !($this->serverLoop instanceof \React\EventLoop\StreamSelectLoop))
                return null;

            $this->serverSocket = new \React\Socket\Server($this->host . ":" . $this->port, $this->serverLoop);
            $this->hookEvents();
        }

        public function isRunning()
        { return ($this->serverSocket != null && $this->serverSocket->isRunning() == true); }

        public function run()  { return $this->execute(); }

        public function execute()
        {
            if ($this->isRunning() == false || $this->serverLoop == null)
                return false;

            $this->serverLoop->run();
            return true;
        }

        public function onInitialize($deleage)  { if (\FunctionEx::isFunction($deleage))  $this->onInitialize = $deleage; }
        public function onConnection($delegate) { if (\FunctionEx::isFunction($delegate)) $this->onConnection = $delegate; }
        public function onMessage($delegate)    { if (\FunctionEx::isFunction($delegate)) $this->onMessage    = $delegate; }
        public function onError($delegate)      { if (\FunctionEx::isFunction($delegate)) $this->onError      = $delegate; }
        public function onClose($delegate)      { if (\FunctionEx::isFunction($delegate)) $this->onClose      = $delegate; }

        protected function hookEvents()
        {
            $connections      = &$this->connections;
            $lastConnectionId = &$this->lastConnectionId;
            $onConnection     = &$this->onConnection;
            $onMessage        = &$this->onMessage;
            $onClose          = &$this->onClose;

            $serverInfo = ($this->host . ":" . $this->port);

            $this->serverSocket->on('connection', function ($socketConnection)
            use ($serverInfo, &$connections, &$lastConnectionId, &$onConnection, &$onMessage, &$onClose)
            {
                $lastConnectionId++;
                $connection = new Server\Connection($this, $socketConnection, $lastConnectionId);
                $connections->add($connection);

                $connectIdPad = intEx($connection->connectionId)->toPad(\intEx::PAD_LEFT, 10);
                if (\Connection::isCommandLineRequest())
                    echo ("[tcp://" . $serverInfo . "] [#" . $connectIdPad . "] <= [Connection] " . $connection->remoteAddress . "\n");

                $socketConnection->on('data', function ($data) use ($serverInfo, $connectIdPad, $connection, &$onMessage)
                {
                    $data = stringEx($data)->trim("\r\n\t");

                    if (\Connection::isCommandLineRequest())
                        echo ("[tcp://" . $serverInfo . "] [#" . $connectIdPad . "] <= [Message] " . $data . "\n");

                    if ($onMessage == null) $onMessage = (function() {});
                    if (\FunctionEx::isFunction($onMessage))
                        $onMessage($connection, $data);
                });

                $socketConnection->on('close', function () use ($serverInfo, $connectIdPad, $connection, &$onMessage, &$onClose)
                {
                    if (\Connection::isCommandLineRequest())
                        echo ("[tcp://" . $serverInfo . "] [#" . $connectIdPad . "] <= [Close]\n");

                    if ($onClose == null) $onClose = (function() {});
                    if (\FunctionEx::isFunction($onClose))
                        $onClose($connection);
                });

                if ($onConnection == null) $onConnection = (function() {});
                if (\FunctionEx::isFunction($onConnection))
                    $onConnection($connection);
            });
        }

        public function sendMessageAll($message) {
            foreach ($this->connections as $connection)
                $this->sendMessageByConnectionId($connection->connectionId, $message);
        }

        public function sendMessageByConnectionId($connectionId, $message)
        {
            $connectionId = intEx($connectionId)->toInt();

            foreach ($this->connections as $connection)
                if ($connection->connectionId == $connectionId)
                {
                    $message = stringEx($message)->toString();
                    $connection->tunnel->write($message);

                    $serverInfo = ($this->host . ":" . $this->port);
                    $connectIdPad = intEx($connection->connectionId)->toPad(\intEx::PAD_LEFT, 10);

                    if (\Connection::isCommandLineRequest())
                        echo ("[tcp://" . $serverInfo . "] [#" . $connectIdPad . "] => [Message] " . $message . "\n");
                    break;
                }
        }

        public function closeAll() {
            foreach ($this->connections as $connection)
                $this->closeByConnectionId($connection->connectionId);
        }

        public function closeByConnectionId($connectionId)
        {
            $connectionId = intEx($connectionId)->toInt();
            $find = false;

            foreach ($this->connections as $connection)
                if ($connection->connectionId == $connectionId)
                {
                    $find = true;
                    $connection->tunnel->close();

                    $serverInfo = ($this->host . ":" . $this->port);
                    $connectIdPad = intEx($connection->connectionId)->toPad(\intEx::PAD_LEFT, 10);

                    if (\Connection::isCommandLineRequest())
                        echo ("[tcp://" . $serverInfo . "] [#" . $connectIdPad . "] => [Connection] close\n");
                    break;
                }

            if ($find == false)
                return null;

            $newConnections = Arr();
            foreach ($this->connections as $connection)
                if ($connection->connectionId != $connectionId)
                    $newConnections->add($connection);

            $this->connections = $newConnections;
        }

        public function shutdown()
        {
            if ($this->isRunning() == false)
                return null;

            $this->closeAll();
            
            $serverInfo = ($this->host . ":" . $this->port);
            if (\Connection::isCommandLineRequest())
                echo ("[tcp://" . $serverInfo . "] [***********] => [Connection] SHUTDOWN\n");

            $this->serverSocket->close();
            $this->serverSocket = null;

            if ($this->serverLoop == null)
                return null;

            $this->serverLoop->stop();
            $this->serverLoop = null;
            return null;
        }
    }
}