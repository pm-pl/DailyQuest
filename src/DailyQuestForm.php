<?php

declare(strict_types=1);

namespace phuongaz\dailyquest;


use jojoe77777\FormAPI\CustomForm;
use phuongaz\dailyquest\util\Utils;
use pocketmine\player\Player;

class DailyQuestForm extends CustomForm {

    public function __construct(Player $player, ?callable $callable = null) {
        parent::__construct($callable);
        $this->setTitle("§l§6Ｍｉｓｓｉｏｎ");
        $this->addLabel("§f§lChỉ tiêu hôm nay là:");
        $target = Utils::parseTarget(DailyQuest::getInstance()->getYamlProvider()->getTarget());
        $value = DailyQuest::getInstance()->getYamlProvider()->getTargetValue();
        $reward = DailyQuest::getInstance()->getYamlProvider()->getReward();
        $this->addLabel("§f§l" . $target . " §ex" . $value . "§f bất kì");
        $this->addLabel("§f§lPhần thưởng:§e ". $reward . " §fxu");

        $session = DailyQuest::getInstance()->getSessionManager()->getSession($player->getName());
        $completed = $session->getCompleted();
        if($completed >= $value) {
            $this->addLabel("§a§lBạn đã hoàn thành chỉ tiêu hôm nay §e§l{$completed}§r§a/§e§l{$value}!");
        } else {
            $this->addLabel("§c§lBạn chưa hoàn thành chỉ tiêu hôm nay §e§l{$completed}§r§c/§e§l{$value}!");
        }
    }


}