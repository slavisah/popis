<?php
/*
 * 2012 Slaven Hrkac
 */

/**
 * Miscellaneous utility methods.
 */
final class Utils {

    private function __construct() {
    }

    /**
     * Generate link.
     * @param string $page target page
     * @param array $params page parameters
     */
    public static function createLink($page, array $params = array()) {
        $params = array_merge(array('page' => $page), $params);
        // add support for Apache's module rewrite
        return 'index.php?' .http_build_query($params);
    }

    /**
     * Format date.
     * @param DateTime $date date to be formatted
     * @return string formatted date
     */
    public static function formatDate(DateTime $date = null) {
        if ($date === null) {
            return '';
        }
        return $date->format('m/d/Y');
    }

    /**
     * Format date and time.
     * @param DateTime $date date to be formatted
     * @return string formatted date and time
     */
    public static function formatDateTime(DateTime $date = null) {
        if ($date === null) {
            return '';
        }
        return $date->format('m/d/Y H:i');
    }

    /**
     * Redirect to the given page.
     * @param type $page target page
     * @param array $params page parameters
     */
    public static function redirect($page, array $params = array()) {
        header('Location: ' . self::createLink($page, $params));
        die();
    }

    /**
     * Get value of the URL param.
     * @return string parameter value
     * @throws NotFoundException if the param is not found in the URL
     */
    public static function getUrlParam($name) {
        if (!array_key_exists($name, $_GET)) {
            throw new NotFoundException('URL parameter "' . $name . '" not found.');
        }
        return $_GET[$name];
    }

    /**
     * Get {@link Gost} by the identifier 'id' found in the URL.
     * @return Gost {@link Gost} instance
     * @throws NotFoundException if the param or {@link Gost} instance is not found
     */
    public static function getGostByGetId() {
        $id = null;
        try {
            $id = self::getUrlParam('id');
        } catch (Exception $ex) {
            throw new NotFoundException('No Gost identifier provided.');
        }
        if (!is_numeric($id)) {
            throw new NotFoundException('Invalid Gost identifier provided.');
        }
        $dao = new GostDao();
        $gost = $dao->findById($id);
        if ($gost === null) {
            throw new NotFoundException('Unknown Gost identifier provided.');
        }
        return $gost;
    }
    
        /**
     * Get {@link Gost} by the identifier 'id' found in the URL.
     * @return Gost {@link Gost} instance
     * @throws NotFoundException if the param or {@link Gost} instance is not found
     */
    public static function getGrupaByGetId() {
        $id = null;
        try {
            $id = self::getUrlParam('id');
        } catch (Exception $ex) {
            throw new NotFoundException('No Grupa identifier provided.');
        }
        if (!is_numeric($id)) {
            throw new NotFoundException('Invalid Grupa identifier provided.');
        }
        $dao = new GrupaDao();
        $grupa = $dao->findById($id);
        if ($grupa === null) {
            throw new NotFoundException('Unknown Grupa identifier provided.');
        }
        return $grupa;
    }

    /**
     * Capitalize the first letter of the given string
     * @param string $string string to be capitalized
     * @return string capitalized string
     */
    public static function capitalize($string) {
        return ucfirst(mb_strtolower($string));
    }

    /**
     * Escape the given string
     * @param string $string string to be escaped
     * @return string escaped string
     */
    public static function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES);
    }

}

?>
