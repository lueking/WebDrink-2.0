<?php

namespace WebDrink\API;


use WebDrink\Utils\Database;

class Machines {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getMachineIDs(){
        $result = $this->db->query("select machine_id from machines");

        $machineIDs = $result->fetch_all(1);

        $ids = [];
        foreach($machineIDs as $row){
            $ids[] = $row['machine_id'];
        }

        return $ids;
    }

    public function getMachineInfo(){
        $result = $this->db->query("select * from machines");

        $info = $result->fetch_all(1);

        return $info;
    }

    public function getMachineSlots($machineid){
        $result = $this->db->query("select machine_id, slot_num, slots.item_id, item_name, item_price, available, status from slots join drink_items on slots.item_id = drink_items.item_id where machine_id = {$machineid};");

        $machineinfo = $result->fetch_all(1);
        return $machineinfo;
    }

    public function getAllMachinesWithSlots(){
        $machineinfo = $this->getMachineInfo();

        $info = [];
        foreach ($machineinfo as $machine) {
            $data = [
                'display_name' => $machine['display_name'],
                'machine_id' => $machine['machine_id'],
                'slots' => []
            ];

            $slots = $this->getMachineSlots($machine['machine_id']);
            foreach ($slots as $slot){
                $data['slots'][] = [
                    "item_id" => $slot['item_id'],
                    "slot" => $slot['slot_num'],
                    "price" => $slot['item_price'],
                    "name" => $slot['item_name'],
                    'enabled' =>  $slot['status'],
                    'available' => $slot['available']
                ];
            }
            $info[] = $data;
        }

        return $info;
    }

    public function getSlots($machineid){
        return [];
    }
    public function updateSlot($machine, $slot, $newItemID, $state){
        return false;
    }

}