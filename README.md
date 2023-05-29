# FruitSQL
An open source PHP library backend with utilities built in for user authentication and permissions. The idea is to make it quick and easy to implement SQL into your PHP project without a large learning curve. The library is setup to make minimal calls to easily query or execute SQL statements.

### Authentication
Easily authenticate a user's raw password with a hashed bCrypt password stored in a SQL database

### Permissions
Permissions use a node based permission system such as admin.permission or member.permission. These can be quickly called to see check if a user has a specific permission and returns true or false depending on the result.

### Usage
Copy the 'Library' folder to the root of your project and include the SqlLibrary.php from here you are ready to use the Library. You will need to edit the SQL server settings in the Library/FruitSQL/FruitSQL.php under the FruitSqlSettings class. Once you have those variables set you can call $fruitsql = new FruitSQL(); to begin using the library. 

SQL queries can be executed by calling 
```
$result = $fruitsql->Query('SELECT * FROM tablename');
```

SQL prepared statements can by executed by calling 
```
$result = $fruitsql->PreparedStatement('INSERT INTO tablename (column1, column2, column3) VALUES (?,?,?)', 'sis', $valueForColumn1, $valueForColumn2, $valueForColumn3);
```

You can also directly access the MySqli object by calling 
```
$fruitsql->GetMysqli()
```

### Project Status
This project is currently being developed and is a WIP. The library might have bugs and spaghetti code. 
