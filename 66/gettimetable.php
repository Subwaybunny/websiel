<?php
session_start();

include_once 'functions.php';


$url = prepare_request();
	if (isset($url)){
	libxml_use_internal_errors(true);
	
	$curlResult = get_timetable($url);					// RECUP PAGE SUR RATP.FR

	$rawstring = trimwebsource('tbody', $curlResult); 	// RECUP TABLEAU HORAIRES
	$rawstring = process_rawstring($rawstring, 1);			// TRIM LA STRING
	$timetable = explode(",", $rawstring);				// MISE EN TABLEAU
	
	if (isset($timetable[0])){
		$terminus1 = check_terminus($timetable[0]);
		$timetable[0] = process_rawstring($timetable[0], 2);
	}
	if (isset($timetable[1])){
		$terminus2 = check_terminus($timetable[1]);
		$timetable[1] = process_rawstring($timetable[1], 2);
	}
	//echo "Terminus 1: " . $terminus1 . "</br>Terminus 2: " . $terminus2 . "</br></br>";
	
	
	for ($i = 0; $i < 2; $i++){
		if (isset($timetable[$i]) && $timetable[$i] != "")
			$timetable[$i] = sprintf("%02s", $timetable[$i]);
		else {
			/*if (servicetermine($hours, $minutes) == 1)
				$timetable[$i] = "XX";					// AFFICHE XX SI SERVICE TERMINE
			else*/
				$timetable[$i] = "..";
		}
	}
	//print_r($timetable);
	$timetable[0] = sprintf("%02s", $timetable[0]);
	$timetable[1] = sprintf("%02s", $timetable[1]);
	
	$first = $timetable[0];			// ATTRIB VALEUR 1er TRAIN
	
	$sec = $timetable[1];			// ATTRIB VALEUR 2e TRAIN
}
	
elseif ($first == null)
	$first = "..";					// CHANGE VALEUR 1er TRAIN
if (!isset($sec))
	$sec = "..";					// CHANGE VALEUR 2e TRAIM
elseif ($sec == null)
	$sec = "..";					// CHANGE VALEUR 2e TRAIN
	if ($first == "TQ")
	$first = "0";						// FIN DE CLIGNOTEMENT - TRAIN A QUAI

	if (!isset ($_GET['pfirst']) || $_GET['pfirst'] == NULL)
	$pfirst = NULL;
else
	$pfirst = $_GET['pfirst'];
if (!isset ($_GET['psec']) || $_GET['psec'] == NULL)
	$psec = NULL;
else
	$psec = $_GET['psec'];

	if (!check_valid_time($first))
	$first = "..";

if (!check_valid_time($sec))
	$sec = "..";


if (isset($terminus2))
	echo $terminus1."//".$terminus2."//".$first."//".$sec;
else
	echo $terminus1."//..//".$first."//".$sec;

?>