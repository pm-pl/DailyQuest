<?php

declare(strict_types=1);

namespace phuongaz\dailyquest\event;

use pocketmine\event\CancellableTrait;
use pocketmine\event\player\PlayerEvent;
use pocketmine\player\Player;

class PlayerProgressEvent extends PlayerEvent {
    use CancellableTrait;

    private int $completed;

    public function __construct(Player $player, int $completed) {
        $this->player = $player;
        $this->completed = $completed;
    }

    public function getCompleted() :int {
        return $this->completed;
    }

}