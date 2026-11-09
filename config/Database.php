<?php
// DATA LAYER - connection to MySQL (XAMPP defaults)
class Database {
    public static function connect(): PDO {
        $pdo = new PDO('mysql:host=localhost;dbname=phpcrud;charset=utf8mb4', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}
