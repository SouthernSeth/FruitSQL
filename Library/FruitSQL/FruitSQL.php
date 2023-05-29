<?php

// Usage: require_once '/Includes/SqlLibrary/FruitSQL.php';
// Call FruitSQL class: $sql = new FruitSql();

class FruitSqlSettings {

    // Change these values to your SQL server
    private $hostname = '127.0.0.1';
    private $username = 'root';
    private $password = '';
    private $database = 'test';

    public function Hostname() {
        return $this->hostname;
    }

    public function Username() {
        return $this->username;
    }

    public function RawPassword() {
        return $this->password;
    }

    public function DatabaseName() {
        return $this->database;
    }

}

class FruitSql {
    
    private $fruitsqlsettings;
    private $mysqli;

    public function __construct() {
        $this->fruitsqlsettings = new FruitSqlSettings();
        $this->Connect($this->fruitsqlsettings);
    }

    public function __destruct()
    {
    }

    private function Connect($fss) {
        $this->mysqli = new mysqli($fss->Hostname(), $fss->Username(), $fss->RawPassword(), $fss->DatabaseName());
    }
    
    public function Disconnect() {
        $this->mysqli->close();
    }

    public function IsConnected() {
        if ($this->mysqli->connect_errno) {
            return false;
        }

        return true;
    }

    public function IsAlive() {
        if ($this->mysqli->ping()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function PreparedStatement($statement, $parameterSyntax, ...$parameters) {
        if (!$this->IsConnected()) {
            $this->Connect($this->fruitsqlsettings);
        }

        $stmt = $this->mysqli->prepare($statement);
        $stmt->bind_param($parameterSyntax, ...$parameters);
        $stmt->execute();
        return $stmt;
    }
    
    public function Query($query) {
        if (!$this->IsConnected()) {
            $this->Connect($this->fruitsqlsettings);
        }
        
        $result = $this->mysqli->query($query);
        return $result;
    }

    public function GetMysqli() {
        if (!$this->IsConnected()) {
            $this->Connect($this->fruitsqlsettings);
        }

        return $this->mysqli;
    }
}

?> 