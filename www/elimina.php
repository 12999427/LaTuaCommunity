<?php
    require_once("config/database.php");
    require_once("common/componente.php");

    $pdo = getPDO();

    $id = null;
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET["id"];
    } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id_componente"];
    }
    try {
        //nn si possono usare i segnaposti : per le colonne
        $sql = "DELETE FROM componenti WHERE id_componente = :id_componente";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":id_componente" => $id
        ]);
        //return "Ok - $stmt->rowCount() righe modificate";
    } catch(PDOException $e) {
        die("Errore durante l'aggiornamento: " . $e->getMessage());
    }
    header("Location: index.php");
    exit;
    