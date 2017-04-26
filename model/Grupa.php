<?php
/*
 * 2012 Slaven Hrkac
 */

/**
 * Model class representing one GRUPA item.
 */
final class Grupa {

    /** @var int */
    private $id;
    /** @var string */
    private $naziv;
    /** @var int */
    private $stolId;
    /** @var boolean */
    private $default;
    /** @var boolean */
    private $deleted;
    /** @var timestamp */
    private $tstamp;

    /**
     * Create new {@link Grupa} with default properties set.
     */
    public function __construct() {
        $this->setDeleted(false);
        $this->setDefault(false);
        $this->setStolId(null);
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
    
    public function getNaziv() {
        return $this->naziv;
    }

    public function setNaziv($naziv) {
        $this->naziv = $naziv;
    }

    public function getStolId() {
        return $this->stolId;
    }

    public function setStolId($stolId) {
        $this->stolId = $stolId;
    }
    
    public function getDefault() {
        return $this->default;
    }

    public function setDefault($default) {
        $this->default = (bool)$default;
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

}

?>
