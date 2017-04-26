<?php
/*
 * 2012 Slaven Hrkac
 */

/**
 * Mapper for {@link Grupa} from array.
 */
final class GrupaMapper {

    private function __construct() {
    }

    /**
     * Maps array to the given {@link Grupa}.
     * <p>
     * Expected properties are:
     * <ul>
     *  <li>id</li>
     *  <li>naziv</li>
     *  <li>stol_id</li>
     *  <li>deleted</li>
     * </ul>
     * @param Grupa $grupa
     * @param array $properties
     */
    public static function map(Grupa $grupa, array $properties) {
        if (array_key_exists('id', $properties)) {
            $grupa->setId($properties['id']);
        }
        if (array_key_exists('naziv', $properties)) {
            $grupa->setNaziv($properties['naziv']);
        }
        if (array_key_exists('stol_id', $properties)) {
            $grupa->setStolId($properties['stol_id']);
        }
        if (array_key_exists('defaultna', $properties)) {
            $grupa->setDefault($properties['defaultna']);
        }
        if (array_key_exists('deleted', $properties)) {
            $grupa->setDeleted($properties['deleted']);
        }
        if (array_key_exists('tstamp', $properties)) {
            $grupa->setTstamp($properties['tstamp']);
        }
    }

}

?>
