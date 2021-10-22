<?php


/** KitPE
 * Only Minsuone
 */

namespace NZS\MS;

use pocketmine\event\EventListener;
use NZS\MS\CMD\kit;
//use NZS\MS\UI\kitUI;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\{Server, Player};
use pocketmine\utils\Config;
use pocketmine\event\player\{PlayerJoinEvent, PlayerQuitEvent};

class Main extends PluginBase implements Listener
{
    public $name = "§l§f[§aKIT§cPRO§f - §bMinesuon§f]";
    //public kitUI $ui;

    public function onEnable(): void{
        $this->getServer()->getCommandMap()->register("kit", new kit($this));
        //$this->getServer()->getPluginManager()->registerEvents(new EventListener($this));
        $this->getLogger()->info("Running KITPE Release 1.0, Only for Minesuon");

        //$this->kitUI = new KitUI;

        $this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        $this->ce = $this->getServer()->getPluginManager()->getPlugin("PiggyCustomEnchants");

        @mkdir($this->getDataFolder(), 0744, true);
        $this->user = new Config($this->getDataFolder() . "User.yml", Config::YAML);

        /**$this->data = yaml_parse(file_get_contents($this->getDataFolder() . "User.yml"));
        $this->saveResource("User.yml");*/
    }

    /**public function getKitUI($player): kitUI
    {
        return $this->kitUI;
    }*/

    /**public function onJoin(PlayerJoinEvent $ev){
        file_put_contents($this->getDataFolder() . "User.yml", $this->data);

    }

    public function onQuit(PlayerQuitEvent $ev){
        file_put_contents($this->getDataFolder() . "User.yml", $this->data);
        sleep(5);
    }*/
}
