<?php

/*

This script defines a list of all the tables that need to be created.
This will only be used once usually, but it is recommended to create
a backup in-case you ever need to re-create these tables.

There are a lot of predefined tables. Feel free to change the queries
to fit your needs, I've included a section at the bottom of this script
to add your own custom tables instead of the pre-defined tables.

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