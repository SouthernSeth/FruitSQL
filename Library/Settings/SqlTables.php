<?php

/*

This script defines a list of all the tables that need to be created.
This will only be used once usually, but it is recommended to create
a backup in-case you ever need to re-create these tables.

There are a lot of predefined tables. Feel free to change the queries
to fit your needs, I've included a section at the bottom of this script
to add your own custom tables instead of the pre-defined tables.

1. Numeric Data Types:
   - TINYINT: 1 byte (-128 to 127 signed, 0 to 255 unsigned)
   - SMALLINT: 2 bytes (-32,768 to 32,767 signed, 0 to 65,535 unsigned)
   - MEDIUMINT: 3 bytes (-8,388,608 to 8,388,607 signed, 0 to 16,777,215 unsigned)
   - INT: 4 bytes (-2,147,483,648 to 2,147,483,647 signed, 0 to 4,294,967,295 unsigned)
   - BIGINT: 8 bytes (-9,223,372,036,854,775,808 to 9,223,372,036,854,775,807 signed, 0 to 18,446,744,073,709,551,615 unsigned)
   - FLOAT: 4 bytes (single-precision floating-point number)
   - DOUBLE: 8 bytes (double-precision floating-point number)
   - DECIMAL: Variable (up to 65 digits of precision)

2. Character String Data Types:
   - CHAR: Fixed-length string (up to 255 characters)
   - VARCHAR: Variable-length string (up to 65,535 characters)
   - TINYTEXT: Variable-length string (up to 255 characters)
   - TEXT: Variable-length string (up to 65,535 characters)
   - MEDIUMTEXT: Variable-length string (up to 16,777,215 characters)
   - LONGTEXT: Variable-length string (up to 4,294,967,295 characters)
   - ENUM: Enumeration (a set of predefined values)

3. Date and Time Data Types:
   - DATE: Date value (range from '1000-01-01' to '9999-12-31')
   - TIME: Time value (range from '-838:59:59' to '838:59:59')
   - DATETIME: Date and time value (range from '1000-01-01 00:00:00' to '9999-12-31 23:59:59')
   - TIMESTAMP: Automatic timestamp value (range from '1970-01-01 00:00:01' to '2038-01-19 03:14:07')

4. Boolean Data Type:
   - BOOLEAN or BOOL: Boolean value (true or false)

5. Binary Data Types:
   - BINARY: Fixed-length binary string (up to 255 bytes)
   - VARBINARY: Variable-length binary string (up to 65,535 bytes)
   - TINYBLOB: Variable-length binary data (up to 255 bytes)
   - BLOB: Variable-length binary data (up to 65,535 bytes)
   - MEDIUMBLOB: Variable-length binary data (up to 16,777,215 bytes)
   - LONGBLOB: Variable-length binary data (up to 4,294,967,295 bytes)

6. Other Data Types:
   - JSON: JSON (JavaScript Object Notation) data type
   - UUID: Universally unique identifier

*/

$tables = [];

/************************************************************/
/*                       USER DATA                          */
/************************************************************/

// Defines the 'Users' table for storing user's login information, permissions, etc.
$Users <<<END
CREATE TABLE Users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(320) NOT NULL,
    username VARCHAR(20) NOT NULL,
    hashedpwd VARCHAR(100) NOT NULL,
    permissiongroup VARCHAR(32) NOT NULL,
    regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lastlogin TIMESTAMP DEFAULT NULL
);
END;
// array_push($tables, $Users);

$MailingList <<<END
CREATE TABLE MailingList (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(320) NOT NULL,
    firstname VARCHAR(32) NOT NULL,
    lastname VARCHAR(32) NOT NULL,
    birthday DATE NOT NULL,
    state VARCHAR(32)
    regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
END;
// array_push($tables, $MailingList);

/************************************************************/
/*                         FORUM                            */
/************************************************************/

// Defines the 'ForumCategories' for storing a Forum's categories
$ForumCategories <<<END
CREATE TABLE ForumCategories (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(64) NOT NULL
);
END;
// array_push($tables, $ForumCategories);

// Defines the 'ForumThreads' for storing a Forum's threads
$ForumThreads <<<END

END;
// array_push($tables, $ForumThreads);

// Defines the 'ForumPosts' for storing a Forum's posts
$ForumPosts <<<END

END;
// array_push($tables, $ForumPosts);

// Defines the 'ForumPostReplies' for storing a Forum's replies on posts
$ForumPostsReplies <<<END

END;
// array_push($tables, $ForumPostsReplies);

/************************************************************/
/*                      E-COMMERCE                          */
/************************************************************/

// Defines the 'Store' table for keeping track of items sold in a shop
$StoreInventory <<<END
CREATE TABLE Store (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    productname VARCHAR(320) NOT NULL,
    productdescription VARCHAR(32) NOT NULL,
    productimages VARCHAR(5000),
    saleprice DECIMAL(19,4) NOT NULL,
    quantity VARCHAR(32) NOT NULL
);
END;
// array_push($tables, $StoreInventory);

$Sales <<<END

END;
// array_push($tables, $Sales);

/************************************************************/
/*                     CUSTOM TABLES                        */
/************************************************************/

// LIST CUSTOM TABLES HERE

// $customTable <<<END
// END;
// array_push($tables, $customTable);










/************************************************************/
/*                          CODE                            */
/************************************************************/

function GetTablesArray() {
    return $tables;
}

?>