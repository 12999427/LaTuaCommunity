<?php
require_once("config/database.php");
$pdo = getPDO();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $colonne_permesse = ['sigla', 'tensione_op_v_min',  
    'tensione_op_v_max', 'corrente_max_ma', 'interfaccia',
    'package', 'note', 'link_datasheet'];
    $id = $_GET["id_componente"];
    $colonna = $_GET["colonna"];
    $valore = $_GET["valore"];
    if (in_array($colonna, $colonne_permesse)) {
         try {
            //nn si possono usare i segnaposti : per le colonne
            $sql = "UPDATE componenti SET
            $colonna = :val
            WHERE id_componente = :id_componente";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":val" => $valore,
                ":id_componente" => $id
            ]);
            //return "Ok - $stmt->rowCount() righe modificate";
        } catch(PDOException $e) {
            die("Errore durante l'aggiornamento: " . $e->getMessage());
        }
    }
    header("Location: index.php");
    exit;
}
?>