<?php
function getPDO($dbname = "community_elettronica")
{
    try
    {
        $pdo = new PDO(
            "mysql:host=db;dbname=$dbname;charset=utf8mb4",
            getenv("DB_USER"),
            getenv("DB_PASSWORD")
        );
        return $pdo;
    } catch (PDOException $e) {
        die("Errore di connessione al database: " . $e->getMessage());
    }
}
