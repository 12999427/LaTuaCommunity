<?php
class Componente
{
    public static function getAll($pdo)
    {
        $sql = "SELECT id_componente, sigla, tensione_op_v_min, tensione_op_v_max, corrente_max_ma, interfaccia, package, note, link_datasheet, id_produttore, id_utente_pubblica FROM componenti ORDER BY id_componente";

        $query = $pdo->query($sql);

        // Recupera i componenti come oggetti.
        $componenti = $query->fetchAll(PDO::FETCH_OBJ);

        $componenti_array = array();
        if (count($componenti) === 0) {
            return $componenti_array;
        }
        
        foreach ($componenti as $componente) {
            $componenti_array[$componente->id_componente] = new Componente(
                $componente->id_componente,
                $componente->sigla,
                $componente->tensione_op_v_min,
                $componente->tensione_op_v_max,
                $componente->corrente_max_ma,
                $componente->interfaccia,
                $componente->package,
                $componente->note,
                $componente->link_datasheet,
                $componente->id_produttore,
                $componente->id_utente_pubblica
            );
        }

        return $componenti_array;
    }

    public static function getOne($pdo, $id_componente)
    {
        $sql = "SELECT id_componente, sigla, tensione_op_v_min, tensione_op_v_max, corrente_max_ma, interfaccia, package, note, link_datasheet, id_produttore, id_utente_pubblica FROM componenti WHERE id_componente = $id_componente";

        $query = $pdo->query($sql);
        //$c = $query->fetchAll(PDO::FETCH_OBJ)[0]; //nota che ogni fetch consuma i risultati della query

        //$comp = new Componente($c->id_componente, $c->sigla, $c->tensione_op_v_min, $c->tensione_op_v_max, $c->corrente_max_ma, $c->interfaccia,$c->package, $c->note, $c->link_datasheet, $c->id_produttore, $c->id_utente_pubblica);

        //$comp = $query->fetchAll(PDO::FETCH_CLASS, Componente::class)[0];

        $comp = $query->fetchObject(Componente::class);
        return $comp;
    }

    public static function updateOne($pdo, $id_componente, $values)
    {
        /*
            // 2. Preparazione della query SQL (Usa la clausola WHERE!)
            $sql = "UPDATE utenti SET nome = :nome, email = :email WHERE id = :id";
            $stmt = $conn->prepare($sql);

            // 3. Associazione dei parametri ed esecuzione
            $stmt->execute([
                ':nome'  => $nuovo_nome,
                ':email' => $nuova_email,
                ':id'    => $id_utente
            ]);
        */
        try {
            $sql = "UPDATE componenti SET
            id_componente = :id_componente,
            sigla = :sigla,
            tensione_op_v_min = :tensione_op_v_min,
            tensione_op_v_max = :tensione_op_v_max,
            corrente_max_ma = :corrente_max_ma,
            interfaccia = :interfaccia,
            package = :package,
            note = :note,
            link_datasheet = :link_datasheet,
            id_produttore = :id_produttore,
            id_utente_pubblica = :id_utente_pubblica
            WHERE id_componente = :id_componente";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":id_componente" => $id_componente,
                ":sigla" => $values['sigla'] ?? $values[1] ?? null,
                ":tensione_op_v_min" => $values['tensione_op_v_min'] ?? $values[2] ?? null,
                ":tensione_op_v_max" => $values['tensione_op_v_max'] ?? $values[3] ?? null,
                ":corrente_max_ma" => $values['corrente_max_ma'] ?? $values[4] ?? null,
                ":interfaccia" => $values['interfaccia'] ?? $values[5] ?? null,
                ":package" => $values['package'] ?? $values[6] ?? null,
                ":note" => $values['note'] ?? $values[7] ?? null,
                ":link_datasheet" => $values['link_datasheet'] ?? $values[8] ?? null,
                ":id_produttore" => $values["id_produttore"] ?? $values[9] ?? null,
                "id_utente_pubblica" => $values["id_utente_pubblica"] ?? $values[10] ?? null
            ]);
            return "Ok - $stmt->rowCount() righe modificate";
        } catch(PDOException $e) {
            return "Errore durante l'aggiornamento: " . $e->getMessage();
        }
    }

    public static function insertOne($pdo, $values)
    {
        try {
            $sql = "INSERT INTO componenti (sigla, tensione_op_v_min, tensione_op_v_max, corrente_max_ma, interfaccia, package, note, link_datasheet, id_produttore, id_utente_pubblica)
            VALUES (:sigla, :tensione_op_v_min, :tensione_op_v_max, :corrente_max_max, :interfaccia, :package, :note, :link_datasheet, :id_produttore, :id_utente_pubblica)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":sigla"=> $values[1],
                ":tensione_op_v_min"=> $values[2],
                ":tensione_op_v_max"=> $values[3],
                ":corrente_max_max"=> $values[4],
                ":interfaccia"=> $values[5],
                ":package"=> $values[6],
                ":note"=> $values[7],
                ":link_datasheet"=> $values[8],
                ":id_produttore"=> $values[9],
                ":id_utente_pubblica"=> $values[10]
            ]);
            return $pdo->lastInsertId();
        } catch(PDOException $e) {
            return "Errore: " . $e->getMessage();
        }
    }

    public ?int $id_componente = null; // anche qui ? perchè necessario per quando fa fetchObject
    public ?string $sigla = null; // anche qui perchè necessario per quando fa fetchObject
    public ?float $tensione_op_v_min = null;
    public ?float $tensione_op_v_max = null;
    public ?int $corrente_max_ma = null;
    public ?string $interfaccia = null;
    public ?string $package = null;
    public ?string $note = null; // anche qui perchè necessario per quando fa fetchObject
    public ?string $link_datasheet = null;
    public ?int $id_produttore = null; // anche qui perchè necessario per quando fa fetchObject
    public ?int $id_utente_pubblica = null; // anche qui perchè necessario per quando fa fetchObject

    //in sta shit non puoi overloadare il costruttore
    function __construct($id_componente_ = null,
    $sigla_ = null,
    $tensione_op_v_min_ = null,
    $tensione_op_v_max_ = null,
    $corrente_max_ma_ = null,
    $interfaccia_ = null,
    $package_ = null,
    $note_ = null,
    $link_datasheet_ = null,
    $id_produttore_ = null,
    $id_utente_pubblica_ = null
    ) 
    {
    if ($id_componente_ !== null) $this->id_componente = $id_componente_;
    if ($sigla_ !== null) $this->sigla = $sigla_;
    if ($tensione_op_v_min_ !== null) $this->tensione_op_v_min = $tensione_op_v_min_;
    if ($tensione_op_v_max_ !== null) $this->tensione_op_v_max = $tensione_op_v_max_;
    if ($corrente_max_ma_ !== null) $this->corrente_max_ma = $corrente_max_ma_;
    if ($interfaccia_ !== null) $this->interfaccia = $interfaccia_;
    if ($package_ !== null) $this->package = $package_;
    if ($note_ !== null) $this->note = $note_;
    if ($link_datasheet_ !== null) $this->link_datasheet = $link_datasheet_;
    if ($id_produttore_ !== null) $this->id_produttore = $id_produttore_;
    if ($id_utente_pubblica_ !== null) $this->id_utente_pubblica = $id_utente_pubblica_;
    }

}