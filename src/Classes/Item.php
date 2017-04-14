<?php

require_once ('src/db.php');


class Item {
    public $itemId;
    public $name;
    public $description;
    public $price;
    public $onStock;
    
    public function getItemId(){
        return $this->itemId;
    }
    public function getName(){
        return $this->name;
    }    
    public function getDesctiprtion(){
        return $this->description;
    }    
    public function getPrice(){
        return $this->price;
    }    
    public function getOnStock(){
        return $this->getOnStock;
    }    
    public function setItemId($itemId){
        $this->itemId = $itemId;
    }
    public function setName($name){
        $this->name = $name;
    }    
    public function setDescription ($description){
        $this->description = $description; 
    }
    public function setPrice($price){
        $this->price = $price; 
    }
    public function setOnStock($onStock){
        $this->price = $onStock; 
    }
    
    public function __construct(){
        $this->id = '';
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->onStock='';
    }
    
    public function save(){
        if (self::$db->conn != null) {
            if ($this->id == -1) {
                $sql = "INSERT INTO Orders (name, description, price, quantity) values (:name, :description, :price, :quantity)";
                $stmt= self::$db->conn->prepare($sql);    
                $result = $stmt->execute ([
                   'name'=>$this->name,
                    'descrtiption'=>$this->descrption,
                    'price'=> $this->price,
                    'quantity'=>$quantity->quantity
                        ]);
                }
        }
    }
    static public function loadTweetById($id){
        self::connect();
        $sql = "SELECT * FROM tweets WHERE id=:id";
        $stmt=self::$db->conn->prepare($sql);
        $result = $stmt->execute(['id' => $id]);
        if ($result && $stmt->rowCount () >= 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedTweet = new tweet();
            $loadedTweet->id = $row['id'];
            $loadedTweet->userId = $row['userId'];
            $loadedTweet->text = $row['text'];
            $loadedTweet->creationData = $row['creationDate'];
            return $loadedTweet;
        }
        return null;}

    static public function loadAllItemsByName(){
        self::connect();
        //wyświetlanie po dacie wpisu - zapytanie sql
        $sql = "SELECT * FROM Items ORDER BY Name ASC";
        //tu jest Twój result który jest zapytaniem sql query
        $resul=self::$db->conn->querry($sql);
        $returnTable = [];
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row){
                $loadedItem = new Item();
                $loadedUser->id = $row['id'];
                $loadedUser->userId = $row['userId'];
                $loadedUser->text = $row['text'];
                $loadedUser->creationDate = $row['creationDate'];
                $returnTable[] = $loadedUser;
            }
        }