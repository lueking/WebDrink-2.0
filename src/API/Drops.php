<?php


namespace WebDrink\API;


use WebDrink\Utils\Database;
use GuzzleHttp\Client;

class Drops {
    private $db;
    private $client;

    public function __construct() {
        $this->db = new Database();
        $this->client = new Client([
           'base_uri' => "https://drinkapi.csh.rit.edu/v2/drops/"
        ]);
    }

    public function doDrop($ibutton, $machineid, $slotnum, $delay){
        $response = $this->client->post("drop/{$ibutton}/{$machineid}/{$slotnum}/{$delay}");
        return $response;
    }


}
