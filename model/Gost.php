<?php
/*
 * 2012 Slaven Hrkac
 */

/**
 * Model class representing one GOST item.
 */
final class Gost {

    // side
    const SIDE_A = 1;
    const SIDE_B = 2;
    // sort
    const SORT_ALL = "SVI";
    const SORT_A = "A";
    const SORT_B = "B";
    
    /** @var */
    private $sort;

    /** @var int */
    private $id;
    /** @var string */
    private $ime;
    /** @var string */
    private $prezime;
    /** @var int */
    private $grupaId;
    /** @var int */
    private $domacinId;
    /** @var boolean */
    private $dosao;
    /** @var decimal */
    private $darBam;
    /** @var decimal */
    private $darEur;
    /** @var decimal */
    private $darHrk;
    /** @var string */
    private $komentar;
    /** @var boolean */
    private $deleted;
    /** @var timestamp */
    private $tstamp;
    /** @var string */
    private $nazivGrupe;
    /** @var string */
    private $nazivDomacina;
    
    /**
     * Create new {@link Gost} with default properties set.
     */
    public function __construct() {
//        $this->setSort(self::SORT_ALL);
        $this->setDosao(false);
        $this->setDarBam(0);
        $this->setDarEur(0);
        $this->setDarHrk(0);
        $this->setDeleted(false);
    }

    public static function allSorts() {
        return array(
            self::SORT_ALL,
            self::SORT_A,
            self::SORT_B
        );
    }

    public static function allSides() {
        return array(
            'A' => self::SIDE_A,
            'B' => self::SIDE_B
        );
    }

    //~ Getters & setters

    /**
     * @return int <i>null</i> if not persistent
     */
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if ($this->id !== null && $this->id != $id) {
            throw new Exception('Cannot change identifier to ' . $id . ', already set to ' . $this->id);
        }
        $this->id = (int) $id;
    }
    
    public function getIme() {
        return $this->ime;
    }

    public function setIme($ime) {
        $this->ime = $ime;
    }

    public function getPrezime() {
        return $this->prezime;
    }

    public function setPrezime($prezime) {
        $this->prezime = $prezime;
    }

    public function getGrupaId() {
        return $this->grupaId;
    }

    public function setGrupaId($grupaId) {
        $this->grupaId = $grupaId;
    }

    public function getDomacinId() {
        return $this->domacinId;
    }

    public function setDomacinId($side) {
        $this->domacinId = $side;
    }

    public function getDosao() {
        return $this->dosao;
    }

    public function setDosao($dosao) {
        $this->dosao = $dosao;
    }

    public function getDarBam() {
        return $this->darBam;
    }

    public function setDarBam($darBam) {
        $this->darBam = $darBam;
    }

    public function getDarEur() {
        return $this->darEur;
    }

    public function setDarEur($darEur) {
        $this->darEur = $darEur;
    }

    public function getDarHrk() {
        return $this->darHrk;
    }

    public function setDarHrk($darHrk) {
        $this->darHrk = $darHrk;
    }

    public function getKomentar() {
        return $this->komentar;
    }

    public function setKomentar($komentar) {
        $this->komentar = $komentar;
    }

//    /**
//     * @return int one of 1/2
//     */
//    public function getPriority() {
//        return $this->domacinId;
//    }
//
//    public function setPriority($side) {
//        GostValidator::validateSide($side);
//        $this->domacinId = $side;
//    }    
    
    /**
     * @return string one of ALL/A/B
     */
    public function getSort() {
        return $this->sort;
    }

    public function setSort($sort) {
        GostValidator::validateSort($sort);
        $this->sort = $sort;
    }

    /**
     * @return boolean
     */
    public function getDeleted() {
        return $this->deleted;
    }

    public function setDeleted($deleted) {
        $this->deleted = (bool) $deleted;
    }

    public function getTstamp() {
        return $this->tstamp;
    }

    public function setTstamp($tstamp) {
        $this->tstamp = $tstamp;
    }

        
    public function getNazivGrupe() {
        return $this->nazivGrupe;
    }

    public function setNazivGrupe($nazivGrupe) {
        $this->nazivGrupe = $nazivGrupe;
    }

    public function getNazivDomacina() {
        return $this->nazivDomacina;
    }

    public function setNazivDomacina($nazivDomacina) {
        $this->nazivDomacina = $nazivDomacina;
    }

}

?>
