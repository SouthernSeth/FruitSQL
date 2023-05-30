<?php

include '../Library/FruitSQL_Init.php';

function PrintUserTable() {
    $fruitsql = new FruitSQL();
    $userdata = new UserData($fruitsql, 'users');

    $createdTable = $userdata->CreateUserTable();
    if ($createdTable) {
        echo '<div style="text-align: center; width: 100%;">User table was created</div>';
    } else {
        echo '<div style="text-align: center; width: 100%;">User table was not created. Does it already exist?</div>';
    }

    $result = $fruitsql->Query("SELECT * FROM users");

    if ($result->num_rows > 0) {
        echo <<<END
        <div class="tablecontainer">
        <h1 style="text-align: center; margin-top: 0; margin-bottom: 1em; padding: 0;">User Table Dump</h1>
        <table>
        <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Username</th>
        <th>Hashed Password</th>
        <th>Permission Group</th>
        <th>Account Creation Date</th>
        <th>Last Login Date</th>
        </tr>
        END;

        while ($row = $result->fetch_assoc()) {
            $id = $row["ID"];
            $email = $row["Email"];
            $username = $row["Username"];
            $hashedpwd = $row["HashedPassword"];
            $permissiongrp = $row["PermissionGroup"];
            $acctcreationdate = $row["AccountCreationTimestamp"];
            $lastlogin = ($row["LastLoginTimestamp"] == null ? 'NULL' : $row["LastLoginTimestamp"]);

            echo <<<END
            <tr>
            <td>$id</td>
            <td>$email</td>
            <td>$username</td>
            <td>$hashedpwd</td>
            <td>$permissiongrp</td>
            <td>$acctcreationdate</td>
            <td>$lastlogin</td>
            </tr>
            END;
        }

        echo '</table></div>';
    } else {
        echo <<<END
        <div class="tablecontainer">
        <h2 style="text-align: center; margin-top: 0; margin-bottom: 1em; padding: 0;">No data in user table</h2>
        </div>
        END;
    }
}

function UpdateUserPassword() {
    $fruitsql = new FruitSQL();
    $userdata = new UserData($fruitsql, 'users');
    $userdata->SetUserPassword(1, 'mypassword');
}

?>

<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
        UpdateUserPassword();
        PrintUserTable();
    ?>
</body>

</html>