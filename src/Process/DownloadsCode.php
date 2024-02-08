<?php

require_once '../../vendor/autoload.php';

//use App\EventListener\UserFormSubscriber;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;



//$process->addEventSubscriber(new UserFormSubscriber());
$process = new Process(['ls', '-lsa']);

$process->start();

// ... do other things

$process->wait();

// ... do things after the process has finished

// executes after the command finishes
if (!$process->isSuccessful()) {
    throw new ProcessFailedException($process);
}

echo $process->getOutput();
