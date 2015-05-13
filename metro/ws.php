<?php
include_once 'functions.php';

if (!isset($_SESSION['audio'])){
	$_SESSION['audio'] = "on";				// INITIALISATION
	$_SESSION['audio_trigger'] = "off";
}
if (!isset($_SESSION['line']))
	$_SESSION['line'] = 0;					// INITIALISATION
if (!isset($_SESSION['color']))
	$_SESSION['color'] = "";				// INITIALISATION
if (!isset($_SESSION['display']))
	$_SESSION['display'] = 2;				// INITIALISATION
if (!isset($_SESSION['mode']))
	$_SESSION['mode'] = "normal";			// INITIALISATION
if (!isset($_SESSION['test']))
	$_SESSION['test'] = "yes";				// INITIALISATION
if (!isset($_SESSION['teststatus']))
	$_SESSION['teststatus'] = "";			// INITIALISATION
if (!isset($_SESSION['resetstatus']))
	$_SESSION['resetstatus'] = 0;			// INITIALISATION


define("ANIMATE", " style='animation: blink1 2s infinite;'>", true); //  DEFINITION


if (isset ($_GET['display']))
	$_SESSION['display'] = $_GET['display'];
if (isset($_GET['mode']))
{
	if ($_GET['mode'] == "tests")
		$_SESSION['mode'] = "tests";
	else if ($_GET['mode'] == "debug")
		$_SESSION['mode'] = "debug";
}


if (isset ($_GET['line'])){
	$_SESSION['line'] = $_GET['line'];				// RECUPERATION DE L'HABILLAGE LIGNE
	$_SESSION['color'] = getlinecolor($_GET['line']);
}
else if (!isset($_SESSION['line'])){
	$_SESSION['line'] = 0;
	$_SESSION['color'] = "";
}


if (isset($_GET['track']))
	$_SESSION['track'] = $_GET['track'];				// RECUPERATION DE LA VOIE

else if (!isset($_SESSION['track']))
	$_SESSION['track'] = null;

if (isset($_SESSION['track']) && $_SESSION['track'] != null)		// RECUPERATION DU TERMINUS
	$_SESSION['terminus'] = findterminus($_SESSION['line'], $_SESSION['track']);

else
	$_SESSION['terminus'] = "";


				// MODE NORMAL					MODE NORMAL							MODE NORMAL

if ((isset ($_GET['station'])))
	$_SESSION['station'] = $_GET['station'];

else if (!isset($_SESSION['station']))
	$_SESSION['station'] = "";

?>