<?php
header('Content-Type: text/html; charset=utf-8');
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
	foreach($content as $node){
		$array[] = $node;
	}
	if (isset($array[0]))
		return $array[0]->nodeValue;
	else
		return null;
}



function process_rawstring($rawstring)
{
	$rawstring = iconv('UTF-8', 'ASCII//TRANSLIT', $rawstring);
	$rawstring = preg_replace("/Train a l'approche/", "TA", $rawstring);
	$rawstring = preg_replace("/Train a quai/", "TQ", $rawstring);
	$rawstring = preg_replace("/Train retarde/", "..", $rawstring);
	$rawstring = preg_replace("/Service termine/", "XX", $rawstring);
	$rawstring = preg_replace("/La D'efense/", "", $rawstring);
	$rawstring = preg_replace("/La Defense/", "", $rawstring);
	$rawstring = preg_replace("/Nation/", "", $rawstring);
	$rawstring = preg_replace("/Porte Dauphine/", "", $rawstring);
	$rawstring = preg_replace("/Pont de Levallois B'econ/", "", $rawstring);
	$rawstring = preg_replace("/Gallieni/", "", $rawstring);
	$rawstring = preg_replace("/Gambetta/", "", $rawstring);
	$rawstring = preg_replace("/Porte des Lilas/", "", $rawstring);
	$rawstring = preg_replace("/Mairie de Montrouge/", "", $rawstring);
	$rawstring = preg_replace("/Porte de Clignancourt/", "", $rawstring);
	$rawstring = preg_replace("/Place d'Italie/", "", $rawstring);
	$rawstring = preg_replace("/Bobigny Pablo Picasso/", "", $rawstring);
	$rawstring = preg_replace("/Montparnasse/", "", $rawstring);
	$rawstring = preg_replace("/Bienven/", "", $rawstring);
	$rawstring = preg_replace('/["]/', "", $rawstring);
	$rawstring = preg_replace("/ue/", "", $rawstring);
	$rawstring = preg_replace("/mn/", "", $rawstring);
	$rawstring = preg_replace("/ /", "", $rawstring);
	$rawstring = preg_replace("/Ch/", "", $rawstring);
	$rawstring = preg_replace("/arlesdeGaulleEtoile/", "", $rawstring);
	$rawstring = preg_replace("/ateaudeVincennes/", "", $rawstring);
	$rawstring = preg_replace('/[\^]/', "", $rawstring);
	$rawstring = preg_replace("/(?:\s|&nbsp;)/", ",", $rawstring, 3);
	return $rawstring;
}



function getlinecolor($line)
{
	if ($line == "3b"){$line = 30;}
	if ($line == "7b"){$line = 70;}
	switch ($line)
	{
		case 1:
			return "f2c931";
			break;
		case 2:
			return "216eb4";
			break;
		case 3:
			return "9a9940";
			break;
		case 30:
			return "89c7d6";
			break;
		case 4:
			return "bb4d98";
			break;
		case 5:
			return "de8b53";
			break;
		case 6:
			return "79bb92";
			break;
		case 7:
			return "df9ab1";
			break;
		case 70:
			return "79bb92";
			break;
		case 8:
			return "c5a3ca";
			break;
		case 9:
			return "cdc83f";
			break;
		case 10:
			return "dfb039";
			break;
		case 11:
			return "8e6538";
			break;
		case 12:
			return "328e5b";
			break;
		case 13:	
			return "89c7d6";
			break;
		case 14:
			return "67328e";
			break;
	}
}



function findterminus($line, $track){
	if ($track == 1)
		return findterminustrack1($line);
	if ($track == 2)
		return findterminustrack2($line);
}



function findterminustrack1($line){
	if ($line == "3b"){$line = 30;}
	if ($line == "7b"){$line = 70;}
	switch ($line)
	{
		case 1:
			return "La D&eacutefense";
			break;
		case 2:
			return "Porte</br>Dauphine";
			break;
		case 3:
			return "Levallois";
			break;
		case 30:
			return "Gambetta";
			break;
		case 4:
			return "Montrouge";
			break;
		case 5:
			return "Place d'Italie";
			break;
		case 6:
			return "&Eacutetoile";
			break;
		case 7:
			return "Ivry</br>Villejuif";
			break;
		case 70:
			return "Louis Blanc";
			break;
		case 8:
			return "Cr&eacuteteil";
			break;
		case 9:
			return "Montreuil";
			break;
		case 10:
			return "Gare</br>d'Austerlitz";
			break;
		case 11:
			return "Ch&acirctelet";
			break;
		case 12:
			return "Aubervilliers";
			break;
		case 13:
			return "Asni&egraveres</br>Gennevilliers";
			break;
		case 14:
			return "Saint-Lazare";
			break;
		default:
			return "";
	}
}



