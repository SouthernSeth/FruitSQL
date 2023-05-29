# FruitSQL
An open source PHP library backend with utilities built in for user authentication and permissions. The idea is to make it quick and easy to implement SQL into your PHP project without a large learning curve. The library is setup to make minimal calls to easily query or execute SQL statements.

# Authentication
Easily authenticate a user's raw password with a hashed bCrypt password stored in a SQL database

# Permissions
Permissions use a node based permission system such as admin.permission or member.permission. These can be quickly called to see check if a user has a specific permission and returns true or false depending on the result.
