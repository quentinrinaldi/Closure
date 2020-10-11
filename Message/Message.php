<?php

namespace Message;
class Message
{
    private $language;
    private $body;

    public function __construct(string $body, string $language)
    {
        $this->body = $body;
        $this->language = $language;
    }

    public function getCleanedBody (array $keywords) :string
    {
        //Regex which replace words by star (with extact count of stars)
        return preg_replace_callback('~(?:'.implode('|',$keywords).')~i', function($matches){
            return str_repeat('*', strlen($matches[0]));
        }, $this->body);

        //Old regex version :
        //return preg_replace('/\b('.implode('|',$keywords).')\b/','',$this->body);
    }

    public function getBody() :string
    {
        return $this->body;
    }
}