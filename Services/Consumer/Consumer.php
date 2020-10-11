<?php
namespace Services\Consumer;

use Services\MessageService;

class Consumer extends MessageService
{
    //strings of words which will be erased from the messages
    private array $keyWords;

    public function setKeywords (array $array)
    {
        $this->keyWords = $array;
    }

    //We dequeue the messages while we can
    public function process()
    {
        while(!$this->queue->isEmpty()) {
            $msg = $this->queue->dequeue();
            $metaData = $this->dictionnary[$msg];
            $expires_at = $metaData['expires_at'];
            if (new \Datetime("now") < $expires_at) {
                echo "message original : {$msg->getBody()} \n";

                $metaData['cleaned_msg'] = $msg->getCleanedBody($this->keyWords);
                echo "message nettoyé : {$metaData['cleaned_msg']}\n";

                $this->dictionnary->offsetSet($msg, $metaData);
            }
            else // message is expired
            {
                echo "le message a expiré\n";
                $this->dictionnary->detach($msg);
            }
        }
    }
}