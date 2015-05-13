<?php
session_start();
date_default_timezone_set('Europe/Paris');

include_once 'functions.php';

if (!isset($_SESSION['line']))
	$_SESSION['line'] = 0;					// INITIALISATION

if (!isset($_SESSION['mode']))
	$_SESSION['mode'] = "normal";			// INITIALISATION



define ("TZCORRECT", 0);					// TIMEZONE


$hours = date('H') + TZCORRECT;			// TIMEZONE SERVEUR
if ($hours > 23)
	$hours = sprintf("%02s", $hours - 24); // CORRECTION > 24h

else
	$hours = sprintf("%02s", $hours);	// PREPEND UN 0
	
$minutes = sprintf("%02s", date('i'));

if ($_SESSION['mode'] != "tests")
{
	if (isset($_SESSION['line']) && isset($_SESSION['track']) && isset($_SESSION['station']))
		$url = prepare_request($_SESSION['line'], $_SESSION['track'], $_SESSION['station']);

	if (isset($url))
	{
		libxml_use_internal_errors(true);
		
		$curlResult = get_timetable($url);					// RECUP PAGE SUR RATP.FR



		$rawstring = trimwebsource('tbody', $curlResult); 	// RECUP TABLEAU HORAIRES
		$rawstring = process_rawstring($rawstring);			// TRIM LA STRING
		$timetable = explode(",", $rawstring);				// MISE EN TABLEAU

		$maxtrains = 2;					//
		if (isset($timetable[2]))		//
			$maxtrains = 3;				//	CORRECTIF POUR ELEMENTS VIDES
		if (isset($timetable[3]))		//		( BUGS NOCTURNES )
			$maxtrains = 4;				//

		for ($i = 0; $i < $maxtrains; $i++)
		{
			if (isset($timetable[$i]) && $timetable[$i] != "")
				$timetable[$i] = sprintf("%02s", $timetable[$i]);
			else
			{
				if (servicetermine($hours, $minutes) == true)
					$timetable[$i] = "XX";					// AFFICHE XX SI SERVICE TERMINE
				else
					$timetable[$i] = "..";
			}
		}
		
		$first = $timetable[0];			// ATTRIB VALEUR 1er TRAIN
		
		$sec = $timetable[1];			// ATTRIB VALEUR 2e TRAIN
		
		if ($maxtrains >= 3)
			$third = $timetable[2];		// ATTRIB VALEUR 3e TRAIN
		else
			$third = "XX";				// VAL ALTERNATIVE 3e TRAIN
		if ($maxtrains == 4)
			$fourth = $timetable[3];	// ATTRIB VALEUR 4e TRAIN
		else
			$fourth = "XX";				// VAL ALTERNATIVE 4e TRAIN

		if ($first == "XX" && $sec == "XX" && $fourth =="XX")
			$third = "XX";				// CHANGE VALEUR 3e TRAIN
	}

	if (!isset($first))
		$first = "##";					// CHANGE VALEUR 1er TRAIN
		
	else if ($first == null)
		$first = "..";					// CHANGE VALEUR 1er TRAIN
	if (!isset($sec))
		$sec = "##";					// CHANGE VALEUR 2e TRAIM
	else if ($sec == null)
		$sec = "..";					// CHANGE VALEUR 2e TRAIN

	if ($first == "TQ")
	{
		$_SESSION['status'] = "TQ";
		$first = "00";						// FIN DE CLIGNOTEMENT - TRAIN A QUAI
	}



	if (!isset ($_GET['pfirst']) || $_GET['pfirst'] == NULL)
		$pfirst = NULL;
	else
		$pfirst = $_GET['pfirst'];
	if (!isset ($_GET['psec']) || $_GET['psec'] == NULL)
		$psec = NULL;
	else
		$psec = $_GET['psec'];

	if ($_SESSION['line'] > 6 && $_SESSION['line'] != 14 && $_SESSION['line'] != "3b"){
		$first = "..";
		$sec = "..";						// NEUTRALISATION DE L'AFFICHAGE
		$third = "..";						//    DES LIGNES INDISPONIBLES
		$fourth = "..";
	}
	if ($_SESSION['line'] == 14){
		$first = "--";
		$sec = "--";						// NEUTRALISATION DE L'AFFICHAGE
		$third = "--";						//    DES LIGNES INDISPONIBLES
		$fourth = "--";
	}

	if (!check_valid_time($first))
		$first = "..";


	if (!check_valid_time($sec))
		$sec = "..";

		if (!isset($third)){$third = "..";}
		if (!isset($fourth)){$fourth = "..";}

	if (!check_valid_time($third))
		$third = "..";
	$fourth = preg_replace('/\s+/', '', $fourth);
	if (!check_valid_time($fourth))
		$fourth = "..";
}				//  FIN MODE NORMAL					FIN MODE NORMAL				FIN MODE NORMAL

				//  MODE TESTS					MODE TESTS					MODE TESTS
else if ($_SESSION['mode'] == "tests")
{
	if (isset($_GET['first']))
		$first = $_GET['first'];
	if (isset($_GET['sec']))
		$sec = $_GET['sec'];
}

echo $first."//".$sec."//".$third."//".$fourth."//".$hours."//".$minutes."//".$pfirst."//".$psec;

?>