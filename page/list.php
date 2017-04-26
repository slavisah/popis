<?php
/*
 * 2012 Slaven Hrkac
 */

//$status = Utils::getUrlParam('status');
//TodoValidator::validateStatus($status);
//
//$dao = new TodoDao();
//$search = new TodoSearchCriteria();
//$search->setStatus($status);
//
//// data for template
//$title = Utils::capitalize($status) . ' TODOs';
//$todos = $dao->find($search);

$sort = Utils::getUrlParam('sort');
GostValidator::validateSort($sort);

$dao = new GostDao();
$search = new GostSearchCriteria();
$search->setSort($sort);

// data for template
$title = Utils::capitalize($sort);
$gosti = $dao->find($search);

?>
