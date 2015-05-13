var blinkstate1 = false;
var blinkstate2 = false;

function blinkplus1(){
	if (stopblink1 == false){
		blinking1 = true;
		$('#first').html(
			blinkstate1 ? "++"
						: currentfirst);

		blinkstate1 = ! blinkstate1;
		setTimeout(blinkplus1, 1500);
	}
}

function blinkplus2(){
	if (stopblink2 == false){
		blinking2 = true;
		$('#sec').html(
			blinkstate2 ? "++"
						: currentsec);

		blinkstate2 = ! blinkstate2;
		setTimeout(blinkplus2, 1500);
	}
}
