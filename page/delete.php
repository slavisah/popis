<?php
/*
 * 2012
 */

$gost = Utils::getGostByGetId();

$sort = null;

if (array_key_exists('sort', $_GET)) {
    $sort = $_GET['sort'];
}

$dao = new GostDao();
$dao->delete($gost->getId());
Flash::addFlash('Gost je uspješno izbrisan.');

Utils::redirect('list', array('sort' => $sort));

?>
