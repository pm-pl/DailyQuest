<?php

declare(strict_types=1);

namespace phuongaz\dailyquest;

use JsonException;
use phuongaz\dailyquest\database\SQLProvider;
use phuongaz\dailyquest\database\YamlProvider;
use phuongaz\dailyquest\session\SessionManager;
use phuongaz\dailyquest\task\ResetQuestTask;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use poggit\libasynql\libasynql;

class DailyQuest extends PluginBase {
    use SingletonTrait;

    private SQLProvider $sqlProvider;
    private YamlProvider $yamlProvider;
    private SessionManager $sessionManager;

    public function onLoad(): void {
        self::setInstance($this);
    }

    public function onEnable(): void{
        $this->saveDefaultConfig();
        $this->saveResource("quest.yml");
        $dataConnector = libasynql::create($this, $this->getConfig()->get("database"), [
            "sqlite" => "sqlite.sql",
            "mysql" => "mysql.sql"
        ]);
        $questConfig = new Config($this->getDataFolder() . "quest.yml", Config::YAML);
        $this->sqlProvider = new SQLProvider($dataConnector);
        $this->sessionManager = new SessionManager();
        $this->yamlProvider = new YamlProvider($questConfig);
        $this->getServer()->getPluginManager()->registerEvents(new EventHandler(), $this);
        $this->getScheduler()->scheduleRepeatingTask(new ResetQuestTask(), 20 * 60 * 5);
        $this->getServer()->getCommandMap()->register("dailyquest", new DailyQuestCommand());
    }

    public function getSQLProvider(): SQLProvider {
        return $this->sqlProvider;
    }

    public function getYamlProvider(): YamlProvider {
        return $this->yamlProvider;
    }

    public function getSessionManager(): SessionManager {
        return $this->sessionManager;
    }
}