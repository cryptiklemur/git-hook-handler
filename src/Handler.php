<?php

/**
 * This file is part of git-hook-handler
 *
 * (c) SCTR Services 2015
 *
 * This source file is proprietary
 */

namespace Aequasi\HookHandler;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class Handler extends Application
{

    /**
     * @type array
     */
    private $categories;

    /**
     * @type string
     */
    private $hook;

    /**
     * @param array  $categories
     * @param string $hook
     */
    public function __construct(array $categories, $hook)
    {
        $this->categories = $categories;
        $this->hook = $hook;

        parent::__construct('Git Hook Handler');
    }


    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(
            [
                '',
                '<comment>--- <question>Git Hook Handler</question> ---</comment>',
                '',
                '',
                '<info>Running hooks.</info>'
            ]
        );


        $status = 1;
        if (!array_key_exists($this->hook, $this->categories)) {
            $this->categories[$this->hook] = [];
        }

        foreach ($this->categories[$this->hook] as $command) {
            $output->writeln("<comment> Running $this->hook hook </comment>");

            $process = new Process($command, __DIR__ . '../../');
            $output->write($command."......");
            if ($process->run() === 1) {

                $output->writeln(' Failed.');
                $output->writeln("<error>{$command} failed</error>");
                $output->writeln($process->getOutput());
                $output->writeln("<error>{$command} failed</error>");

                return 1;
            }
            $output->writeln(' Success.');
        }

        $output->writeln(
            [
                '',
                "<info>Finished running git hooks.</info>",
                '<comment>-------------------------</comment>',
                ''
            ]
        );
    }
}
