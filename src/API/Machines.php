<?php

namespace WebDrink\API;


use WebDrink\Utils\Database;

class Machines {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllDrinkMachines(){
        return [];
    }
    public function getMachineInfo($machineid){
        return [];
    }
    public function getSlots($machineid){
        return [];
    }
    public function updateSlot(){
        return true;
    }

}