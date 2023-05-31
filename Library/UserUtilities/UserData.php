<?php

class User {
    private $id;
    private $email;
    private $username;
    private $permissiongroup;

    public function __construct($id, $email, $username, $permissiongroup) {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->permissiongroup = $permissiongroup;
    }

    public function GetID() {
        return $this->id;
    }

    public function GetEmail() {
        return $this->email;
    }

    public function GetUsername() {
        return $this->username;
    }

    public function GetPermissionGroup() {
        return $this->permissiongroup;
    }
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

    public function SetUserPassword($id, $rawPassword) {
        $auth = new Authentication($this->fruitsql, $this->userTable, 12);
        $hashedPassword = $auth->HashPassword($rawPassword);
        $statement = "UPDATE $this->userTable SET HashedPassword=? WHERE ID=?";
        $result = $this->fruitsql->PreparedStatement($statement, 'si', $hashedPassword, $id);
        return $result;
    }
}

?>