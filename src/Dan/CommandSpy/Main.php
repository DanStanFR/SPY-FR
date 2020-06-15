<?php

namespace Dan\CommandSpy;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class Main extends PluginBase {
	public $snoopers = [];
	
	public function onEnable(): void {
		@mkdir($this->getDataFolder());
		$this->getLogger()->info("CommandSpy activé , par DanStanny.");
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
	  	"Console.Logger" => "true",
  		));
	}
	
	 public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {			
		if(strtolower($command->getName()) == "spy") {
		 	if($sender instanceof Player) {
				if($sender->hasPermission("commandspy.cmd")) {
					if(!isset($this->snoopers[$sender->getName()])) {
						$sender->sendMessage("§aVous êtes maintenant en mode espion.");
						$this->snoopers[$sender->getName()] = $sender;
						return true;
					} else {
						$sender->sendMessage("§cVous avez quitté le mode espion.");
						unset($this->snoopers[$sender->getName()]);
						return true;
						}
				} else {
       						$sender->sendMessage("§cVous ne pouvez pas exécuter cette commande!");
       						return true;
					}
				}
			}
		return true;
	 }
}
