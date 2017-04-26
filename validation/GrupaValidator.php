<?php
/*
 * 2012 Slaven Hrkac
 */

/**
 * Validator for {@link Grupa}.
 * @see GrupaMapper
 */
final class GrupaValidator {

    private function __construct() {
    }

    /**
     * Validate the given {@link Grupa} instance.
     * @param Grupa $grupa {@link Grupa} instance to be validated
     * @return array array of {@link Error} s
     */
    public static function validate(Grupa $grupa) {
        $errors = array();        
        if (!$grupa->getNaziv()) {
            $errors[] = new Error('naziv', 'Prazno ili pogrešno polje Naziv.');
        }
        return $errors;
    }

}

?>
