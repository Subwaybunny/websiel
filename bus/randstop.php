<?php
include_once('getstop.php');
date_default_timezone_set('Europe/Paris');

randname();

function randname()
{
	$now = date('G');
	
	if ($now >= 6 && $now <= 23)	// BUS DE JOUR
		$gen = rand(0, 59);
	else if ($now >= 1 && $now <= 4)// NOCTILIEN
		$gen = rand(60, 89);
	else if ($now == 0 || $now == 5)// MIXTE
		$gen = rand(0, 89);
	echo getstop($gen);
}
?>