<?php
/*
 * 2012
 */

$errors = array();
$grupa = null;
$edit = array_key_exists('id', $_GET);
$dao = new GrupaDao();
$grupe = $dao->find();

if ($edit) {
    $grupa = Utils::getGrupaByGetId();
} else {
    // set defaults
    $grupa = new Grupa();
    $grupa->setDefault(0);
    $grupa->setStolId(null);
}

if (array_key_exists('cancel', $_POST)) {
    // redirect
    Utils::redirect('add-edit-group');

    
} elseif (array_key_exists('save', $_POST)) {
    // for security reasons, do not map the whole $_POST['gost']
    $data = array(
        'naziv' => $_POST['grupa']['naziv'],
        'stol_id' => $_POST['grupa']['stol_id']
    );
        ;
    // map
    GrupaMapper::map($grupa, $data);
    // validate
    $errors = GrupaValidator::validate($grupa);
    // validate
    if (empty($errors)) {
        // save
        $dao = new GrupaDao();
        $grupa = $dao->save($grupa);
        Flash::addFlash('Grupa je uspješno spremljena.');
        // redirect
        Utils::redirect('add-edit-group');
    }
}

?>
