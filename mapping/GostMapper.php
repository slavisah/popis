<?php
/*
 * 2012 Slaven Hrkac
 */

/**
 * Mapper for {@link Gost} from array.
 * @see GostValidator
 */
final class GostMapper {

    private function __construct() {
    }

    /**
     * Maps array to the given {@link Gost}.
     * <p>
     * Expected properties are:
     * <ul>
     *  <li>id</li>
     *  <li>ime</li>
     *  <li>prezime</li>
     *  <li>naziv_grupe</li>
     *  <li>domacin_id</li>
     *  <li>dosao</li>
     *  <li>dar_bam</li>
     *  <li>dar_eur</li>
     *  <li>dar_hrk</li>
     *  <li>komentar</li>
     *  <li>deleted</li>
     *  <li>naziv_grupe</li>
     *  <li>naziv_domacina</li>
     * </ul>
     * @param Gost $gost
     * @param array $properties
     */
    public static function map(Gost $gost, array $properties) {
        if (array_key_exists('id', $properties)) {
            $gost->setId($properties['id']);
        }
        if (array_key_exists('ime', $properties)) {
            $gost->setIme($properties['ime']);
        }
        if (array_key_exists('prezime', $properties)) {
            $gost->setPrezime($properties['prezime']);
        }
        if (array_key_exists('grupa_id', $properties)) {
            $gost->setGrupaId($properties['grupa_id']);
        }
        if (array_key_exists('domacin_id', $properties)) {
            $gost->setDomacinId($properties['domacin_id']);
        }
        if (array_key_exists('dar_bam', $properties)) {
            $gost->setDarBam($properties['dar_bam']);
        }
        if (array_key_exists('dar_eur', $properties)) {
            $gost->setDarEur($properties['dar_eur']);
        }
        if (array_key_exists('dar_hrk', $properties)) {
            $gost->setDarHrk($properties['dar_hrk']);
        }
        if (array_key_exists('komentar', $properties)) {
            $gost->setKomentar(trim($properties['komentar']));
        }
        if (array_key_exists('deleted', $properties)) {
            $gost->setDeleted($properties['deleted']);
        }
        if (array_key_exists('tstamp', $properties)) {
            $gost->setTstamp($properties['tstamp']);
        }
        if (array_key_exists('naziv_grupe', $properties)) {
            $gost->setNazivGrupe($properties['naziv_grupe']);
        }
        if (array_key_exists('naziv_domacina', $properties)) {
            $gost->setNazivDomacina($properties['naziv_domacina']);
        }
        if (array_key_exists('sort', $properties)) {
            $gost->setSort($properties['sort']);
        }
    }
    
}

?>
