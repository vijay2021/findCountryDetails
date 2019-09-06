<?php
require("includes/FindCountryDetails.php");
echo "\n";
$handle = fopen ("php://stdout","w"); //Reading cli command
$line = fgets($handle); 

$getCodeJson = array();
$argumentCount = COUNT($argv); //counting arguments for conditional output

// Creating object of findCountryDetails class.
$getCountryLanguage = new findCountryDetails();

switch($argumentCount){
	//when user not entered any country name.
	case 1:
		echo "Please enter country name correctly(Such as: php index.php Spain).";
		break;
	//when user entered only 1 country name
	case 2:
		
		$inputCountryName = $argv[1];
		
		if($inputCountryName!=''){
			
			// Find country code
			$languageCode = $getCountryLanguage->findCountryLanguageCode($inputCountryName);
			
			if ($languageCode) {
					
					echo "Country language code:".$languageCode;
					echo "\n";
					
					//Find list of array for same language code country
					$getCodeJsonCountryList = $getCountryLanguage->findOtherCountryByLanguageCode($languageCode);
					
					if(COUNT($getCodeJsonCountryList)>0){
						
						$otherCountryList = "";
						for($i=0;$i<sizeof($getCodeJsonCountryList);$i++){
							if($getCodeJsonCountryList[$i]->name!=$inputCountryName){
								$otherCountryList .= ucfirst($getCodeJsonCountryList[$i]->name).", ";
							}
							// Ending script, becasue in example showing that we need to find 3 countries only from this list, We can get all contries list after comment on following code. 
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
		
		// Start find first country code
		$languageCodeFirstCountry = $getCountryLanguage->findCountryLanguageCode($inputFirstCountry);
		
		if (!$languageCodeFirstCountry) {
			echo "Sorry, ".ucfirst($inputFirstCountry)." is not available as a country name in our database.";
			break;
		}
		
		// End first country code
		
		
		// Start find second country code
		$languageCodeSecondCountry = $getCountryLanguage->findCountryLanguageCode($inputSecondCountry);
		
		if (!$languageCodeSecondCountry) {
			echo "Sorry, ".ucfirst($inputSecondCountry)." is not available as a country name in our database.";
			break;
		}
		
		// End second country code
		
		
		// checking both country code are same or not.		
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