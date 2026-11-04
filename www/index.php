<?php
    require_once("config/database.php");
    require_once("common/componente.php");
    $pdo = getPDO();
    $componenti = Componente::getAll($pdo);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaTuaCommunityPeruzzi - Visualizzazione database</title>
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
    <script src="script.js"></script>
</head>
<body>
    <?php
    require_once("common/header.php");
    ?>
    <h1>LaTuaCommunityPeruzzi - Visualizzazione database</h1>
    <br>
    <div>
        <table style="width: 100%; table-layout: fixed;">
            <colgroup> <!-- è la stessa cosa di metterla in th ma + elegante -->
                <col style="width: 3%">
                <col style="width: 10%">
                <col style="width: 4%">
                <col style="width: 4%">
                <col style="width: 4%">
                <col style="width: 7%">
                <col style="width: 7%">
                <col style="width: 30%">
                <col style="width: 10%">
                <col style="width: 3%">
                <col style="width: 3%">

                <col style="width: 4%">
                <col style="width: 4%">
                <col style="width: 4%">
                <col style="width: 4%">
            </colgroup>
              <tr>
                <th>id_componente</th>
                <th>sigla</th>
                <th>tensione_op_v_min</th>
                <th>tensione_op_v_max</th>
                <th>corrente_max_ma</th>
                <th>interfaccia</th>
                <th>package</th>
                <th>note</th>
                <th>link_datasheet</th>
                <th>id_produttore</th>
                <th>id_utente_pubblica</th>
            </tr>
            <?php
                foreach ($componenti as $c) {
                    echo
                    "<tr>
                    <td>$c->id_componente</td>
                    <td>$c->sigla</td>
                    <td>$c->tensione_op_v_min</td>
                    <td>$c->tensione_op_v_max</td>
                    <td>$c->corrente_max_ma</td>
                    <td>$c->interfaccia</td>
                    <td>$c->package</td>
                    <td>$c->note</td>
                    <td>$c->link_datasheet</td>
                    <td>$c->id_produttore</td>
                    <td>$c->id_utente_pubblica</td>
                    <td>
                        <a href='modifica.php?id=$c->id_componente'>Modifica page</a>
                    </td>
                    <td>
                        <button onclick='modificaRapida($c->id_componente)'>Modifica</button>
                    </td>
                    <td>
                        <!-- il onlcick serve per poterlo annullare -->
                        <a href='elimina.php?id=$c->id_componente' onclick='return confirm(`Sei sicuro di voler eliminare questo componente?`);'>Elimina page</a>
                    </td>
                    <td>
                        <form method='POST' action='elimina.php' onsubmit='return confirm(`Sei sicuro di voler eliminare?`);' style='display:inline;'>
                        <input type='hidden' name='id_componente' value='$c->id_componente'>
                        <button type='submit'>Elimina</button>
                        </form>
                    </td>
                    </tr>"
                    ;
                }
            
                /*
                ALTERNATIVA:

                • Apri un ciclo:
                    <?php foreach ($componenti as $c): ?>

                • Dentro al ciclo crei un <tr> e per ogni colonna un <td>:
                    • Siccome $c è un oggetto Componente, accedi alle sue
                    proprietà con la freccia ->, ad esempio:                     
                    <?= htmlspecialchars($c->sigla) ?>      
                    <?= htmlspecialchars($c->tensione_op_v_min ?? '-') ?>
                • Chiudi il ciclo con:
                    <?php endforeach; ?>

                */
            ?>

        </table>
    </div>
</body>
</html>
