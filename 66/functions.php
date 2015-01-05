<?php

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

function process_rawstring($rawstring, $stage)
{
	if ($stage == 1)
	{
		$rawstring = preg_replace("/(?:\s|&nbsp;)/", "", $rawstring);
		$rawstring = preg_replace("/mn/", ",", $rawstring);
	}
	if ($stage == 2)
	{
		$rawstring = preg_replace("/Al'arret/", "0", $rawstring);
		$rawstring = preg_replace("/Opera/", "", $rawstring);
		$rawstring = preg_replace("/Saint-Lazare/", "", $rawstring);
	}
	return $rawstring;
}

function prepare_request(){
	$request = "http://www.ratp.fr/horaires/fr/ratp/bus/prochains_passages/PP/B66/66_621_645/A";
	return $request;
}


function check_terminus($string){
	if (strpos($string,'Opera') !== false)
		$terminus = "O";
	else if (strpos($string,'Saint-Lazare') !== false)
		$terminus = "S";
	else if (strpos($string,'DERNIERPASSAGE') !== false)
		$terminus = "D";
	else if (strpos($string,'PREMIERPASSAGE') !== false)
		$terminus = "P";
	else if (strpos($string,'SERVICETERMINE') !== false)
		$terminus = "T";
	else if (strpos($string,'SERVICENONCOMMENCE') !== false)
		$terminus = "N";
	else
		$terminus = "I";
	return $terminus;
}

function check_valid_time($sieltime){
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
?>