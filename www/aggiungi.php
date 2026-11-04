<?php
    require_once("config/database.php");
    require_once("common/componente.php");

    function nullSeVuoto($val) {
        return ($val === '' || $val === null) ? null : $val; 
    } 

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $pdo = getPDO();
        Componente::insertOne($pdo, array(
            null,
            nullSeVuoto($_POST["sigla"]),
            nullSeVuoto($_POST["tensione_op_v_min"]),
            nullSeVuoto($_POST["tensione_op_v_max"]),
            nullSeVuoto($_POST["corrente_max_ma"]),
            nullSeVuoto($_POST["interfaccia"]),
            nullSeVuoto($_POST["package"]),
            nullSeVuoto($_POST["note"]),
            nullSeVuoto($_POST["link_datasheet"]),
            nullSeVuoto($_POST["id_produttore"]),
            nullSeVuoto($_POST["id_utente_pubblica"]),
        ));

        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaTuaCommunityPeruzzi - Aggiunta elemento</title>
    <style>

    </style>
    <script src="script.js"></script>
</head>
<body>
    <?php
    require_once("common/header.php");
    ?>
    <h1>LaTuaCommunityPeruzzi - Aggiunta elemento</h1>
    <br>
    <div>
        <form action="" method="POST">
            <!-- id_componente: <input type="number" min="1" step="1"><br> -->
            sigla: <input type="text" name="sigla"><br>
            tensione_op_v_min: <input type="number" name="tensione_op_v_min" min="0" step="0.01"><br>
            tensione_op_v_max: <input type="number" name="tensione_op_v_max" min="0" step="0.01"><br>
            corrente_max_ma: <input type="number" name="corrente_max_ma" min="0" step="1"><br>
            interfaccia: <input type="text" name="interfaccia"><br>
            package: <input type="text" name="package"><br>
            <textarea name="note" placeholder="Note..."></textarea><br>
            link_datasheet: <input type="text" name="link_datasheet"><br>
            id_produttore: <input type="number" name="id_produttore" min="1" step="1"><br>
            id_utente_pubblica: <input type="number" name="id_utente_pubblica" min="1" step="1"><br>
            <button onclick="">Invia</button>
        </form>
    </div>
</body>