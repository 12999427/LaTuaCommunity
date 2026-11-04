<?php
    require_once("config/database.php");
    require_once("common/componente.php");
    $pdo = getPDO();
    $comp = Componente::getOne($pdo, $_GET["id"]);

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $id = $_POST["id_componente"];
        $out = Componente::updateOne($pdo, $id, array($id, $_POST["sigla"], $_POST["tensione_op_v_min"], $_POST["tensione_op_v_max"], $_POST["corrente_max_ma"], $_POST["interfaccia"], $_POST["package"], $_POST["note"], $_POST["link_datasheet"], $_POST["id_produttore"], $_POST["id_utente_pubblica"]));
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaTuaCommunityPeruzzi - Modifica record <?php echo $_GET["id"]?> </title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            word-break: break-word;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php
    require_once("common/header.php");
    ?>
    <h1>LaTuaCommunityPeruzzi - Modifica record</h1>
    <br>
    <div>
        <!-- <form action="modifica.php" method="POST"> lasciare vuoto vuol dire stessa pagina -->
            <form action="" method="POST">
            id_componente: <input type="text" name="id_componente" required readonly value="<?php echo $comp->id_componente?>"><br>
            sigla: <input type="text" name="sigla" required value="<?php echo $comp->sigla?>"><br>
            tensione_op_v_min: <input type="text" name="tensione_op_v_min" value="<?php echo $comp->tensione_op_v_min?>"><br>
            tensione_op_v_max: <input type="text" name="tensione_op_v_max" value="<?php echo $comp->tensione_op_v_max?>"><br>
            corrente_max_ma: <input type="text" name="corrente_max_ma" value="<?php echo $comp->corrente_max_ma?>"><br>
            interfaccia: <input type="text" name="interfaccia" value="<?php echo $comp->interfaccia?>"><br>
            package: <input type="text" name="package" value="<?php echo $comp->package?>"><br>
            note: <input type="text" name="note" required value="<?php echo $comp->note?>"><br>
            link_datasheet: <input type="text" name="link_datasheet" value="<?php echo $comp->link_datasheet?>"><br>
            id_produttore: <input type="text" name="id_produttore" required value="<?php echo $comp->id_produttore?>"><br>
            id_utente_pubblica: <input type="text" name="id_utente_pubblica" required value="<?php echo $comp->id_utente_pubblica?>"><br>
            <button>Salva</button>
        </form>
    </div>
</body>
</html>