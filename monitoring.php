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

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if(!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
}



function update() {
	$imageNames = array("node.exe", "mongod.exe", "httpd.exe");
	exec('tasklist /FI "imagename eq node.exe" /fo csv > results.txt');
	exec('tasklist /FI "imagename eq mongod.exe" /fo csv /nh >> results.txt');
	exec('tasklist /FI "imagename eq httpd.exe" /fo csv /nh >> results.txt');

	$csv = csv_to_array("results.txt");

	$res = array();
	foreach ($csv as $key => $value) {
		$res[$value["Nom de l'image"]] = array();
		$res[$value["Nom de l'image"]]["status"] = "success";
	}

/*
	foreach ($imageNames as $key => $value) {
		if (!in_array($value, $res)) {
			$res[$key] = array("status" => "danger");
		}
	}*/

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