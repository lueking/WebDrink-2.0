<?php

namespace WebDrink\Utils;

class Database {

    private $db;

    public function __construct() {
        $this->connect();
    }


    private function getDatabaseConnection() {
        if(is_null($this->db)){
            $this->connect();
        }

        //TODO: if not connected, reconnect
        return $this->db;
    }

    private function connect(){
        //todo make sure we're not already connected
        $this->db = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);;
    }

    public function query($query_string){
        //todo

        return $this->getDatabaseConnection()->query($query_string);
    }

    public function __destruct() {
        $connection = $this->db;
        $connection->close();
        $this->db = null;
    }
}