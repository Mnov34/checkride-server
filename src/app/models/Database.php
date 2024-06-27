<?php

namespace app\models;

use PDO;
use PDOException;
use PDOStatement;

/**
 * PDO Database Class
 * Se connecte a la base de donnée
 * Prépare les query SQL
 * Bind les values
 *
 * @Author Azalphal
 */
class Database {
    private string $host = 'localhost';
    private string $user = 'root';
    private string $pass = 'root';
    private string $name = 'checkride';
    private string $port = '3306';
    private string $charset = 'utf8mb4';

    private ?PDOStatement $stmt = null;
    public PDO $conn;

    /**
     * Initialize une nouvelle connection a la base de donnée
     * a chaque fois qu'une nouvelle instance de la classe est initialisé
     */
    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->name . ";charset=" . $this->charset;
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_PERSISTENT => true,];

        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    /**
     * Prépare les requêtes sql
     *
     * @param $sql string Le contenu de la requête.
     * @return void
     */
    final public function query(string $sql): void {
        $this->stmt = $this->conn->prepare($sql);
    }

    /**
     * Execute une requête sql
     *
     * @param array $args
     * @return bool
     */
    final public function execute(array $args = []): bool {
        return $this->stmt->execute($args);
    }

    /**
     * Bind les requêtes sql
     *
     * @param mixed $param
     * @param mixed $value
     * @param mixed $type
     * @return void
     */
    final public function bind(mixed $param, mixed $value, mixed $type = null): void {
        if (is_null($type)) {
            $type = match (true) {
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default => PDO::PARAM_STR,
            };
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Recupère le resultat en array
     *
     * @return array|false
     */
    final public function resultSet(array $args = []): array|false {
        $this->execute($args);
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recupère une seule entrée et la return en objet
     *
     * @param array $args
     * @return mixed
     */
    final public function single(array $args = []): mixed {
        $this->execute($args);
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Compte le nombre de row dans une colonne
     *
     * @return int
     */
    final public function rowCount(): int {
        return $this->stmt->rowCount();
    }
}