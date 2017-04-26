<?php
/*
 * 2012
 */

$grupa = Utils::getGrupaByGetId();

$dao = new GrupaDao();
$dao->delete($grupa->getId());
Flash::addFlash('Grupa je uspješno izbrisana.');

Utils::redirect('add-edit-group');

?>
