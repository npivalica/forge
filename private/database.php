<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'forge';
$dsn    = "mysql:host=$dbhost;dbname=$dbname;";

try {
    $connection = new PDO($dsn, $dbuser, $dbpass);
} catch (PDOException $e) {
    error_log($e->getMessage());
    
}
?>