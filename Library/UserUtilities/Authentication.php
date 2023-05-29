<?php

class Authentication {

    private $fruitsql = null;
    private $userTable = null;
    private $idFieldName = 'ID';
    private $hashedPasswordFieldName = 'HashedPassword';
    private $bcryptHashCost = 12;

    public function __construct($fruitsql, $bcryptHashCost) {
        $this->fruitsql = $fruitsql;
        $this->bcryptHashCost = $bcryptHashCost;
    }

    public function SetUserTableName($userTable) {
        $this->userTable = $userTable;
    }

    public function HashPassword($rawPassword) {
        $options = [
            'cost' => $bcryptHashCost,
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
        if ($this->userTable == null) {
            printf('Please call SetUserTableName() before calling VerifyLogin().');
            return false;
        }

        if ($this->fruitsql == null) {
            printf('Please make sure FruitSQL is instantiated and connected.');
            return false;
        }

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

}

?>