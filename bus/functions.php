<?php
define("HOST", "www.ratp.fr");
function get_timetable($url)
{
	$chandle = curl_init();
	curl_setopt($chandle, CURLOPT_URL, $url);
	curl_setopt($chandle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($chandle, CURLOPT_CONNECTTIMEOUT, 5);
	$curlResult = curl_exec($chandle);
	curl_close($chandle);	
	return $curlResult;
}

function trimwebsource($tag, $html)
{
    $dom = new domDocument;
	$dom->loadHTML($html);
    $dom->preserveWhiteSpace = false;
    $content = $dom->getElementsByTagname($tag);

	$array = array();
	foreach($content as $node)
		$array[] = $node;
	if (isset($array[0]))
		return $array[0]->nodeValue;
	else
		return null;
}

function process_rawstring($rawstring, $stage)
{
	if ($stage == 1)
	{
		$rawstring = preg_replace("/A l'arret/", "mn", $rawstring);
		$rawstring = preg_replace("/A l'approche/", "mn", $rawstring);
		$rawstring = preg_replace("/[^a-z'+-.\/\s]/i", "", $rawstring);
		$rawstring = preg_replace("/mn/", ",", $rawstring);
		$rawstring = strtoupper($rawstring);
	}
	if ($stage == 2)
	{
		$rawstring = preg_replace("/A l'arret/", "0", $rawstring);
		$rawstring = preg_replace("/A l'approche/", "0", $rawstring);
		$rawstring = preg_replace("/[^0-9]/", "", $rawstring);
	}
	if ($stage == 3)
	{
		if (strlen($rawstring) > 15)
			$rawstring = preg_replace("/PORTE/", "PTE", $rawstring);
		if (strlen($rawstring) > 15)
			$rawstring = preg_replace("/CHATEAU DE VINCENNES|VINCENNES CHATEAU METRO/", "VINCENNES METRO", $rawstring);
		if (strlen($rawstring) > 15)
			$rawstring = preg_replace("/GARE DE |GARE D|GARE |CHARLES DE GAULLE-|-F. MITTERRAND|-LOUIS ARAGON|4 SEPTEMBRE/", "", $rawstring);
		if (strlen($rawstring) > 15)
			$rawstring = preg_replace("/MAIRIE DE |MAIRIE DU |MAIRIE DE LA |MAIRIE DES |MAIRIE D'|MAIRIE/", "", $rawstring);
		if (strlen($rawstring) > 15)
			$rawstring = preg_replace("/DU |DE LA |DES |DE | TGV 2| TGV/", "", $rawstring);
		if (strlen($rawstring) > 15)
			$rawstring = preg_replace("/LE |LA |LES /", "", $rawstring);
		if (strlen($rawstring) > 15)
			$rawstring = preg_replace("/-METRO| METRO|-T SUD/", "", $rawstring);
		$rawstring = trim($rawstring);
		if (strlen($rawstring) > 15)
			$rawstring = substr($rawstring, 0, 15).".";
	}
	return $rawstring;
}

include_once 'getstop.php';
function prepare_request($stop){
	if (substr($stop, 1, 1) === 'N')
		return "http://".HOST."/horaires/fr/ratp/noctilien/prochains_passages/PP/".$stop;
	else
		return "http://".HOST."/horaires/fr/ratp/bus/prochains_passages/PP/".$stop;
}
?>