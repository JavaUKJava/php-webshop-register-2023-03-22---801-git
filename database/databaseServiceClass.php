<?php

class DatabaseService
{
    private $servername = "localhost";
    private $dbUsername = "uk";                             // for the webshop in the standard version for develop
    // private $dbUsername = "webroot_uk";                     // for the webshop in the cloud version
    private $dbPassword = "123QWEasdyxc";
    private $dbName = "php_webshop_register_2023_03_22";    // for the webshop in the standard version for develop
    // private $dbName = "webroot_webshop";                    // for the webshop in the cloud version
    private $port = "3306";
    private $charset = "utf8mb4";
    private $dsn = null;

    public function __construct()
    {
        $this->dsn = "mysql:host=$this->servername;dbname=$this->dbName;charset=$this->charset;port=$this->port";

        try {
            $pdo = new PDO($this->dsn, $this->dbUsername, $this->dbPassword);
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- ";
            throw new PDOException($e->getMessage(), (int)$e->getCode());
            die();
        }
    }

    protected function getPDO() {
        return new PDO($this->dsn, $this->dbUsername, $this->dbPassword);
    }
}
