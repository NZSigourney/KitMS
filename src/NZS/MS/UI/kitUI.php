<?php


namespace NZS\MS\UI;

//use NZS\MS\ITEM\EliteKit;
use NZS\MS\Main;
use pocketmine\{Server, Player};
use jojoe7777\FormAPI;

class kitUI
{
    public function __construct(Player $player)
    {
        $this->openForm($player);
    }

    public function getPlugin(): ?Main
    {
        $main = Server::getInstance()->getPluginManager()->getPlugin("KitMS");
        if($main instanceof Main){
            return $main;
        }
        return null;
    }

    public function openForm($player){
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createSimpleForm(Function (Player $player, $d){
            $r = $d;
            if ($r == null) {
                return $r;
            }
            switch($r){
                case 0:
                    $player->sendMessage(" ");
                    break;
                case 1:
                    $this->useKit($player);
                    break;
            }
        });

        $f->setTitle($this->getPlugin()->name);
        $f->setContent("Text here!");
        $f->addButton("EXIT", 0);
        $f->addButton("Buy Kit here!", 1);
        $f->sendToPlayer($player);
    }

    public function useKit($player){
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createSimpleForm(Function (Player $player, $d) {
            $r = $d;
            if ($r == null) {
                return $this->openForm($player);
            }
            switch ($r) {
                case 0:
                    $this->EliteKit($player);
                    break;
                case 1:
                    return $this->openForm($player);
            }
        });

        $f->setTitle($this->getPlugin()->name);
        $f->setContent("Text here!");
        $f->addButton("§cElite §aKIT", 0);
        $f->addButton("BACK", 1);
        $f->sendToPlayer($player);
    }

    public function EliteKit($player)
    {
        $a = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $a->createModalForm(Function (Player $player, $d){
            $r = $d;
            if ($r == null) {
                $this->openForm($player);
            }
            switch($r){
                case 1:
                    $money = $this->getPlugin()->eco->myMoney($player);
                    $cost = 50000;
                    if ($money >= $cost) {
                        $this->getPlugin()->eco->reduceMoney($player->getName(), $cost);
                        $player->sendMessage($this->getPlugin()->name . "§l§a Buyed Success, Item: Elite Kit, Price: §b". $cost);
                        $this->itemCE($player);
                    }else {
                        $player->sendMessage($this->getPlugin()->name . "§l§cDo not enough Money!");
                    }
                    break;
                case 2:
                    $this->openForm($player);
                    break;
            }
        });

        $f->setTitle($this->getPlugin()->name);
        $f->setContent("§c• §aElite Kit §f| §aWeapond, Tools\n§aPrice:§b 50000 §aXu\n\n§cInclude:\n§c+§a Elite Diamond Sword (Vampire, Lifesteal, Disarmor)\n§c+§a Elite Pickaxe Advanced (AutoRepair II, Jackpot");
        $f->setButton1("§l§aAccecpt");
        $f->setButton2("§l§cDeny");
        $f->sendToPlayer($player);
    }

    public function itemCE($player)
    {
        $sword = Item::get(276,0,1);
        $pickaxe = Item::get(278,0,1);
        $sword->setCustomName("§l§f-== §bElite §aSword Advanced §f==-");
        $sword->setLore(array("§l§c• §aEnchanted:\n§c+ §bVampire I\n§c+§b Lifesteal II\n§c+§b Flame II"));
        $ce = Server::getInstance()->getPluginManager()->getPlugin("PiggyCustomEnchants");
        $ce->addEnchantment($sword, ["VAMPIRE, LIFESTEAL, FLAME"], [1, 2, 2], true);
        $ce->addEnchantment($pickaxe, ["AUTOREPAIR, JACKPOT"], [2, 1], true);
        $pickaxe->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(18), 3));
        $pickaxe->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(16), 2));
        $player->getInventory()->addItem($sword);
        $player->getInventory()->addItem($pickaxe);
        $this->getPlugin()->user->set($player->getName(), ["ID" => mt_rand(1, mt_getrandmax()),"Item" => $sword->getCustomName(), "Type" => "Elite Kit"])
        Server::getInstance()->getLogger()->info("§a[KIT-NOTICE] §bGave Pickaxe and Sword (Diamond) - In Elite Kit");
    }
}