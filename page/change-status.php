<?php
/*
 * 2012
 */

$gost = Utils::getGostByGetId();
$sort = null;
if (array_key_exists('sort', $_GET)) {
    $sort = $_GET['sort'];
}
$gost->setDomacinId(Utils::getUrlParam('side'));
//if (array_key_exists('comment', $_POST)) {
//    $todo->setComment($_POST['comment']);
//}

$dao = new GostDao();
$dao->save($gost);
Flash::addFlash('Strana za Gosta je uspješno promijenjena.');

Utils::redirect('list', array('sort' => $sort));

?>
