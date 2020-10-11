<?php
namespace Services;

abstract class MessageService
{
    protected \splQueue $queue;
    protected \splObjectStorage $dictionnary;

    public function __construct(\splQueue $queue, \splObjectStorage $dictionnary)
    {
        $this->queue = $queue;
        $this->dictionnary = $dictionnary;
    }
}