function findterminustrack2($line){
	if ($line == "3b"){$line = 30;}
	if ($line == "7b"){$line = 70;}
		switch ($line)
	{
		case 1:
			return "Ch&acircteau</br>de Vincennes";
			break;
		case 2:
			return "Nation";
			break;
		case 3:
			return "Gallieni";
			break;
		case 30:
			return "Porte</br>des Lilas";
			break;
		case 4:
			return "Porte de</br>Clignancourt";
			break;
		case 5:
			return "Bobigny";
			break;
		case 6:
			return "Nation";
			break;
		case 7:
			return "La Courneuve";
			break;
		case 70:
			return "Pr&eacute</br>Saint-Gervais";
			break;
		case 8:
			return "Balard";
			break;
		case 9:
			return "Pont</br>de S&egravevres";
			break;
		case 10:
			return "Boulogne";
			break;
		case 11:
			return "Mairie</br>des Lilas";
			break;
		case 12:
			return "Mairie d'Issy";
			break;
		case 13:
			return "Ch&acirctillon";
			break;
		case 14:
			return "Olympiades";
			break;
		default:
			return "";
	}
}



function prepare_request($line, $track, $station)
{
	if (!checkline($line) || ($track != 1 && $track != 2))
		return "";
	$station = formatstation($station);
	if ($track == 1)
		$track = "A";
	if ($track == 2)
		$track = "R";
	return "http://www.ratp.fr/horaires/fr/ratp/metro/prochains_passages/PP/{$station}/{$line}/{$track}";
}



function checkline($line)
{
	if ($line == "3b" || $line == "7b" || ($line >= 1 && $line <= 14))
		return true;
	else
		return false;
}



function formatstation($station){
	$station = preg_replace("/ /", "+", $station);
	$station = preg_replace("/(?:\s|&nbsp;)/", "", $station);
	$station = strtolower($station);
	return $station;
}



function check_valid_time($sieltime)
{
	if (strlen($sieltime) != 2)
		return false;
	if (!is_numeric($sieltime))
		if (!sielexceptions($sieltime))
			return false;
	return true;
}



function sielexceptions($sieltime)
{
	if ($sieltime == "++" || $sieltime == "--" || $sieltime == "__")
		return true;
	if ($sieltime == ".." || $sieltime == "XX" || $sieltime == "##")
		return true;
	if ($sieltime == "TA" || $sieltime == "TQ")
		return true;
	else
		return false;
}



function terminussize($terminus)
{
	$length = strlen($terminus);
	if (terminusexceptions($terminus))
		$length -= 7;
	if ($length <= 10)
		return "3.5";
	else if ($length > 10 && $length <= 14)
		return "3.0";
	else if ($length > 14 && $length <= 22)
		return "2.8";
	else
		return "2.5";
}



function terminusexceptions($terminus)
{
	if ($terminus == "Ch&acircteau de Vincennes" || $terminus == "La D&eacutefense" || $terminus == "&Eacutetoile")
		return true;
	if ($terminus == "Cr&eacuteteil" || $terminus == "Pont de S&egravevres" || $terminus == "Ch&acirctelet")
		return true;
	if ($terminus == "Asni&egraveres</br>Gennevilliers" || $terminus == "Ch&acirctillon")
		return true;
}



function veilledefete()
{
	if (date('d') == "01" && date('m') == "01")
		return true;
	if (date('d') == "01" && date('m') == "05")
		return true;
	if (date('d') == "08" && date('m') == "05")
		return true;
	if (date('d') == "14" && date('m') == "07")
		return true;
	if (date('d') == "15" && date('m') == "08")
		return true;
	if (date('d') == "01" && date('m') == "11")
		return true;
	if (date('d') == "25" && date('m') == "12")
		return true;
	return false;
}



function servicetermine($hours, $minutes)
{
	if (date('l') == "Saturday" || date('l') == "Sunday" || veilledefete() == true)
		if ($hours >= 2 && $hours < 5)
			return true;
	else
		if ($hours >= 1 && $hours < 5)
			return true;
	return false;
}



function handleaction($action)
{
	if ($action == "audio_off")
		$_SESSION['audio'] = "off";
	if ($action == "audio_on")
		$_SESSION['audio'] = "on";
	if ($action == "changeline")
		$_SESSION['station'] = null;
}
?>