<?php

// Usage: require_once '/Includes/SqlLibrary/FruitSQL.php';
// Call FruitSQL class: $sql = new FruitSql();

class FruitSql {
    
    private $fruitsqlsettings;
    private $mysqli;

    public function __construct() {
        include ('../Settings/SqlSettings.php');

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

    public function CreateTables() {
        if (!$this->IsConnected()) {
            $this->Connect($this->fruitsqlsettings);
        }

        include '../Settings/SqlTables.php';
        $tables = GetTablesQuery();

        $this->mysqli->query($tables);
    }
}

?> 