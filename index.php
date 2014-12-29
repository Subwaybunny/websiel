<?php

session_start();

include_once 'ws.php';

if ((isset ($_GET['action']))){
	handleaction($_GET['action']);
}
if ($_SESSION['audio'] == "off"){
	$_SESSION['audio_trigger'] = "on";
}
if ($_SESSION['audio'] == "on"){
	$_SESSION['audio_trigger'] = "off";
}

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
if (window.location.pathname == '/index.php') {
	var voicebuffer = null;
	var alreadyone = false;
	var currentfirst = null;
	var currentsec = null;
	var buff_first = 0;
	var buff_sec = 0;
	var blinking1 = false;
	var blinking2 = false;
	var stopblink1 = false;
	var stopblink2 = false;
	var pfirst = 99;
	var psec = 99;

	$(document).ready(function(){
		refresh_SIEL();
	});

	setInterval(function(){
		refresh_SIEL();
	}, 20000);


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
		var str = "pfirst="+currentfirst+"&psec="+currentsec;
		xhr.open("GET", url+"?"+str, true);
		xhr.onreadystatechange = refpage;
		xhr.send();
	}

	function refpage(){
		if(xhr.readyState == 4 && xhr.status == 200) {
			var next_trains = xhr.responseText;
			var first;
			var sec;
			stopblink1 = false;
			stopblink2 = false;
			first = next_trains.substring(0, 2);
			sec = next_trains.substring(4, 6);
			third = next_trains.substring(8, 10);
			fourth = next_trains.substring(12, 14);
			hours = next_trains.substring(16, 18);
			minutes = next_trains.substring(20, 22);
			pfirst = next_trains.substring(24, 26);
			psec = next_trains.substring(28, 30)
			currentfirst = first;
			currentsec = sec;

			if (first != "01")
				alreadyone = false;
			if (first == "TA" || (first == "00" && pfirst == "01")){
				$('#first').attr('style', 'animation: blink1 2s infinite;');
				$('#first').html("00");
			}
			else {
				$('#first').html(first);
				$('#first').removeAttr('style');
			}
			if (sec == "TA" || (sec == "00" && psec == "01")){
				$('#sec').attr('style', 'animation: blink1 2s infinite;');
				$('#sec').html("00");
			}
			else {
				$('#sec').html(sec);
				$('#sec').removeAttr('style');
			}
			$('#clock1').html(hours);
			$('#clock2').html(minutes);

		<?php if ($_SESSION['audio'] == "on"){ ?>
			announcements(first, sec);
		<?php } ?>
		
			if (islate1(first) == 1){
				if (blinking1 == false && currentfirst != "TA" && currentfirst != "00")
					blinkplus1();
			}
			else{
				stopblink1 = true;
				blinking1 = false;
			}
			if (islate2(first, sec) == 1){
				if (blinking2 == false && currentsec != "TA")
					blinkplus2();
			}
			else{
				stopblink2 = true;
				blinking2 = false;
			}
		<?php if ($_SESSION['display'] == 4){?>
			$('#third').html(third);
			$('#fourth').html(fourth);
		<?php } ?>
		}
	}

	function islate1(first){
		if (buff_first == 6 && first == pfirst)
			return 1;
		if (first == pfirst && first != ".." && first != "##" && first != "XX" && first != "--")
			buff_first += 1;
		else
			buff_first = 0;
		if (first >= "20" && first != ".." && first != "##" && first != "XX" && first != "--")
			return 1;
		return 0;
	}

	function islate2(first, sec){
		if (sec == first && sec != ".." && sec != "##" && sec != "XX" && sec != "--")
			return 1;
		if (buff_sec == 6 && sec == psec)
			return 1;
		if (sec == psec && sec != ".." && sec != "##" && sec != "XX" && sec != "--")
			buff_sec += 1;
		else
			buff_sec = 0;
		return 0;
	}

	function announcements(first, sec){
		if (first == "01"){
			if (alreadyone == false){
				var audiofile = 'audio/<?php echo $_SESSION['line'];?>/<?php echo $_SESSION['track'];?>/'+first+'-'+sec+'.mp3';
				$.ajax({
					url: audiofile,
					error: function(){
						var audio = new Audio('audio/<?php echo $_SESSION['line'];?>/<?php echo $_SESSION['track'];?>/01.mp3');
						audio.play();
						alreadyone = true;
					}
				})
				alreadyone = true;
			}
		}
		else if (first == "04" || first == "07")
			var audiofile = 'audio/<?php echo $_SESSION['line'];?>/<?php echo $_SESSION['track'];?>//'+first+'.mp3';
		if (audiofile != voicebuffer){
			var audio = new Audio(audiofile);
			audio.play();
			voicebuffer = audiofile;
		}
	}
}
</script>

<title>
WebSiel
</title>
<link rel="stylesheet" href="style.css" />
</head>

