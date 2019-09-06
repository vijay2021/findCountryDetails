<?php
require("includes/countryDetails.php");
echo "\n";
$handle = fopen ("php://stdout","w"); //Reading cli command
$line = fgets($handle); 

$getCodeJson = array();
$argumentCount = COUNT($argv); //counting arguments for conditional output

switch($argumentCount){
	//when user not entered any country name.
	case 1:
		echo "Please enter country name correctly(Such as: php index.php Spain).";
		break;
	//when user entered only 1 country name
	case 2:
		
		$inputCountryName = $argv[1];
		
		if($inputCountryName!=''){
			//converting json in array
			$getCodeJson = json_decode(@file_get_contents("https://restcountries.eu/rest/v2/name/".$inputCountryName));
			
			if (strpos($http_response_header[0], "200")) {
					$languageCode = $getCodeJson[0]->languages[0]->iso639_1;
					echo "Country language code:".$languageCode;
					echo "\n";
					
					$getCodeJsonCountryList = json_decode(file_get_contents("https://restcountries.eu/rest/v2/lang/".$languageCode));	
					

					if(COUNT($getCodeJsonCountryList)>0){
						
						$otherCountryList = "";
						for($i=0;$i<sizeof($getCodeJsonCountryList);$i++){
							if($getCodeJsonCountryList[$i]->name!=$inputCountryName){
								$otherCountryList .= ucfirst($getCodeJsonCountryList[$i]->name).", ";
							}
							
							if($i==2){
								$otherCountryList = substr($otherCountryList,0,-2);		
								$otherCountryList .= "...";
								break 1;
							}
						}
						
						
						
					}	
					echo ucfirst($inputCountryName)." speaks same language with these countries:".$otherCountryList;
					
				
			}else{
				echo "Sorry, We didn't find any infromation for submitted country name.";
			}
		}
		break;
	case 3:
		
		$inputFirstCountry = $argv[1];
		$inputSecondCountry = $argv[2];
		
		$firstCountryJson = json_decode(@file_get_contents("https://restcountries.eu/rest/v2/name/".$inputFirstCountry));
		
		if (strpos($http_response_header[0], "200")) {
			$languageCodeFirstCountry = $firstCountryJson[0]->languages[0]->iso639_1;
		}else{
			echo "Sorry, ".ucfirst($inputFirstCountry)." is not available as a country name in our database.";
			break;
		}
		
		
		$secondCountryJson = json_decode(@file_get_contents("https://restcountries.eu/rest/v2/name/".$inputSecondCountry));
		if (strpos($http_response_header[0], "200")) {
			$languageCodeSecondCountry = $secondCountryJson[0]->languages[0]->iso639_1;
		}else{
			echo "Sorry, ".ucfirst($inputSecondCountry)." is not available as a country name in our database.";
			break;
		}
		
		 	
		if((isset($languageCodeFirstCountry) && isset($languageCodeSecondCountry)) && (trim(strtolower($languageCodeFirstCountry))!=trim(strtolower($languageCodeSecondCountry)))){
			echo ucfirst($inputFirstCountry)." and ".ucfirst($inputSecondCountry)." do not speak the same language";			
		}else{
			echo ucfirst($inputFirstCountry)." and ".ucfirst($inputSecondCountry)." do speak the same language";			
		}
		break;
	default:
		echo "Please enter correct url for details.";
		break;
		
	
}

echo "\n";
?>