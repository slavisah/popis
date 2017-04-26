<?php
/*
 * 2012 Slaven Hrkac
 */

/**
 * Validator for {@link Gost}.
 * @see GostMapper
 */
final class GostValidator {

    private function __construct() {
    }

    /**
     * Validate the given {@link Todo} instance.
     * @param Todo $todo {@link Todo} instance to be validated
     * @return array array of {@link Error} s
     */
    public static function validate(Gost $gost) {
        $errors = array();
        
        if (!$gost->getPrezime()) {
            $errors[] = new Error('prezime', 'Prazno ili pogrešno polje Prezime.');
        }
//        if (!$todo->getLastModifiedOn()) {
//            $errors[] = new Error('lastModifiedOn', 'Empty or invalid Last Modified On.');
//        }
//        if (!trim($todo->getTitle())) {
//            $errors[] = new Error('title', 'Title cannot be empty.');
//        }
//        if (!$todo->getDueOn()) {
//            $errors[] = new Error('dueOn', 'Empty or invalid Due On.');
//        }
//        if (!trim($todo->getPriority())) {
//            $errors[] = new Error('priority', 'Priority cannot be empty.');
//        } elseif (!self::isValidPriority($todo->getPriority())) {
//            $errors[] = new Error('priority', 'Invalid Priority set.');
//        }
//        if (!trim($todo->getStatus())) {
//            $errors[] = new Error('status', 'Status cannot be empty.');
//        } elseif (!self::isValidStatus($todo->getStatus())) {
//            $errors[] = new Error('status', 'Invalid Status set.');
//        }
        return $errors;
    }

    /**
     * Validate the given sort.
     * @param string $sort sort to be validated
     * @throws Exception if the sort is not known
     */
    public static function validateSort($status) {
        if (!self::isValidSort($status)) {
            throw new Exception('Unknown sort: ' . $status);
        }
    }

    /**
     * Validate the given side.
     * @param int $side side to be validated
     * @throws Exception if the side is not known
     */
    public static function validateSide($side) {
        if (!self::isValidSide($side)) {
            throw new Exception('Unknown side: ' . $side);
        }
    }

    private static function isValidSort($sort) {
        return in_array($sort, Gost::allSorts());
    }

    private static function isValidSide($side) {
        return in_array($side, Gost::allSides());
    }

}

?>
