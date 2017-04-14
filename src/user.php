<?php

interface activeRecordInterface {

    public function getId();

    public function saveToDb();

    public function delete();

    static public function loadAll();

    static public function loadById($id);
}

abstract class activeRecord implements activeRecordInterface {

    protected $id;
    protected static $db;

    public function __construct() {
        self::connect();
        $this->id = -1;
    }

    public static function connect() {
        if (!self::$db) {
            self::$db = new db();
            self::$db->changeDB('myshop');
        }
        return true;
    }

    public function saveToDb() {
        
    }

}

class user extends activeRecord {

    private $name;
    private $surname;
    private $email;
    private $address;
    private $password;

    public function __construct() {
        parent::__construct();
        $this->name = '';
        $this->surname = '';
        $this->email = '';
        $this->password = '';
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setSurname($surname) {
        $this->surrname = $surname;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setPassword($password) {
        $this->password = md5($password);
    }

    public function saveToDb() {
        if (self::$db->conn != null) {
            if ($this->id == -1) {
                $sql = "INSERT INTO Users (Name, Surname, Email, Address, {Password) values ('$this->name', '$this->surname', '$this->email', '$this->address', '$this->password')";

                $result = self::$db->conn->query($sql);

                if ($result == true) {
                    $this->id = self::$db->conn->lastInsertId();
                    return true;
                } else {
                    echo self::$db->conn->error;
                }
            } else {
                $sql = "UPDATE Users SET Name = '$this->name', Surname = '$this->surname', Email = '$this->email', Address = '$this->address', Password = '$this->password' where id = $this->id";

                $result = self::$db->conn->query($sql);

                if ($result == true) {
                    return true;
                }
            }
        } else {
            echo "Brak połączenia <br>";
        }
        return false;
    }

    static public function loadById($id) {
        self::connect();
        $sql = "SELECT * FROM Users WHERE id=$id";
        $result = self::$db->conn->query($sql);
        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedUser = new user();
            $loadedUser->id = $row['id'];
            $loadedUser->name = $row['name'];
            $loadedUser->surname = $row['surname'];
            $loadedUser->password = $row['password'];
            $loadedUser->address = $row['address'];
            $loadedUser->email = $row['email'];
            return $loadedUser;
        }
        return null;
    }

    static public function loadAll() {
        $sql = "SELECT * FROM Users";
        $returnTable = [];
        if ($result = self::$db->conn->query($sql)) {
            foreach ($result as $row) {
                $loadedUser = new user();
                $loadedUser->id = $row['id'];
                $loadedUser->name = $row['name'];
                $loadedUser->surname = $row['surname'];
                $loadedUser->password = $row['password'];
                $loadedUser->address = $row['address'];
                $loadedUser->email = $row['email'];
                $returnTable[] = $loadedUser;
            }
        }
        return $returnTable;
    }

    public function delete() {
        if ($this->id != -1) {
            if (self::$db->conn->query("DELETE FROM Users WHERE id=$this->id")) {
                $this->id = -1;
                return true;
            }
            return false;
        }
        return true;
    }

}
