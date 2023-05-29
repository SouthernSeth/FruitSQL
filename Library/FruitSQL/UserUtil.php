<?php

class UserUtil {

    private $fruitsql;
    private $userTable;
    private $idFieldName;
    private $hashedPasswordFieldName;

    public function __construct($fruitsql, $userTable, $idFieldName, $hashedPasswordFieldName) {
        $this->fruitsql = $fruitsql;
        $this->userTable = $userTable;
        $this->idFieldName = $idFieldName;
        $this->hashedPasswordFieldName = $hashedPasswordFieldName;
    }

    public function HashPassword($rawPassword) {
        $options = [
            'cost' => 12,
        ];

        $hashedPassword = password_hash($rawPassword, PASSWORD_BCRYPT, $options);
        return $hashedPassword;
    }

    public function VerifyPassword($rawPassword, $hashedPassword) {
        if (password_verify($rawPassword, $hashedPassword)) {
            return true;
        } else {
            return false;
        }
    }

    public function VerifyLogin($id, $rawPassword) {
        $id = $this->fruitsql->GetMysqli()->real_escape_string($id);

        $result = $this->fruitsql->Query(sprintf("SELECT $this->idFieldName, $this->hashedPasswordFieldName FROM $this->userTable WHERE $this->idFieldName = '%s'", $id));

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rowid = $row[$this->idFieldName];
                $rowhashedPassword = $row[$this->hashedPasswordFieldName];

                if ($rowid == $id) {
                    if ($this->VerifyPassword($rawPassword, $rowhashedPassword)) {
                        return true;
                    }
                }
            }
        }

        return false;
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

    public function CreateUserTable($usertablename) {
        $statement = "CREATE TABLE IF NOT EXISTS $usertablename (ID INT(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY, Email VARCHAR(255) NOT NULL, Username VARCHAR(255) NOT NULL, HashedPassword VARCHAR(255) NOT NULL, PermissionGroup VARCHAR(255) NOT NULL, AccountCreationTimestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, LastLoginTimestamp TIMESTAMP NULL)";
        $result = $this->fruitsql->Query($statement);
        return $result;
    }

}

?>