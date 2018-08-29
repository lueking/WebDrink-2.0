<?php

namespace WebDrink\API;


use WebDrink\Utils\Database;

class Items {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Returns a big old list of the items
     * todo: make compatible with datatables
     * @return array of the items of the form:
     *      [
     *          $item_id => [
     *              "name"   => $item_name,
     *              "price"  => $price,
     *              "status" => $status
     *          ]
     *      ]
     */
    public function listAll(){
        $result = $this->db->query("select * from drink_items");

        $itemList = $result->fetch_all(MYSQLI_ASSOC);

        return $itemList;
    }

    public function add(){

    }

    public function update(){

    }

    public function delete(){

    }


}