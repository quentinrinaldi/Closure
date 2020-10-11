<?php
include 'MessageService.php';
include 'Message.php';
include 'Consumer.php';
include 'Producer.php';
include 'Container.php';

$container = new Container();

$consumer = $container->register(Consumer::class)->getService(Consumer::class);
$producer = $container->register(Producer::class)->getService(Producer::class);

$consumer->setKeywords( ['Trump', 'complot', 'moutons', 'CIA']);

$producer->addMessageToQueue(new Message("Trump a raison, c'est un complot de la CIA, nous sommes tous des moutons", "FR"));

$consumer->process();


