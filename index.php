<?php

include 'Library/SqlLibrary.php';

function PrintUserTable() {
    $fruitsql = new FruitSQL();
    $result = $fruitsql->Query("SELECT * FROM users");
    
    echo <<<END
    <div class="tablecontainer">
    <h1 style="text-align: center;">Debug: User Table Dump</h1>
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

    if ($result->num_rows > 0) {
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
    }

    echo '</table></div>';
}

PrintUserTable();

?>

<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>

</html>