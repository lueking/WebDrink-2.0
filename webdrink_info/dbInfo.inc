<?php

// Database connection info
$dbName = "";
$dbHost = "mysql.csh.rit.edu";
$dbUser = "";
$dbPass = "";

// Create a PDO object and connect to the database
try {
    $pdo = new PDO(
        "mysql:dbname=$dbName;host=$dbHost",
        $dbUser,
        $dbPass,
        array(
            PDO::MYSQL_ATTR_FOUND_ROWS => true,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        )
    );
}
catch (PDOException $e) {
    die('Database Connection Failed: ' . $e->getMessage());
}

?>