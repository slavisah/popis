<?php
/*
 * 2012
 */

$errors = array();
$gost = null;
$edit = array_key_exists('id', $_GET);
$dao = new GrupaDao();
$grupe = $dao->find();
$sort = null;

if (array_key_exists('sort', $_GET)) {
    $sort = $_GET['sort'];
}

if ($edit) {
    $gost = Utils::getGostByGetId();
} else {
    // set defaults
    $gost = new Gost();
    
    if ($sort == Gost::SORT_A) {
        $gost->setDomacinId(Gost::SIDE_A);
    } elseif ($sort == Gost::SORT_B) {
        $gost->setDomacinId(Gost::SIDE_B);
    } else {
        Utils::redirect('list', array('sort' => $gost->getSort()));
    }
}

if (array_key_exists('cancel', $_POST)) {
    // redirect
    if ($edit) {
        Utils::redirect('list', array('id' => $gost->getId(), 'sort' => $sort));
    } else {
        Utils::redirect('list', array('sort' => $sort));
    }
    
} elseif (array_key_exists('save', $_POST)) {
    // for security reasons, do not map the whole $_POST['gost']
    $data = array(
        'ime' => $_POST['gost']['ime'],
        'prezime' => $_POST['gost']['prezime'],
        'grupa_id' => $_POST['gost']['grupa_id'],
        'komentar' => $_POST['gost']['komentar']
    );
        ;
    // map
    GostMapper::map($gost, $data);
    // validate
    $errors = GostValidator::validate($gost);
    // validate
    if (empty($errors)) {
        // save
        $dao = new GostDao();
        $gost = $dao->save($gost);
        Flash::addFlash('Gost je uspješno spremljen.');
        // redirect
        if ($edit) {
            Utils::redirect('list', array('id' => $gost->getId(), 'sort' => $sort));
        } else {
            Utils::redirect('add-edit', array('sort' => $sort));
        }
    }
}

?>
