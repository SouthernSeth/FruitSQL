<?php

class Authentication {

    private $fruitsql = null;
    private $userTable = null;
    private $idFieldName = 'ID';
    private $hashedPasswordFieldName = 'HashedPassword';
    private $bcryptHashCost = 12;

    public function __construct($fruitsql, $userTable, $bcryptHashCost) {
        $this->fruitsql = $fruitsql;
        $this->userTable = $userTable;
        $this->bcryptHashCost = $bcryptHashCost;
    }

    public function SetUserTableName($userTable) {
        $this->userTable = $userTable;
    }

    public function HashPassword($rawPassword) {
        $options = [
            'cost' => $this->bcryptHashCost,
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

    public function VerifyLogin($email, $rawPassword) {
        if ($this->userTable == null) {
            printf('Please call SetUserTableName() before calling VerifyLogin().');
            return false;
        }

        if ($this->fruitsql == null) {
            printf('Please make sure FruitSQL is instantiated and connected.');
            return false;
        }

        $email = $this->fruitsql->GetMysqli()->real_escape_string($email);
        $result = $this->fruitsql->Query(sprintf("SELECT Email, $this->hashedPasswordFieldName FROM $this->userTable WHERE Email = '%s'", $email));

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sqlEmail = $row["Email"];
                $rowhashedPassword = $row[$this->hashedPasswordFieldName];

                if ($sqlEmail == $email) {
                    if ($this->VerifyPassword($rawPassword, $rowhashedPassword)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function GetUserObject($id) {
        if ($this->userTable == null) {
            printf('Please call SetUserTableName() before calling VerifyLogin().');
            return null;
        }

        if ($this->fruitsql == null) {
            printf('Please make sure FruitSQL is instantiated and connected.');
            return null;
        }

        $result = $this->fruitsql->Query(sprintf("SELECT * FROM $this->userTable WHERE $this->idFieldName = %s", $id));
        $rowCount = $result->num_rows;

        if ($rowCount == 1) {
            $row = $result->fetch_assoc();
            $id = $row["ID"];
            $email = $row["Email"];
            $username = $row["Username"];
            $permissiongrp = $row["PermissionGroup"];
            $user = new User($id, $email, $username, $permissiongrp);
            return $user;
        } else if ($rowCount < 1) {
            printf('No user found for ID #' . $id);
            return null;
        }  else if ($rowCount > 1) {
            printf('Too many user objects returned. Are there multiple users with the same ID?');
            return null;
        }
    }

}

?>