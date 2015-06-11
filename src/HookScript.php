<?php

/**
 * This file is part of git-precommit-handler
 *
 * (c) SCTR Services 2015
 *
 * This source file is proprietary
 */

namespace Aequasi\HookHandler;

use Composer\Script\Event;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class HookScript
{
    public static function install(Event $event)
    {
        $gitDir     = realpath(__DIR__.'/../../../../.git');

        if (!file_exists($gitDir)) {
            $event->getIO()->writeError("This folder is not in a git repository.");
            return false;
        }

        $scriptFile = __DIR__.'/../scripts/hook';

        foreach (['pre-commit', 'post-merge'] as $file) {
            $gitFile    = $gitDir.'/hooks/'.$file;

            $scriptHook = file_get_contents($scriptFile);
            if (!file_exists($gitFile) || $scriptHook !== file_get_contents($gitFile)) {
                copy($scriptFile, $gitFile);
                chmod($gitFile, 0711);
            }
        }

        return true;
    }
}
