# Client-Server CRUD App (PHP + MySQL on XAMPP)

## Setup
1. Start **Apache** and **MySQL** in XAMPP.
2. Copy this folder to `C:\xampp\htdocs\phpcrud` (Mac/Linux: `htdocs/phpcrud`).
3. Open http://localhost/phpmyadmin -> Import -> choose `database.sql` (creates DB `phpcrud`, table `tblusers`).
4. Open http://localhost/phpcrud/ (client) and http://localhost/phpcrud/status.php (system check).

## Architecture (layered, client-server)
```
CLIENT (browser)            index.php  HTML + JS fetch()
   | HTTP + JSON
SERVER  API layer           api/users.php   (routes GET/POST/PUT/DELETE)
        Application layer   app/UserService.php        (validation, rules)
        Data layer          data/UserRepository.php    (SQL via PDO)
                            config/Database.php        (connection)
DATABASE                    MySQL  phpcrud.tblusers
```
Each layer only talks to the one directly below it.

## Demo script
1. Open status.php: all ticks green = every component communicates.
2. In index.php add / edit / delete a user; watch the communication log (request, response, trace).
3. Show the row change in phpMyAdmin -> proves data reached the database.
4. Try a duplicate email or empty name to show validation in the application layer (HTTP 422).
