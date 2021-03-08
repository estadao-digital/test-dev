<?php

namespace WebSocket\Server
{
    class Connection
    {
        protected $tunnel       = null;
        protected $connectionId = null;

        public function __construct(\WebSocket\Server $webServer, $tunnel, $connectionId)
        {
            $this->server       = $webServer;
            $this->tunnel       = $tunnel;
            $this->connectionId = intEx($connectionId)->toInt();
        }

        public function sendMessage($message)
        { $this->server->sendMessageByConnectionId($this->connectionId, $message); }

        public function close()
        { $this->server->closeByConnectionId($this->connectionId); }

        public function getRemoteAddress()
        { return null; /*$this->tunnel->getRemoteAddress();*/ }

        public function __get($key)
        {
            if ($key == connectionId)
                return $this->connectionId;
            elseif ($key == tunnel)
                return $this->tunnel;
            elseif ($key == remoteAddress)
                return $this->getRemoteAddress();
            return null;
        }
    }
}