<?php
/*
 * 2012 Slaven Hrkac
 */

/**
 * DAO for {@link Gost}.
 * <p>
 * It is also a service, ideally, this class should be divided into DAO and Service.
 */
final class GostDao {

    /** @var PDO */
    private $db = null;


    public function __destruct() {
        // close db connection
        $this->db = null;
    }

    /**
     * Find all {@link Gost}s by search criteria.
     * @return array array of {@link Gost}s
     */
    public function find(GostSearchCriteria $search = null) {
        $result = array();
        foreach ($this->query($this->getFindSql($search)) as $row) {
            $gost = new Gost();
            $gost->setSort($search->getSort());
            GostMapper::map($gost, $row);
            $result[$gost->getId()] = $gost;
        }
        return $result;
    }

    /**
     * Find {@link Gost} by identifier.
     * @return Gost Gost or <i>null</i> if not found
     */
    public function findById($id) {
        $sql = 'SELECT g.id, g.ime, g.prezime, g.grupa_id, gr.naziv as naziv_grupe, '.
                'g.domacin_id, do.ime as naziv_domacina, g.dosao, '.
                'g.dar_bam, g.dar_eur, g.dar_hrk, g.komentar, g.deleted, g.tstamp '.
                'FROM gost g '.
                'LEFT OUTER JOIN grupa gr ON ( gr.id = g.grupa_id ) '.
                'LEFT OUTER JOIN domacin do ON ( do.id = g.domacin_id ) '.
                'WHERE g.deleted = 0 and g.id = ' . (int) $id;
        $row = $this->query($sql)->fetch();
        if (!$row) {
            return null;
        }
        $gost = new Gost();
        GostMapper::map($gost, $row);
        return $gost;
    }

    /**
     * Save {@link Gost}.
     * @param Gost $gost {@link Gost} to be saved
     * @return Gost saved {@link Gost} instance
     */
    public function save(Gost $gost) {
        if ($gost->getId() === null) {
            return $this->insert($gost);
        }
        return $this->update($gost);
    }

    /**
     * Delete {@link Gost} by identifier.
     * @param int $id {@link Gost} identifier
     * @return bool <i>true</i> on success, <i>false</i> otherwise
     */
    public function delete($id) {
        $sql = '
            UPDATE gost SET
                deleted = :deleted
            WHERE
                id = :id';
        $statement = $this->getDb()->prepare($sql);
        $this->executeStatement($statement, array(
            ':deleted' => true,
            ':id' => $id,
        ));
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

    private function getFindSql(GostSearchCriteria $search = null) {
        $sql = 'SELECT g.id, g.ime, g.prezime, g.grupa_id, gr.naziv as naziv_grupe, '.
                'g.domacin_id, do.ime as naziv_domacina, g.dosao, '.
                'g.dar_bam, g.dar_eur, g.dar_hrk, g.komentar, g.deleted, g.tstamp '.
                'FROM gost g '.
                'LEFT OUTER JOIN grupa gr ON ( gr.id = g.grupa_id ) '.
                'LEFT OUTER JOIN domacin do ON ( do.id = g.domacin_id ) '.
                'WHERE g.deleted = 0 ';
        
        $orderBy = ' g.prezime ';
        if ($search !== null) {
            if ($search->getSort() !== null) {
                switch ($search->getSort()) {
                    case Gost::SORT_ALL:
                        break;
                    case Gost::SORT_A:
                        $sql .= 'AND g.domacin_id = ' . Gost::SIDE_A;
                        break;
                    case Gost::SORT_B:
                        $sql .= 'AND g.domacin_id = ' . Gost::SIDE_B;
                        break;
                    case Gost::SORT_X:
                        $sql .= 'AND g.domacin_id IS NULL';
                        break;
                    default:
                        throw new Exception('No order for: ' . $search->getSort());
                }
            }
        }
        $sql .= ' ORDER BY ' . $orderBy;

        
        return $sql;
    }

    /**
     * @return Gost
     * @throws Exception
     */
    private function insert(Gost $gost) {
        $gost->setId(null);
        $sql = '
            INSERT INTO gost (id, ime, prezime, grupa_id, domacin_id, dosao, dar_bam, dar_eur, dar_hrk, komentar, deleted)
                VALUES (:id, :ime, :prezime, :grupa_id, :domacin_id, :dosao, :dar_bam, :dar_eur, :dar_hrk, :komentar, :deleted)';
        return $this->execute($sql, $gost);
    }

    /**
     * @return Gost
     * @throws Exception
     */
    private function update(Gost $gost) {
        //$todo->setLastModifiedOn(new DateTime());
        $sql = '
            UPDATE gost g SET
                g.ime = :ime,
                g.prezime = :prezime,
                g.grupa_id = :grupa_id,
                g.domacin_id = :domacin_id,
                g.dosao = :dosao,
                g.dar_bam = :dar_bam,
                g.dar_eur = :dar_eur,
                g.dar_hrk = :dar_hrk,
                g.komentar = :komentar,
                g.deleted = :deleted,
                g.tstamp = default
            WHERE
                g.id = :id';
        return $this->execute($sql, $gost);
    }

    /**
     * @return Gost
     * @throws Exception
     */
    private function execute($sql, Gost $gost) {
        $statement = $this->getDb()->prepare($sql);
        $this->executeStatement($statement, $this->getParams($gost));
        if (!$gost->getId()) {
            return $this->findById($this->getDb()->lastInsertId());
        }
        if (!$statement->rowCount()) {
            throw new NotFoundException('Gost with ID "' . $gost->getId() . '" does not exist.');
        }
        return $gost;
    }

    private function getParams(Gost $gost) {
        $params = array(
            ':id' => $gost->getId(),
            ':ime' => $gost->getIme(),
            ':prezime' => $gost->getPrezime(),
            ':grupa_id' => $gost->getGrupaId(),
            ':domacin_id' => $gost->getDomacinId(),
            ':dosao' => $gost->getDosao(),
            ':dar_bam' => $gost->getDarBam(),
            ':dar_eur' => $gost->getDarEur(),
            ':dar_hrk' => $gost->getDarHrk(),
            ':komentar' => $gost->getKomentar(),
            ':deleted' => $gost->getDeleted()
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

    private static function formatDateTime(DateTime $date) {
        return $date->format(DateTime::ISO8601);
    }

}

?>
