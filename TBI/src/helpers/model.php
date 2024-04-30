<?php

require '../config/database.php';

$linkConnectDB = getLinkConnectDB();

/**
 * Récupère les données d'une entrée dans une table grace a un ID.
 *
 * @param $id L'ID de l'objet cherché.
 * @param string $table La table a laquelle l'objet appartient.
 * @param string $select Ce que l'ont chercher (par defaut '*').
 *
 * @return false|array|null
 *
 * @throws Exception
 */
function getById($id, string $table, string $select = '*'): false|array|null {
    $id = intval($id);
    $sql = "SELECT $select FROM `$table` WHERE id=$id";

    $query = executeQuery($sql);
    $result = $query->get_result()->fetch_assoc();
    $query->close();

    return $result;
}

/**
 * Récupère toutes les données d'une table.
 *
 * @param string $table La table visée.
 *
 * @return array
 *
 * @throws Exception
 */
function getAll(string $table): array {

    $sql = "SELECT * FROM `$table`";

    $query = executeQuery($sql);
    $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
    $query->close();

    return $result;
}

/**
 * Sauvegarde ou met à jour un objet dans une table visée.
 *
 * @param string $table La table dans laquelle on souhaite enregister l'objet.
 * @param array $data L'objet que l'ont souhaites enregistrer.
 *
 * @return int|void
 */
function save(string $table, array $data = array()) {
    $values = array();
    global $linkConnectDB;

    foreach ($data as $key => $value) {
        $value = mysqli_real_escape_string($linkConnectDB, $value);
        $values[] = "`$key`='$value'";
    }

    $id = intval($data['id']);

    if ($id > 0) {
        $sql = "UPDATE `$table` SET " . implode(',', $values) . " WHERE id=$id";
    } else {
        $sql = "INSERT INTO `$table` SET " . implode(',', $values);
    }

    mysqli_query($linkConnectDB, $sql) or die(mysqli_error($linkConnectDB));
    $id = ($id > 0) ? $id : mysqli_insert_id($linkConnectDB);

    return $id;
}

/**
 * Récupère une entrée de la table en se basant sur les options données.
 *
 * @param string $table La table dans laquelle on fait la recherche.
 * @param array $options Les options de la recherche.
 *
 * @return array|false|null
 *
 * @throws Exception
 */
function getByOptions(string $table, array $options = []): false|array|null {
    $select = $options['select'] ?? '*';
    $where = isset($options['where']) ? 'WHERE ' . $options['where'] : '';
    $join = isset($options['join']) ? 'LEFT JOIN ' . $options['join'] : '';
    $order_by = isset($options['order_by']) ? 'ORDER BY ' . $options['order_by'] : '';
    $limit = isset($options['offset']) && isset($options['limit']) ? 'LIMIT ' . $options['offset'] . ',' . $options['limit'] : '';

    $sql = "SELECT $select FROM `$table` $join $where $order_by $limit";

    $query = executeQuery($sql);
    $result = $query->get_result()->fetch_assoc();
    $query->close();

    return $result;
}