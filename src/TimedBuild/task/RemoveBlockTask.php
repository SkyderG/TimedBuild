<?php

namespace TimedBuild\task;

use pocketmine\scheduler\Task;
use TimedBuild\Loader;

class RemoveBlockTask extends Task
{
    public int $time = 0;
    public function __construct(
        protected Loader $plugin
    )
    {
    }

    public function onRun(): void
    {
        $this->time++;

        if ($this->time == 5) {
            $this->time = 0;
            $this->plugin->getPlayerData()->removeBlocks();
        }
    }
}