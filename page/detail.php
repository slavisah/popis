<?php
/*
 * 2012
 */

// data for template
$gost = Utils::getGostByGetId();
//$tooLate = $todo->getStatus() == Todo::STATUS_PENDING && $todo->getDueOn() < new DateTime();
$gost->setSort(Utils::getUrlParam('sort'));
?>
