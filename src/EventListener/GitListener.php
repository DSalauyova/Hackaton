<?php

declare(strict_types=1);

namespace App\EventListener;

use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\GitLink;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use App\Controller\AbstractController;

class GitListener
{
    // private $projectDir;

    // public function __construct(string $projectDir)
    // {
    //     $this->projectDir = $projectDir;
    // }

    public function postPersist(GitLink $gitLink, LifecycleEventArgs $args): void
    {
        // Логика после сохранения сущности GitLink
        //дать адрес
        $entity = $args->getObject();
        if (!$entity instanceof GitLink) {
            return;
        }
        $url = $entity->getUrl();
        $userDirectory = dirname(dirname(__DIR__)) . '/users_projects';

        // dd($userDirectory);
        $userName = $entity->getUser();
        $userProject = 'Nom de projet';
        // добавляем логику для определения директории, куда будет клонирован репозиторий
        // dd($userDirectory = $this->projectDir . '/users_projects/' . $userName . '/' . $userProject);

        // Формирование и запуск команды git clone
        $process = new Process(['git', 'clone', $url, $userDirectory]);
        $process->start();

        // Ждем завершения процесса
        $process->wait();

        // Обработка ошибок выполнения команды
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Вывод результатов выполнения или дальнейшая логика
        echo $process->getOutput();
    }
}
