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

    public int $id_componente;
    public string $sigla;
    public ?float $tensione_op_v_min;
    public ?float $tensione_op_v_max;
    public ?int $corrente_max_ma;
    public ?string $interfaccia;
    public ?string $package;
    public string $note;
    public ?string $link_datasheet;
    public int $id_produttore;
    public int $id_utente_pubblica;

    function __construct($id_componente_,
    $sigla_,
    $tensione_op_v_min_,
    $tensione_op_v_max_,
    $corrente_max_ma_,
    $interfaccia_,
    $package_,
    $note_,
    $link_datasheet_,
    $id_produttore_,
    $id_utente_pubblica_
    ) 
    {
    $this->id_componente = $id_componente_;
    $this->sigla = $sigla_;
    $this->tensione_op_v_min = $tensione_op_v_min_;
    $this->tensione_op_v_max = $tensione_op_v_max_;
    $this->corrente_max_ma = $corrente_max_ma_;
    $this->interfaccia = $interfaccia_;
    $this->package = $package_;
    $this->note = $note_;
    $this->link_datasheet = $link_datasheet_;
    $this->id_produttore = $id_produttore_;
    $this->id_utente_pubblica = $id_utente_pubblica_;
    }

}