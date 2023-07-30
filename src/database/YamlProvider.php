<?php

declare(strict_types=1);

namespace phuongaz\dailyquest\database;

use JsonException;
use pocketmine\utils\Config;

class YamlProvider {

    private Config $config;

    public function __construct(Config $config) {
        $this->config = $config;
    }

    public function getConfig() :Config {
        return $this->config;
    }

    public function getTarget() :string {
        return $this->config->get("target");
    }

    public function getTargetValue() :int {
        return $this->config->get("target-value");
    }

    public function getReward() :int {
        return $this->config->get("reward");
    }

    public function getDate() :string {
        return $this->config->get("date");
    }

    /**
     * @throws JsonException
     */
    public function setTarget(string $target) :void {
        $this->config->set("target", $target);
        $this->save();
    }

    /**
     * @throws JsonException
     */
    public function setTargetValue(int $targetValue) :void {
        $this->config->set("target-value", $targetValue);
        $this->save();
    }

    /**
     * @throws JsonException
     */
    public function setReward(int $reward) :void {
        $this->config->set("reward", $reward);
        $this->save();
    }

    /**
     * @throws JsonException
     */
    public function setDate(string $date) :void {
        $this->config->set("date", $date);
        $this->save();
    }

    /**
     * @throws JsonException
     */
    public function save() :void {
        $this->config->save();
    }

}