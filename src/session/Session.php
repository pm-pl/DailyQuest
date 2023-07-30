<?php

declare(strict_types=1);

namespace phuongaz\dailyquest\session;

use phuongaz\dailyquest\DailyQuest;
use phuongaz\dailyquest\event\PlayerProgressEvent;

class Session {

    private string $name;
    private int $completed;

    public function __construct(string $name, int $completed) {
        $this->name = $name;
        $this->completed = $completed;
    }

    public function getName() :string {
        return $this->name;
    }

    public function getCompleted() :int {
        return $this->completed;
    }

    public function setCompleted(int $completed) :void {
        $this->completed = $completed;
    }

    public function addCompleted(int $count = 1) :void {
        if(($player = DailyQuest::getInstance()->getServer()->getPlayerExact($this->name)) !== null) {
            $ev = new PlayerProgressEvent($player, $this->completed + $count);
            $ev->call();
            if($ev->isCancelled()) {
                return;
            }
        }
        $this->completed += $count;
    }

}