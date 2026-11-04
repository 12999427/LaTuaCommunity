const colonne = [
    "id_componente",
    "sigla",
    "tensione_op_v_min",
    "tensione_op_v_max",
    "corrente_max_ma",
    "interfaccia",
    "package",
    "note",
    "link_datasheet",
    "id_produttore",
    "id_utente_pubblica"
];

function modificaRapida(id_componente)
{
    let colonna = prompt("Quale colonna vuoi modificare (es. sigla, note, package)?").toLowerCase();
    if (!colonna) return;
    if (colonne.indexOf(colonna) == -1)
    {
        alert("Nome colonna invalido");
        return;
    }
    let val = prompt("Inserisci nuovo valore");
    window.location.href = `modifica_rapida.php?id_componente=${id_componente}&colonna=${encodeURIComponent(colonna)}&valore=${encodeURIComponent(val)}`;
    //encodeURIComponent >>> serve a codificare un componente di un URI (Uniform Resource Identifier), trasformando i caratteri speciali in una sequenza sicura per il Web
}
