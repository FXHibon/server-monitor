<?php
/*
 *  Script PHP qui traite les requêtes AJAX envoyées par le client 
**/
 
header('Content-type: application/json');

function update() {
	$res = array(
	    'date'      => date('d/m/Y H:i:s'),
	    'phpversion'=> phpversion()
	);
	return $res;
}

function reboot($target) {
	$res = array(
	    'date'      => date('d/m/Y H:i:s'),
	    'phpversion'=> phpversion()
	);
	return $res;
}

// Récupération des paramètres
$action = '';
if( isset($_GET['action']) ){
    $action = $_GET['action'];
}
$target = '';
if( isset($_GET['target']) ){
    $target = $_GET['target'];
}

$retour = '';

if ($action && $target) {
	$retour = reboot($target);
} else {
	$retour = update();
}
 

 
// Envoi du retour (on renvoi le tableau $retour encodé en JSON)

echo json_encode($retour);
?>