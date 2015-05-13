<?php
	$line = $_GET['line'];
	if (!empty ($line[0]) && $line[0] === "N")
		echo "Noctilien";
	else
	{
		if (strlen($line) == 2 || (strlen($line) == 3 && $line[0] == 'P'))
			switch ($line)
		{
			case "20":
			case "26":
			case "27":
			case "70":
			case "82":
				echo "Orange";
			break;
			case "21":
			case "35":
			case "64":
			case "93":
				echo "Menthe";
			break;
			case "22":
			case "58":
			case "61":
			case "65":
			case "66":
				echo "Sapin";
			break;
			case "24":
			case "39":
			case "56":
			case "94":
				echo "Parme";
			break;
			case "28":
			case "47":
			case "67":
			case "80":
				echo "Rose";
			break;
			case "29":
			case "52":
			case "54":
			case "69":
			case "89":
				echo "Pervenche";
			break;
			case "30":
			case "76":
			case "87":
			case "PC1":
				echo "Iris";
			break;
			case "31":
			case "68":
			case "75":
			case "83":
			case "92":
				echo "Bouton-d-or";
			break;
			case "32":
			case "57":
				echo "Olive";
			break;
			case "38":
			case "42":
			case "48":
				echo "Azur";
			break;
			case "43":
			case "60":
			case "72":
			case "86":
			case "PC3":
				echo "Coquelicot";
			break;
			case "46":
			case "53":
			case "63":
			case "74":
			case "88":
				echo "Acacia";
			break;
			case "62":
			case "73":
			case "85":
			case "95":
				echo "Marron";
			break;
			case "81":
			case "84":
				echo "Lilas";
			break;
			case "91":
			case "96":
				echo "Ocre";
			break;
			default:
				echo "Default";
			break;
		}
		
		else if (strlen($line) == 3 && $line[0] == '1')
			switch ($line)
		{
			case "112":
			case "103":
			case "105":
			case "127":
			case "137":
			case "139":
			case "158":
			case "165":
			case "185":
			case "189":
			case "194":
				echo "Orange";
			break;
			case "114":
			case "133":
			case "167":
			case "169":
			case "177":
			case "192":
				echo "Menthe";
			break;
			case "115":
			case "117":
			case "123":
			case "153":
			case "160":
			case "172":
			case "174":
			case "179":
				echo "Sapin";
			break;
			case "138":
			case "145":
			case "151":
			case "157":
			case "164":
			case "182":
			case "186":
			case "195":
				echo "Parme";
			break;
			case "107":
			case "108":
			case "124":
			case "134":
			case "150":
			case "191":
				echo "Rose";
			break;
			case "116":
			case "126":
			case "170":
				echo "Pervenche";
			break;
			case "110":
			case "132":
			case "159":
			case "166":
			case "187":
				echo "Iris";
			break;
			case "101":
			case "102":
			case "119":
			case "156":
				echo "Bouton-d-or";
			break;
			case "129":
			case "180":
				echo "Olive";
			break;
			case "125":
			case "143":
			case "162":
			case "173":
			case "175":
			case "178":
				echo "Azur";
			break;
			case "104":
			case "106":
			case "113":
			case "121":
			case "140":
			case "147":
			case "152":
			case "171":
			case "183":
			case "197":
				echo "Coquelicot";
			break;
			case "109":
			case "199":
				echo "Acacia";
			break;
			case "128":
			case "131":
			case "148":
			case "181":
			case "190":
				echo "Marron";
			break;
			case "111":
			case "120":
			case "122":
			case "144":
			case "146":
			case "188":
				echo "Lilas";
			break;
			case "118":
			case "141":
			case "163":
			case "176":
				echo "Ocre";
			break;
			default:
				echo "Default";
			break;
		}
		
		else if ((strlen($line) == 3 || strlen($line) == 4) && $line[0] == '2')
			switch ($line)
		{
			case "234":
			case "247":
			case "269":
			case "272":
			case "299":
				echo "Orange";
			break;
			case "215":
			case "254":
				echo "Menthe";
			break;
			case "208":
			case "208a":
			case "208b":
			case "220":
			case "239":
			case "244":
			case "250":
			case "262":
			case "285":
			case "289":
			case "297":
				echo "Parme";
			break;
			case "203":
			case "211":
			case "221":
			case "238":
			case "270":
			case "292":
				echo "Rose";
			break;
			case "212":
				echo "Pervenche";
			break;
			case "217":
				echo "Iris";
			break;
			case "210":
			case "235":
			case "253":
			case "275":
				echo "Bouton-d-or";
			break;
			case "213":
			case "255":
			case "291":
				echo "Olive";
			break;
			case "216":
			case "251":
			case "252":
			case "258":
			case "261":
			case "274":
			case "276":
				echo "Coquelicot";
			break;
			case "249":
				echo "Acacia";
			break;
			case "201":
			case "206":
			case "241":
			case "256":
				echo "Marron";
			break;
			case "214":
			case "237":
			case "248":
			case "278":
			case "286":
			case "290":
			case "294":
				echo "Lilas";
			break;
			case "207":
			case "268":
			case "281":
				echo "Ocre";
			break;
			default:
				echo "Default";
			break;
		}
		
				else if (strlen($line) == 3 && $line[0] == '3')
			switch ($line)
		{
			case "312":
			case "356":
				echo "Orange";
			break;
			case "308":
			case "349":
			case "380":
				echo "Menthe";
			break;
			case "319":
			case "378":
				echo "Sapin";
			break;
			case "347":
				echo "Parme";
			break;
			case "322":
			case "325":
			case "370":
			case "390":
			case "399":
				echo "Pervenche";
			break;
			case "337":
			case "350":
			case "355":
			case "394":
				echo "Iris";
			break;
			case "302":
			case "320":
			case "321":
			case "330":
			case "334":
			case "341":
			case "367":
			case "372":
			case "379":
			case "388":
				echo "Bouton-d-or";
			break;
			case "303":
				echo "Olive";
			break;
			case "306":
			case "318":
			case "333":
			case "361":
			case "366":
			case "389":
			case "395":
				echo "Azur";
			break;
			case "301":
			case "304":
			case "310":
			case "317":
			case "323":
			case "346":
			case "360":
			case "368":
			case "391":
			case "396":
				echo "Acacia";
			break;
			case "340":
			case "351":
			case "385":
				echo "Ocre";
			break;
			default:
				echo "Default";
			break;
		}
		else
			echo "Default";
	}
?>