<?php


namespace NZS\MS\CMD;

use NZS\MS\Main;
//use NZS\MS\CMD\Subcommand\helpcmd;
use NZS\MS\UI\kitUI;
use pocketmine\{Server, Player};
use pocketmine\command\{Command, CommandSender, ConsoleCommandSender};
use pocketmine\plugin\Plugin;

class kit extends Command
{
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct("kit");
        $this->setDescription("Kit for MS-Elite");
    }

    public function getPlugin(): Main
    {
        return $this->plugin;
    }

    public function execute(CommandSender $player, string $commandlb, array $args){
        if(!($player instanceof Player)){
            Server::getInstance()->getLogger()->warning("USE IN-GAME!");
            return;
        }
        new kitUI($player);
        /**if($args[1] == "help"){
            new Helpcmd($player);
           // return;
        }elseif($args[1] == "use"){
            new KitUI($player);
           // return;
        }*/
        return;
    }
}