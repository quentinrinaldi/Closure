<?php
const ROOT_PATH = __DIR__;

spl_autoload_register(function ($className) {
        $realFilePath = ROOT_PATH . DIRECTORY_SEPARATOR . strtr($className, '\\', DIRECTORY_SEPARATOR) . '.php';
        if (!file_exists($realFilePath)) {
            return;
        }
        require_once($realFilePath);
    });

use Message\Message;
use Container\Container;
use Container\FactoryContainer;
use Services\Consumer\Consumer;
use Services\Producer\Producer;


// php index.php factory
if(isset($argv[1]) && $argv[1] === "factory")
{
    $container = new FactoryContainer();
    echo "[Utilisation du container factory]\n";
}
else //php index.php
{
    echo "[Utilisation du container standard]\n";
    $container = new Container();
}


$consumer = $container->register(Consumer::class)->getService(Consumer::class);
$producer = $container->register(Producer::class)->getService(Producer::class);

$consumer->setKeywords( ['Trump', 'chloroquine', 'complot', 'moutons', 'CIA', 'Raoult', ]);


$producer->addMessageToQueue(new Message("Trump a raison, c'est un complot de la CIA.", "FR"));
$producer->addMessageToQueue(new Message("Vive la chloroquine, Raoult, voilà un vrai scientifique.", 'FR'));
$consumer->process();


