
<?php 
//Fetch the values from the data in the URL at server side
   header("Access-Control-Allow-Origin: *");
 ?>
<?php

<?php 
	$street = "";
	$city = "";
	$state = "";
	$degree = "";
	
	if (isset($_GET["streetAddress"]) && !empty($_GET["streetAddress"])) {
		$street = urlencode($_GET["streetAddress"]);
	}

	if (isset($_GET["city"]) && !empty($_GET["city"])) {
		$city = urlencode($_GET["city"]);
	}

	if (isset($_GET["state"]) && !empty($_GET["state"])) {
		$state = urlencode($_GET["state"]);
	}

	if (isset($_GET["degree"]) && !empty($_GET["degree"])) {
		$degree = $_GET["degree"];
	}

	$address = $street . "," . $city . "," . $state;
	$gmap_key= "AIzaSyBOJMchpuqAw4Wsd6T2Ay4ECyNQOETK3a8";
	$gmap_url = "https://maps.googleapis.com/maps/api/geocode/xml?address=" . $address . "&key=" . $gmap_key;

	$xmlDoc = new SimpleXMLElement($tempGoogleApiURL, NULL, TRUE);
	if ($xmlDoc->status == "OK") {
		$lattitude = "";
		$longitude = "";

		$i = 0;
		foreach ($xmlDoc->result[0]->geometry[0]->location[0]->children() as $child) {
			if($i == 0) {$latitude = $child;}
			if($i == 1) {$longitude = $child;}
			$i++;
		}

		$forecast_key = "409c98de0779b1a63a2bea89a855515d";

		$Unit = "";

		if($degree == "Fahrenheit") {
			$Unit = "us";
		}
		if($degree == "Celsius") {
			$Unit = "si";
		}

		$Forecast_URL = "https://api.forecast.io/forecast/" . $forecast_key . "/" . $latitude . "," . $longitude . "?units=" . $Unit . "&exclude=flags";

		$obj = json_decode(file_get_contents($Forecast_URL));
		
		echo json_encode($obj);
	}
?>

