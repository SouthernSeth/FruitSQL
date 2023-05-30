<?php

class User {
    private $id;
    private $email;
    private $username;
    private $permissions;
}

class UserData {
    private $fruitsql;
    private $userTable;
    
    public function __construct($fruitsql, $userTable) {
        $this->fruitsql = $fruitsql;
        $this->userTable = $userTable;
    }
    
    public function UpdateLastLoginTimestamp($id) {
        $statement = 'UPDATE users SET LastLoginTimestamp=now() WHERE ID=?';
        $result = $this->fruitsql->PreparedStatement($statement, 'i', $id);
        return $result;
    }

    public function CreateUser($email, $username, $rawPassword, $permissionGroup) {
        $statement = 'INSERT INTO users (Email, Username, HashedPassword, PermissionGroup) VALUES (?,?,?,?)';
        $hashedPassword = $this->HashPassword($rawPassword);
        $permissionGroup = strtoupper($permissionGroup);
        $result = $this->fruitsql->PreparedStatement($statement, 'ssss', $email, $username, $hashedPassword, $permissionGroup);
        return $result;
    }

    public function CreateUserTable() {
        $statement = "CREATE TABLE IF NOT EXISTS $this->userTable (ID INT(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY, Email VARCHAR(255) NOT NULL, Username VARCHAR(255) NOT NULL, HashedPassword VARCHAR(255) NOT NULL, PermissionGroup VARCHAR(255) NOT NULL, AccountCreationTimestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, LastLoginTimestamp TIMESTAMP NULL)";
        $result = $this->fruitsql->Query($statement);
        return $result;
    }

    public function SetUserPassword($id, $rawPassword) {
        $auth = new Authentication($this->fruitsql, 12);
        $hashedPassword = $auth->HashPassword($rawPassword);
        $statement = "UPDATE $this->userTable SET HashedPassword=? WHERE ID=?";
        $result = $this->fruitsql->PreparedStatement($statement, 'si', $hashedPassword, $id);
        return $result;
    }
}

?>