<?php

namespace TimedBuild;

use pocketmine\block\VanillaBlocks;
use pocketmine\world\Position;

class PlayerData
{
    public array $players = [];

    public function __construct(
        protected Loader $plugin
    )
    {
    }

    public function addBlock(string $xuid, Position $position)
    {
        $pos = $position->x . ":" . $position->y . ":" . $position->z . ":" . $position->getWorld()->getFolderName();
        $this->players[$xuid][] = $pos;
    }

    public function removeBlocks()
    {
        // execute setBlock per 5 seconds
        if (empty($this->players)) return;

        $i = 0;
        foreach ($this->players as $xuid => $position) {
            if ($i > 0) break;
            [$x, $y, $z, $worldName] = explode(":", $position);

            $world = $this->plugin->getServer()->getWorldManager()->getWorldByName($worldName);
            $block = $world->getBlockAt($x, $y, $z);

            if ($block->getIdInfo()->getBlockId() == 0) continue;
            $world->setBlockAt($x, $y, $z, VanillaBlocks::AIR());
            $i = 1;
        }
    }
}