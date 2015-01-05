<?php
if (isset($_SESSION['line']))
	session_destroy();
session_start();

//include_once 'gettimetable.php';
?>

<!doctype html>
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

var xhr=null;
if (window.XMLHttpRequest){
	xhr=new XMLHttpRequest();
}
else if (window.ActiveXObject){
	xhr=new ActiveXObject("Microsoft.XMLHTTP");
	alert("Vous utilisez Internet Explorer 5 ou 6. C'est pas joli joli.");
}
else {
	alert("AJAX error.");
}
function refresh_SIEL() {
	var url = "gettimetable.php";
	//var str = "pfirst="+currentfirst+"&psec="+currentsec;
	xhr.open("GET", url, true);
	xhr.onreadystatechange = refpage;
	xhr.send();
}

function refpage(){
	if(xhr.readyState == 4 && xhr.status == 200) {
		var next_trains = xhr.responseText;
		var first;
		var sec;
		currentfirst = first;
		currentsec = sec;
		stopblink1 = false;
		stopblink2 = false;
		terminus1 = next_trains.substring(0, 1);
		terminus2 = next_trains.substring(3, 4);
		first = next_trains.substring(6, 8);
		sec = next_trains.substring(10, 12);
		if (first.substring(0, 1) == "0")
			first = first.substring(1, 2);
		$('#wait1').html(first);
		if (sec.substring(0, 1) == "0")
			sec = sec.substring(1, 2);
		$('#wait2').html(sec);
		if (terminus1 == "O")
			$('#terminus1').html("OPERA");
		else if (terminus1 == "S")
			$('#terminus1').html("SAINT-LAZARE");
		else
			$('#terminus1').html("INFO INDISPO");
			
		if (terminus2 == "O")
			$('#terminus2').html("OPERA");
		else if (terminus2 == "S")
			$('#terminus2').html("SAINT-LAZARE");
		else if (terminus2 == "D"){
			$('#terminus2').html("DERNIER PASSAGE");
			$('#wait2').html("");
			}
		else if (terminus2 == "P"){
			$('#terminus2').html("PREMIER PASSAGE");
			$('#wait2').html("");
		}
		else
			$('#terminus2').html("INFO INDISPO");
	}
	if (terminus1 == "T"){
		$('#terminus2').html("&nbspSERVICE TERMINE");
		$('#terminus1').html("");
		$('#wait1').html("");
		$('#wait2').html("");
	}
	if (terminus1 == "N"){
		$('#terminus1').html("&nbsp&nbsp&nbsp&nbsp&nbspSERVICE");
		$('#terminus2').html("&nbsp&nbspNON COMMENCE");
		$('#wait1').html("");
		$('#wait2').html("");
	}
		
	if (first == "7"){
		$('#terminus1').removeAttr('style');
		$('#wait1').removeAttr('style');
		$('#terminus1').attr('style', 'color:red;');
		$('#wait1').attr('style', 'color:red;');
		var audio = new Audio('sound1.mp3');
		audio.play();
	}
	else if (first == "6"){
		$('#terminus1').removeAttr('style');
		$('#wait1').removeAttr('style');
		$('#terminus1').attr('style', 'animation: blink1 1s infinite;');
		$('#wait1').attr('style', 'animation: blink1 1s infinite;');
		var audio = new Audio('sound2.mp3');
		audio.play();
	}
	else{
		$('#terminus1').removeAttr('style');
		$('#wait1').removeAttr('style');
	}
	
	if (sec == "7"){
		$('#terminus2').removeAttr('style');
		$('#wait2').removeAttr('style');
		$('#terminus2').attr('style', 'color:red;');
		$('#wait2').attr('style', 'color:red;');
		var audio = new Audio('sound1.mp3');
		audio.play();
	}
	else if (sec == "6"){
		$('#terminus2').removeAttr('style');
		$('#wait2').removeAttr('style');
		$('#terminus2').attr('style', 'animation: blink1 1s infinite;');
		$('#wait2').attr('style', 'animation: blink1 1s infinite;');
		var audio = new Audio('sound2.mp3');
		audio.play();
	}
	else{
		$('#terminus2').removeAttr('style');
		$('#wait2').removeAttr('style');
	}
	
	console.log(first);
	console.log(sec);
	if (!isNaN(first))
		document.title = first+" minutes - Websiel";
}
</script>

<title>
WebSiel
</title>
<link rel="stylesheet" href="style.css" />
</head>

<body>


					<!-- DEBUT AFFICHEUR SIEL -->
<div id="maincontainer">
<div id="sepline"></div>
<table><tr><td class="titles" style="left:180px;">Ligne</td><td class="titles" style="left:430px;">Destination</td><td class="titles" style="right:180px;">Temps d'attente</td></tr></table>
<table><tr><td class="display" id="linedisplay"><span style="position:absolute; margin-top:-20px;">66</span></td></tr>
					<!-- DEBUT TEMPS D'ATTENTE -->
<tr>
<td class="display waitdisplay" id="firstbus" style="top:72px;"><span style="position:absolute; margin-top:-20px;">
<span id="terminus1">INFO INDISPO.</span>
</span>
<span id="wait1"></span></td>

					<!-- DEUXIEME LIGNE -->

<td class="display waitdisplay" id="secbus" style="top:192px;"><span style="position:absolute; margin-top:-20px;">
<span id="terminus2">INFO INDISPO.</span>
</span>
<span id="wait2"></span></td>
</tr>
<tr>
<td class="min" style="top:80px;">min</td>
<td class="min" style="top:200px;">min</td>
</tr>
</table>
<!--div class="display" id="linedisplay"><span style="position:absolute; margin-top:-20px;">66</span></div>-->

					<!-- FIN TEMPS D'ATTENTE -->
<div id="bordereau">
<div id="logo"><span style="font-family:Tahoma;">Web</br></span><span style="font-family:parisine;">&nbsp&nbspsiel</span></div>
<table id="slots"><tr>
<td class="lineslot" id="sixsix">66</td>
<td class="lineslot" style="margin-left:190px;"></td>
<td class="lineslot" style="margin-left:380px;"></td>
<td class="lineslot" style="margin-left:570px;"></td>
<td class="lineslot" style="margin-left:760px;"></td></tr></table>
</div>
					<!-- FIN AFFICHEUR SIEL -->
</div>
</body>
</html>