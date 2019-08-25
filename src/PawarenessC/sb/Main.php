<?php

namespace PawarenessC\sb;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

use pocketmine\math\Vector3;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;

use metowa1227\moneysystem\api\core\API;
class Main extends pluginBase implements Listener{
	
	public function onEnable(){
		$this->getLogger()->info("=========================");
 		$this->getLogger()->info("SiegeBattleを読み込みました");
 		$this->getLogger()->info("制作者: PawarenessC");
 		$this->getLogger()->info("バージョン:{$this->getDescription()->getVersion()}");
 		$this->getLogger()->info("=========================");
		$this->LoadDatas();
		$this->InitConfigs();
	}
	
	public function onDisable(){
		$this->getLogger()->info("=========================");
 		$this->getLogger()->info("SiegeBattleを停止しました。");
 		$this->getLogger()->info("製作者: PawarenessC");
 		$this->getLogger()->info("バージョン:{$this->getDescription()->getVersion()}");
 		$this->getLogger()->info("=========================");
		$this->LoadDatas();
	}
	
	public function LoadDatas(){
		$this->status = false;
		$this->atk = "";
		$this->red = [];
		$this->redjoin = 0;
		$this->blue = [];
		$this->bluejoin = 0;
		$this->players = [];
		$this->data = [];
		$this->spawns = [];
	}
	
	public function InitConfigs(){
		$this->xyz = new Config($this->getDataFolder() . "xyz.yml", Config::YAML, array(
			"pos1"=> array(
				"x"=>0,
				"y"=>0,
				"z"=>0
			),
			"pos2"=> array(
				"x"=>0,
				"y"=>0,
				"z"=>0
			),
			"WORLD"=>"world",
			));
		
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
			"チーム選択を有効化"=>false,
			"時間制限制"=>false,
			"防御のリスポーン"=>false,
			))->getAll();
	}
	
	public function onJoin(PlayerJoinEvent $event){
		$name = $event->getPlayer()->getName();
		$this->data[$name] = 0;
	}
	
	public function onQuit(PlayerQuitEvent $event){
		$player = $event->getPlayer();
		$name = $player->getName();
		if($this->status){
			if($this->data[$name] == 1){ //RED
				unset($this->players[array_search($player, $this->players]);
				unset($this->players[array_search($player, $this->red]);
				$this->redjoin--;
			}
			if($this->data[$name] == 2){ //BLUE
				unset($this->players[array_search($player, $this->players]);
				unset($this->blue[array_search($player, $this->blue]);
				$this->bluejoin--;
			}
		}
	}
													
	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		$name = $sender->getName();
		switch($label){
			case "siege":
				if(!isset($args[0])){
					$this->MainUI($sender);
					return true;
				}else{
					switch($args[0]){
						case "help":
							if($sender->isOp()){
								$sender->sendMessage("/siege < help|join|quit|pos1|pos2|start>");
								return true;
							}else{
								$sender->sendMessage("/siege < help|join|quit>");
								return true;
							}
						break;
							
						case "join":
							$this->Join($sender);
						return true;
						break;
						
						case "quit":
							$this->Quit($sender);
						return true;
						break;
						
						case "pos1":
						if($sender->isOp()){
							$this->setPos($sender, 1);}
						return true;
						break;
							
						case "pos2":
							if($sender->isOp()){
							$this->setPos($sender, 2);}
						return true;
						break;
						
						case "start":
							if($sender->isOp()){
								if(!isset($args[0])){
									$sender->sendMessage("/siege start");
								}
							}
						break
	
		
	
	
				
			
	
	
