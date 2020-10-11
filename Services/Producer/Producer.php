<?php
namespace Services\Producer;

use Services\MessageService;
use Message\Message;

class Producer extends MessageService
{

    public function addMessageToQueue( Message $msg )
    {
        $this->queue->enqueue($msg);
        $this->setMetadata($msg, 0);
    }

    public function setMetadata (Message $msg, int $priority) :void
    {
        $date = new \DateTime ("now");
        $date->modify('+30 seconds');
        $this->dictionnary->attach($msg, ["sent_at" => time(), "expires_at" => $date, "priority" => $priority]);
    }
}