<?php

declare(strict_types=1);

namespace App\EventListener;

use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\GitLink;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class GitListener
{
    public function postPersist(
        GitLink $gitLink,
        LifecycleEventArgs $args
    ): void {
        // Логика после сохранения сущности GitLink
        //дать url
        $entity = $args->getObject();
        if (!$entity instanceof GitLink) {
            return;
        }
        $url = $entity->getUrl();
        $userName = $entity->getUser()->getUsername();
        $projectName = basename($url);
        $userDirectory = dirname(dirname(__DIR__)) . '/users_projects/' . $userName . '/' . $projectName;

        $filesystem = new Filesystem();

        if ($filesystem->exists($userDirectory)) {
            $filesystem->remove($userDirectory);
        }
        $filesystem->mkdir($userDirectory);


        // добавляем логику для определения директории, куда будет клонирован репозиторий
        // dd($userDirectory = $this->projectDir . '/users_projects/' . $userName . '/' . $userProject);
        // Формирование и запуск команды git clone
        //$process = new Process(['git', 'clone', $url, $userDirectory]);

        $process = new Process(['git', 'clone', $url, $userDirectory]);
        // creer la directory users_projects/dash/nom_du_projet/...code
        $process->run();

        // Générer l'analyse
        $process = new Process(['php', 'vendor/bin/psalm']);
        $process->run();
        //dd($process->getCommandLine());
        $output = $process->getOutput();


        // "php /vendor/bin/psalm"
        // $gitLink->setReport($userDirectory);
        // $manager->persist($gitLink);
        // $manager->flush();

        // Ждем завершения процесса
        //$process->wait();

        $projectPath = '/Users/JIJI/Desktop/FORMATION/Hackaton';
        // Определение команды для запуска терминала и выполнения команды в нем.
        $process = Process::fromShellCommandline("osascript -e 'tell application \"Terminal\" to do script \"cd " . $projectPath . "; php vendor/bin/psalm; exec bash\"'");
        $process->run();



        // Обработка ошибок выполнения команды
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        // Вывод результатов выполнения или дальнейшая логика
        echo $process->getOutput();
    }
}
