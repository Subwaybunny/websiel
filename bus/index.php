<?php
if (isset($_SESSION['line']))
	session_destroy();
session_start();
if (!isset($_COOKIE['myline']))
{
	header('Location: menu.php');
	exit();
}

?>

<!doctype html>
<meta charset="UTF-8" />
<!--
   ..:;.     .;.      .::.               .oxc.
   .OMWo    .OWO.   .oNMK,               lWMx.
    dWMk.  .OWMX:  .dNMK,     .....     .kMWo....                 ....                  ....
    cNM0' ,OWMMWo .xWM0,   'lk0KKKKOo.  ;XMWXKKX0x;              .KWWd.                 lKXd.
    ,KMN:,0MXXWMk,dWM0,  .dNWx   lKMWl  oWMKl;;dXMNo.             ....                  dMMk.
    .kMW0KMK  KMNXWM0,  .dWMWOccokNW0, .OMNc    lWMK,  ,ldxxxd;  'lxx;    .;oxxxxdl'    dMMk.
     oWMMMK   xMMMWO'   ,KMWKO00Okd:.  :XM0'    oWMO  dNWKxxk0c  '0MMo   ,OWNkoldKWNo.  dMMk.
     ;XMM0    lWMWO'    .OMWx'        .dWWx.  .dNMK;  KMWk       '0MWo  'OMWO    dNMNc  dMMk.
     .OM0     '0MO'      ,OWWKkk0Xl   :XMMNOxOXWKd'   oXWMWXOd'  '0MWo  ;XMWXKKKKKKKK:  dMMk.
      'l       'c'        .,loool:.   ;oc:coooc,.        lx0WMK, '0MWo  ,KMWx'          dMMk.
                                                      ;.,,,dNMX; '0MWo   oNMNkc:;;co    dMMk.
                                                     'ONNNNNXk;  .xXKc    :xKNWWWWWNx.  lXXd.
-->
<html>
<head>
<link rel="icon" type="image/png" href="img/favicon.png" />
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="siel.js"></script>

<script>
var currentfirst;
var currentsec;
var blinking1 = false;
var blinking2 = false;
var stopblink1 = false;
var stopblink2 = false;
$(document).ready(function(){
	refresh_SIEL();
});

setInterval(function(){
	refresh_SIEL();
}, 30000);

function refresh_SIEL() {
	$.ajax({
		type: "GET",
		dataType: "json",
		url: "gettimetable.php?next=<?php echo $_COOKIE['myline'] ?>",
		cache: false,
		success: refpage
	});
}

function refpage(data){
	var first;
	var sec;
	currentfirst = first;
	currentsec = sec;
	stopblink1 = false;
	stopblink2 = false;
	line = data[0];
	terminus1 = data[1];
	terminus2 = data[2];
	first = data[3];
	sec = data[4];
	if (line){
		$('#cline').html(line);
		$.ajax({
			type: "GET",
			url: "getcolor.php?line="+line,
			cache: false,
			success: function(data){
				$('#currentline').removeAttr("class");
				$('#currentline').attr("class", "lineslot "+data);
				$('#currentline').html(line);
			}
		});
	}
	if (first.substring(0, 1) == "0")
		first = first.substring(1, 2);
	$('#wait1').html(first);
	if (sec.substring(0, 1) == "0")
		sec = sec.substring(1, 2);
	$('#wait2').html(sec);
	if (terminus1)
		$('#terminus1').html(terminus1);
	else {
		$('#terminus1').html("INFO INDISPO.");
		$('#wait1').html("");
	}
		
	if (terminus2)
		if (terminus2.substring(8, 15) == "PASSAGE")
			$('#terminus2').html("&nbsp"+terminus2);
		else
			$('#terminus2').html(terminus2);
	else {
		$('#terminus2').html("INFO INDISPO.");
		$('#wait2').html("");
	}
	
	if (terminus2 == "T"){
		$('#terminus2').html("&nbspSERVICE TERMINE");
		$('#terminus1').html("");
		$('#wait1').html("");
		$('#wait2').html("");
	}
	if (terminus2 == "NC"){
		$('#terminus1').html("&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSERVICE");
		$('#terminus2').html("&nbsp&nbsp&nbspNON COMMENCE");
		$('#wait1').html("");
		$('#wait2').html("");
	}
	if (terminus2 == "PDS"){
		$('#terminus1').html("");
		$('#terminus2').html("&nbsp&nbspPAS DE SERVICE");
		$('#wait1').html("");
		$('#wait2').html("");
	}

	if (!isNaN(first))
		document.title = first+" minutes - Websiel";
	var d = new Date();
	d = d.getHours();
	if (d < 6 || d > 21)
		$('#style').attr("href","nightstyle.css");
	else
		$('#style').attr("href","style.css");
}
</script>

<title>
WebSiel
</title>
<link id="style" rel="stylesheet" href="style.css" />
</head>

<body>
<input type="button" value="Retour au Menu" style="z-index:-1" onclick="window.location.replace('menu.php')">

					<!-- DEBUT AFFICHEUR SIEL -->
<div id="mcoverlay"></div>
<div id="maincontainer">
<div id="sepline"></div>
<table><tr><td class="titles" style="left:180px;">Ligne</td><td class="titles" style="left:430px;">Destination</td><td class="titles" style="right:180px;">Temps d'attente</td></tr></table>
<table><tr><td class="display" id="linedisplay"><span id="cline" class="adjust"></span></td></tr>
					<!-- DEBUT TEMPS D'ATTENTE -->
<tr>
<td class="display waitdisplay" id="firstbus" style="top:72px;"><span class="adjust">
<span id="terminus1">INFO INDISPO.</span>
</span>
<span id="wait1"></span></td>

					<!-- DEUXIEME LIGNE -->

<td class="display waitdisplay" id="secbus" style="top:192px;"><span class="adjust">
<span id="terminus2">INFO INDISPO.</span>
</span>
<span id="wait2"></span></td>
</tr>
<tr>
<td class="min" style="top:80px;">min</td>
<td class="min" style="top:200px;">min</td>
</tr>
</table>

					<!-- FIN TEMPS D'ATTENTE -->
<div id="bordereau">
<div id="logo"><span style="font-family:Tahoma;">Web</br></span><span style="font-family:typeface1;">&nbspsiel</span></div>
<table id="slots"><tr>
<td class="lineslot" id="currentline"></td>
<td class="lineslot" style="margin-left:190px;"></td>
<td class="lineslot" style="margin-left:380px;"></td>
<td class="lineslot" style="margin-left:570px;"></td>
<td class="lineslot" style="margin-left:760px;"></td></tr></table>
</div>
					<!-- FIN AFFICHEUR SIEL -->
</div>
</body>
</html>
