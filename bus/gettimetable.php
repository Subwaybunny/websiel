<?php
session_start();
date_default_timezone_set('Europe/Paris');

include_once 'functions.php';
if (!empty($_GET['next']))
	$url = prepare_request($_GET['next']);

if (isset($url)){
	$line = explode("/", $url);
	$line = substr($line[9], 1);
	libxml_use_internal_errors(true);
	$exception = 0;
	
	$curlResult = get_timetable($url);					// RECUP PAGE SUR RATP.FR

	$rawstring = trimwebsource('tbody', $curlResult); 	// RECUP TABLEAU HORAIRES
	
	if (strpos($rawstring,"A l'approche") !== false || strpos($rawstring,"A l'arret") !== false)
		$exception = 1; 									// CORRECTION DU BUG "A l'approche / A l'arret"
	else if (strpos($rawstring,'TERMINE') !== false)
		$exception = 2;
	else if (strpos($rawstring,'COMMENCE') !== false)
		$exception = 3;
	else if (strpos($rawstring,'PAS DE SERVICE') !== false)
		$exception = 4;
	$rawstring = preg_replace("/mn|A l'approche|A l'arret/", ",", $rawstring);	// PREPARE LE TABLEAU
	$timetable = explode(",", $rawstring);				// MISE EN TABLEAU
	
	if (isset($timetable[0]))
	{
		$terminus1 = trim(process_rawstring($timetable[0], 1));
		$timetable[0] = trim(process_rawstring($timetable[0], 2));
	}
	if (isset($timetable[1]))
	{
		$terminus2 = process_rawstring($timetable[1], 1);
		$timetable[1] = process_rawstring($timetable[1], 2);
	}
	
	for ($i = 0; $i < 2; $i++)
		if (!empty($timetable[$i]))
			$timetable[$i] = sprintf("%02s", $timetable[$i]);
		else
			$timetable[$i] = "  ";

	$timetable[0] = sprintf("%02s", $timetable[0]);
	$timetable[1] = sprintf("%02s", $timetable[1]);

	
	$first = trim($timetable[0]);			// ATTRIB VALEUR 1er BUS
	$sec = trim($timetable[1]);			// ATTRIB VALEUR 2e BUS
}

switch ($exception)
{
	case 1:
		$first = "00";
		break;
	case 2:
		$terminus1 = "S";
		$terminus2 = "T";
		break;
	case 3:
		$terminus1 = "S";
		$terminus2 = "NC";
		break;
	case 4:
		$terminus1 = "";
		$terminus2 = "PDS";
		break;
}

if (!empty($terminus1))
{
	$terminus1 = trim($terminus1);
	if (strlen($terminus1) > 15)
		$terminus1 = process_rawstring($terminus1, 3);
}
else
	$terminus1 = "";
if (!empty($terminus2))
{
	$terminus2 = trim($terminus2);
	if (strlen($terminus2) > 15  && $rawstring != "PREMIER PASSAGE" && $rawstring != "DERNIER PASSAGE" && $rawstring != "PAS DE SERVICE")
		$terminus2 = process_rawstring($terminus2, 3);
}
else
	$terminus2 = "";

$ret = array($line, $terminus1, $terminus2, $first, $sec);
echo json_encode($ret);
?>
