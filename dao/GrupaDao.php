<?php
/*
 * 2012 Slaven Hrkac
 */

/**
 * DAO for {@link Gost}.
 * <p>
 * It is also a service, ideally, this class should be divided into DAO and Service.
 */
final class GrupaDao {

    /** @var PDO */
    private $db = null;


    public function __destruct() {
        // close db connection
        $this->db = null;
    }
    
    /**
     * Find all {@link Grupa}s by search criteria.
     * @return array array of {@link Grupa}s
     */
    public function find() {
        $result = array();
        foreach ($this->query($this->getFindSql()) as $row) {
            $grupa = new Grupa();
            GrupaMapper::map($grupa, $row);
            $result[$grupa->getId()] = $grupa;
        }
        return $result;
    }
    
    /**
     * Find {@link Grupa} by identifier.
     * @return Grupa Grupa or <i>null</i> if not found
     */
    public function findById($id) {
        $row = $this->query('SELECT * FROM grupa WHERE deleted = 0 and id = ' . (int) $id)->fetch();
        if (!$row) {
            return null;
        }
        $grupa = new Grupa();
        GrupaMapper::map($grupa, $row);
        return $grupa;
    }

    /**
     * Save {@link Grupa}.
     * @param Grupa $grupa {@link Grupa} to be saved
     * @return Grupa saved {@link Grupa} instance
     */
    public function save(Grupa $grupa) {
        if ($grupa->getId() === null) {
            return $this->insert($grupa);
        }
        return $this->update($grupa);
    }

    /**
     * Delete {@link Grupa} by identifier.
     * @param int $id {@link Grupa} identifier
     * @return bool <i>true</i> on success, <i>false</i> otherwise
     */
    public function delete($id) {
        $sqlGost = 'UPDATE gost SET '.
                'grupa_id = (SELECT id FROM grupa WHERE defaultna = 1 LIMIT 1) '.
                'WHERE grupa_id = :id';
        $sql = '
            UPDATE grupa SET
                deleted = :deleted
            WHERE
                id = :id';
        $this->getDb()->beginTransaction();
        try {
            $statement = $this->getDb()->prepare($sql);
            $this->executeStatement($statement, array(
            ':deleted' => true,
            ':id' => $id,
            ));
            $statementGost = $this->getDb()->prepare($sqlGost);
            $this->executeStatement($statementGost, array(
            ':id' => $id,
            ));
            $this->getDb()->commit();
            } catch(Exception $e) {
                $this->getDb()->rollBack();
            }
        
        return $statement->rowCount() == 1;
    }

    /**
     * @return PDO
     */
    private function getDb() {
        if ($this->db !== null) {
            return $this->db;
        }
        $config = Config::getConfig("db");
        try {
            $this->db = new PDO($config['dsn'], $config['username'], $config['password']);
            // sljedece linije koda su dodane kako bi se ispravno prikazali HR znakovi
            $this->db->query("SET NAMES utf8");
            $this->db->query("SET CHARACTER SET utf8");
            $this->db->query("SET COLLATION_CONNECTION='utf8_general_ci'");
        } catch (Exception $ex) {
            throw new Exception('DB connection error: ' . $ex->getMessage());
        }
        return $this->db;
    }

    private function getFindSql() {
        $sql = 'SELECT * FROM grupa WHERE deleted = 0 ORDER BY grupa.defaultna desc, naziv';
        return $sql;
    }

    /**
     * @return Grupa
     * @throws Exception
     */
    private function insert(Grupa $grupa) {
        $grupa->setId(null);
        $sql = '
            INSERT INTO grupa (id, naziv, stol_id, defaultna, deleted)
                VALUES (:id, :naziv, :stol_id, :defaultna, :deleted)';
        return $this->execute($sql, $grupa);
    }

    /**
     * @return Gost
     * @throws Exception
     */
    private function update(Grupa $grupa) {
        //$todo->setLastModifiedOn(new DateTime());
        $sql = '
            UPDATE grupa SET
                naziv = :naziv,
                stol_id = :stol_id,
                defaultna = :defaultna,
                deleted = :deleted, 
                tstamp = default
            WHERE
                id = :id';
        return $this->execute($sql, $grupa);
    }

    /**
     * @return Todo
     * @throws Exception
     */
    private function execute($sql, Grupa $grupa) {
        $statement = $this->getDb()->prepare($sql);
        $this->executeStatement($statement, $this->getParams($grupa));
        if (!$grupa->getId()) {
            return $this->findById($this->getDb()->lastInsertId());
        }
        if (!$statement->rowCount()) {
            throw new NotFoundException('Grupa with ID "' . $grupa->getId() . '" does not exist.');
        }
        return $grupa;
    }

    private function getParams(Grupa $grupa) {
        $params = array(
            ':id' => $grupa->getId(),
            ':naziv' => $grupa->getNaziv(),
            ':stol_id' => $grupa->getStolId(),
            ':defaultna' => $grupa->getDefault(),
            ':deleted' => $grupa->getDeleted()
        );
        return $params;
    }

    private function executeStatement(PDOStatement $statement, array $params) {
        if (!$statement->execute($params)) {
            self::throwDbError($this->getDb()->errorInfo());
        }
    }

    /**
     * @return PDOStatement
     */
    private function query($sql) {
        $statement = $this->getDb()->query($sql, PDO::FETCH_ASSOC);
        if ($statement === false) {
            self::throwDbError($this->getDb()->errorInfo());
        }
        return $statement;
    }

    private static function throwDbError(array $errorInfo) {
        // TODO log error, send email, etc.
        throw new Exception('DB error [' . $errorInfo[0] . ', ' . $errorInfo[1] . ']: ' . $errorInfo[2]);
    }

}

?>
