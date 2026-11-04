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
</head>
<body>
    <?php
    require_once("common/header.php");
    ?>
    <h1>LaTuaCommunityPeruzzi - Visualizzazione database</h1>
    <br>
    <div>
        <table>
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
                    <td>$c->id_utente_pubblica</td>
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
