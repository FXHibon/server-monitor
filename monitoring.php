<?php
/*
 *  Script PHP qui traite les requêtes AJAX envoyées par le client 
**/
 
header('Content-type: application/json');

/**
* @link http://gist.github.com/385876
*/
function csv_to_array($filename='', $delimiter=',')
{
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            $data[] = $row;
        }
        fclose($handle);
    }
    return $data;
}



function update() {
	$imageNames = array("node.exe", "mongod.exe", "httpd.exe");
	exec('tasklist /FI "imagename eq node.exe" /fo csv /nh > results.txt');
	exec('tasklist /FI "imagename eq mongod.exe" /fo csv /nh >> results.txt');
	exec('tasklist /FI "imagename eq httpd.exe" /fo csv /nh >> results.txt');

	$csv = csv_to_array("results.txt");
	//var_dump($csv);
	$res = "";

	$processedProcess = [];

	// traitements des processus actifs
	foreach ($csv as $value) {
		if (in_array($value[0], $imageNames) ) {
			$processedProcess[] = $value[0];
			$tmp = '{"name": "' . $value[0] . '", "state": "running", "icon": "/dist/images/' . $value[0] . '-icon.png"}';
			$res .= $tmp . ", ";
		}
	}

	// traitements des processus inactifs
	foreach ($imageNames as $imageName) {
		if (!in_array($imageName, $processedProcess)) {
			$tmp = '{"name": "' . $imageName . '", "state": "down", "icon": "/dist/images/' . $imageName . '-icon.png"}';
			$res .= $tmp . ", ";
		}
	}
	$res = substr($res, 0, -2);

	echo "[" . $res . "]";

	exit();
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