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
	if (isset($array[0])){
		return $array[0]->nodeValue;
	}
	else{
	return null;	
	}
}



function process_rawstring($rawstring){
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



function getlinecolor($line){
	if ($line == "3b"){$line = 30;}
	if ($line == "7b"){$line = 70;}
	switch ($line)
	{
		case 1:
			$color = "f2c931";
			break;
		case 2:
			$color = "216eb4";
			break;
		case 3:
			$color = "9a9940";
			break;
		case 30:
			$color = "89c7d6";
			break;
		case 4:
			$color = "bb4d98";
			break;
		case 5:
			$color = "de8b53";
			break;
		case 6:
			$color = "79bb92";
			break;
		case 7:
			$color = "df9ab1";
			break;
		case 70:
			$color = "79bb92";
			break;
		case 8:
			$color = "c5a3ca";
			break;
		case 9:
			$color = "cdc83f";
			break;
		case 10:
			$color = "dfb039";
			break;
		case 11:
			$color = "8e6538";
			break;
		case 12:
			$color = "328e5b";
			break;
		case 13:	
			$color = "89c7d6";
			break;
		case 14:
			$color = "67328e";
			break;
	}
	return $color;
}



function findterminus($line, $track){
	if ($track == 1){
		$terminus = findterminustrack1($line);
		}
	if ($track == 2){
		$terminus = findterminustrack2($line);
		}
	return $terminus;
}



function findterminustrack1($line){
	if ($line == "3b"){$line = 30;}
	if ($line == "7b"){$line = 70;}
	switch ($line)
	{
		case 1:
			$terminus = "La D&eacutefense";
			break;
		case 2:
			$terminus = "Porte</br>Dauphine";
			break;
		case 3:
			$terminus = "Levallois";
			break;
		case 30:
			$terminus = "Gambetta";
			break;
		case 4:
			$terminus = "Montrouge";
			break;
		case 5:
			$terminus = "Place d'Italie";
			break;
		case 6:
			$terminus = "&Eacutetoile";
			break;
		case 7:
			$terminus = "Ivry</br>Villejuif";
			break;
		case 70:
			$terminus = "Louis Blanc";
			break;
		case 8:
			$terminus = "Cr&eacuteteil";
			break;
		case 9:
			$terminus = "Montreuil";
			break;
		case 10:
			$terminus = "Gare</br>d'Austerlitz";
			break;
		case 11:
			$terminus = "Ch&acirctelet";
			break;
		case 12:
			$terminus = "Aubervilliers";
			break;
		case 13:
			$terminus = "Asni&egraveres</br>Gennevilliers";
			break;
		case 14:
			$terminus = "Saint-Lazare";
			break;
		default:
			$terminus = "";
	}
		return $terminus;
}



function findterminustrack2($line){
	if ($line == "3b"){$line = 30;}
	if ($line == "7b"){$line = 70;}
		switch ($line)
	{
		case 1:
			$terminus = "Ch&acircteau</br>de Vincennes";
			break;
		case 2:
			$terminus = "Nation";
			break;
		case 3:
			$terminus = "Gallieni";
			break;
		case 30:
			$terminus = "Porte</br>des Lilas";
			break;
		case 4:
			$terminus = "Porte de</br>Clignancourt";
			break;
		case 5:
			$terminus = "Bobigny";
			break;
		case 6:
			$terminus = "Nation";
			break;
		case 7:
			$terminus = "La Courneuve";
			break;
		case 70:
			$terminus = "Pr&eacute</br>Saint-Gervais";
			break;
		case 8:
			$terminus = "Balard";
			break;
		case 9:
			$terminus = "Pont</br>de S&egravevres";
			break;
		case 10:
			$terminus = "Boulogne";
			break;
		case 11:
			$terminus = "Mairie</br>des Lilas";
			break;
		case 12:
			$terminus = "Mairie d'Issy";
			break;
		case 13:
			$terminus = "Ch&acirctillon";
			break;
		case 14:
			$terminus = "Olympiades";
			break;
		default:
			$terminus = "";
	}
		return $terminus;
}



function prepare_request($line, $track, $station){
	if ((checkline($line) != "OK") || ($track != 1 && $track != 2)){
		return "";
	}
		$station = formatstation($station);
	if ($track == 1){
		$track = "A";
	}
	if ($track == 2){
		$track = "R";
	}
	$request = "http://www.ratp.fr/horaires/fr/ratp/metro/prochains_passages/PP/{$station}/{$line}/{$track}";
	return $request;
}



function checkline($line){
	if ($line == "3b"){
		return "OK";
	}
	elseif ($line == "7b"){
		return "OK";
	}
	elseif ($line >= 1 && $line <= 14){
		return "OK";
	}
	else{
		return false;
	}
}



function formatstation($station){
	$station = preg_replace("/ /", "+", $station);
	$station = preg_replace("/(?:\s|&nbsp;)/", "", $station);
	$station = strtolower($station);
	return $station;
}



function check_valid_time($sieltime){
	if (strlen($sieltime) != 2){
		return false;
	}
	if (!is_numeric($sieltime)){
		if (!sielexceptions($sieltime)){
			return false;
		}
	}
	return true;
}



function sielexceptions($sieltime){
	if ($sieltime == "++" || $sieltime == "--" || $sieltime == "__"){
		return true;
		}
	if ($sieltime == ".." || $sieltime == "XX" || $sieltime == "##"){
		return true;
		}
	if ($sieltime == "TA" || $sieltime == "TQ"){
		return true;
		}
	else{
		return false;
	}
}



function terminussize($terminus){
	$length = strlen($terminus);
	if (terminusexceptions($terminus)){
		$length -= 7;
	}
	if ($length <= 10){
		return "3.5";
	}
	else if ($length > 10 && $length <= 14){
		return "3.0";
	}
	else if ($length > 14 && $length <= 22){
		return "2.8";
	}
	else{
		return "2.5";
	}
}



function terminusexceptions($terminus){
	if ($terminus == "Ch&acircteau de Vincennes" || $terminus == "La D&eacutefense" || $terminus == "&Eacutetoile"){
		return true;
	}
	if ($terminus == "Cr&eacuteteil" || $terminus == "Pont de S&egravevres" || $terminus == "Ch&acirctelet"){
		return true;
	}
	if ($terminus == "Asni&egraveres</br>Gennevilliers" || $terminus == "Ch&acirctillon"){
		return true;
	}
}



function veilledefete()
{
	if (date('d') == "01" && date('m') == "01")
		return 1;
	if (date('d') == "01" && date('m') == "05")
		return 1;
	if (date('d') == "08" && date('m') == "05")
		return 1;
	if (date('d') == "14" && date('m') == "07")
		return 1;
	if (date('d') == "15" && date('m') == "08")
		return 1;
	if (date('d') == "01" && date('m') == "11")
		return 1;
	if (date('d') == "25" && date('m') == "12")
		return 1;
	return 0;
}



function servicetermine($hours, $minutes){
	if (date('l') == "Saturday" || date('l') == "Sunday" || veilledefete() == 1){
		if ($hours >= 2 && $hours < 5)
			return 1;
	}
	else{
		if ($hours >= 1 && $hours < 5)
			return 1;
	}
	return 0;
}



function handleaction($action){
	if ($action == "audio_off"){
		$_SESSION['audio'] = "off";
	}
	if ($action == "audio_on"){
		$_SESSION['audio'] = "on";
	}
	if ($action == "changeline"){
		$_SESSION['station'] = null;
	}
}
?>