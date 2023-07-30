<?php

declare(strict_types=1);

namespace phuongaz\dailyquest\database;

use pocketmine\player\Player;
use pocketmine\promise\Promise;
use pocketmine\promise\PromiseResolver;
use poggit\libasynql\DataConnector;

class SQLProvider {

    private const CREATE = "table.init";
    private const SELECT = "table.select";
    private const INSERT = "table.insert";
    private const UPDATE = "table.update";
    private const DROP = "table.drop";

    private DataConnector $dataConnector;

    public function __construct(DataConnector $dataConnector) {
        $this->dataConnector = $dataConnector;
        $this->initTable();
    }

    public function initTable() :void {
        $this->dataConnector->executeGeneric(self::CREATE);
    }

    public function getPlayerData(Player $player) :Promise {
        $promise = new PromiseResolver();
        $this->dataConnector->executeSelect(self::SELECT, ["name" => $player->getName()], function (array $rows) use ($promise, $player) {
            if(empty($rows)) {
                $this->insertPlayerData($player);
            }
            $promise->resolve($rows[0]["completed"] ?? 0);
        });
        return $promise->getPromise();
    }

    public function insertPlayerData(Player $player, int $completed = 0) :void {
        $this->dataConnector->executeInsert(self::INSERT, ["name" => $player->getName(), "completed" => $completed]);
    }

    public function updatePlayerData(Player $player, int $completed) :void {

        $this->dataConnector->executeChange(self::UPDATE, ["name" => $player->getName(), "completed" => $completed]);
    }

    public function dropTable() :void {
        $this->dataConnector->executeGeneric(self::DROP);
    }

}