<body>
<?php
if (isset($_SESSION['line']) || isset($_SESSION['track']) || isset($_SESSION['station'])){
?>
<form method="post" action="reset.php">
<span style="position:absolute;left:100px;padding:0;margin:0;">
<?php if ($_SESSION['line'] != "" && $_SESSION['track'] != "" && $_SESSION['station'] == "NOPE"){ ?>
<input type="checkbox" name="re" value="re">Retour automatique</input>
<?php } ?>
</span>
<button id="reset" onclick="this.form.submit();"<?php if ($_SESSION['mode'] == "debug"){ ?> style="top:200px;"<?php } ?>>RESET</button>
</form>
<?php } ?>
<div id="audiocontrol" onclick="window.location.href = 'index.php?action=audio_<?php echo $_SESSION['audio_trigger'];?>';" style="background-image:url(img/audio_<?php echo $_SESSION['audio'];?>.jpg);"></div>
<?php if ($_SESSION['station'] != ""){ ?>
<div id="stationsigncontainer">
<table style="margin-left:auto; margin-right:auto; border-collapse:collapse;" cellpadding="0" cellspacing="0">
<tr>
<td>
<div id="stationsign" style="padding-bottom:20px;padding-top:20px;color:#FFFFFF;">
<?php echo $_SESSION['station']."
</div>
</td>
</tr>
</table>
</div>";}?>


					<!-- DEBUT AFFICHEUR SIEL -->


<div id="siel"<?php if ($_SESSION['display'] == 4){echo " style='height:350px;'";}?>>
<div id="line">
	<img src="img/m.png" height=100, width=auto style="padding-right:10px;"><?php if (isset($_SESSION['line']) && $_SESSION['line'] != 0){?><img src="img/<?php echo $_SESSION['line'];?>.png" height=100, width=auto><?php } ?>
</div>
<table id="clock">
	<tr id="clock0">
		<td id="clock1" class="clockdigit" style="padding-right:0.2em;"></td>
		<td id="clock2" class="clockdigit" style="padding-left:0.2em;"></td>
	</tr>
</table>
<div>
	<span class="trains" style="left:345px;">1<sup>er</sup> train</span>
	<span class="trains" style="left:510px;">2<sup>e</sup> train</span>
</div>
<hr>
<div id="direction" style="font-size:<?php echo terminussize($_SESSION['terminus'])?>em;"><?php echo $_SESSION['terminus']; ?></div>
<table id="nextserv">
	<tr style="position:absolute;top:155px;">
					<!-- DEBUT TEMPS D'ATTENTE -->


		<td id="first"<?php if ($_SESSION['line'] == 14){ echo ANIMATE; } else{ echo ">"; }?></td>
		<td class="min" style="left:425px;"><span style="position:absolute;bottom:0;margin-bottom:-5px;">min</td>

		<td id="sec"<?php if ($_SESSION['line'] == 14){ echo ANIMATE; } else{ echo ">"; }?></td>	
		<td class="min" style="left:585px;"><span style="position:absolute;bottom:0;margin-bottom:-5px;">min</td>
	</tr>
	<?php if ($_SESSION['display'] == 4){?>


					<!-- DEUXIEME LIGNE -->


	<tr style="position:absolute;top:230px;">
		<td id="third"<?php if ($_SESSION['line'] == 14){ echo ANIMATE; } else{ echo ">"; }?></td>
		<td class="min" style="left:425px;"><span style="position:absolute;bottom:0;margin-bottom:-5px;">min</td>

		<td id="fourth"<?php if ($_SESSION['line'] == 14){ echo ANIMATE; } else{ echo ">"; }?></td>	
		<td class="min" style="left:585px;"><span style="position:absolute;bottom:0;margin-bottom:-5px;">min</td>
	</tr>
	<?php } ?>
					<!-- FIN TEMPS D'ATTENTE -->


</table>
<div id="bordereau" style="background-color:#<?php echo $_SESSION['color'];?>;"><em><?php echo $_SESSION['teststatus']; ?></em></div>
<?php if ($_SESSION['line'] > 6 || $_SESSION['line'] == "7b"){?>
<div id="reg"></div>
<?php } ?>
<div id="logo"></div>
</div>


					<!-- FIN AFFICHEUR SIEL -->


<div id="sieloverlay"></div>
<div id="userpanelcontainer">
	<div id="userpanel">
		<div id="linecontainer">
			<?php include_once 'lists/linelogos.php'; ?>
			<span style="position:absolute;top:0;font-family:parisine;margin-top:-1.2em;margin-left:15px;"><em>1 - LIGNE</em></span>
		</div>
		<div id="directioncontainer">
			<button <?php if(!isset($_SESSION['line']) || $_SESSION['line'] == ""){echo "disabled ";}?>id="dir1" onclick="window.location.href = 'index.php?action=changedir&track=1';"><?php if (isset($_SESSION['line'])){echo findterminus($_SESSION['line'], 1);}?></button></br>
			<button <?php if(!isset($_SESSION['line']) || $_SESSION['line'] == ""){echo "disabled ";}?>id="dir2" onclick="window.location.href = 'index.php?action=changedir&track=2';"><?php if (isset($_SESSION['line'])){echo findterminus($_SESSION['line'], 2);}?></button></br>
			<span style="position:absolute;top:0;font-family:parisine;margin-top:-1.2em;margin-left:15px;"><em>2 - DIRECTION</em></span>
		</div>
		<div id="stationcontainer">
			<span style="position:absolute;top:0;font-family:parisine;margin-top:-1.2em;margin-left:15px;"><em>3 - STATION</em></span>
		<?php if ($_SESSION['line'] >= 1 && $_SESSION['line'] <= 5 || $_SESSION['line'] == 6 || $_SESSION['line'] == "3b"){
			include_once 'lists/'.$_SESSION['line'].'.php';
		}?>
		</div>
	</div>
</div>
</body>
</html>