<?php

function U_assessment($uvalue) {
/*
1-2 Low exposure. No protection required. You can safely stay outside
3-5 Moderate exposure. Seek shade during midday hours, cover up and wear sunscreen
6-7 High exposure. Seek shade during midday hours, cover up and wear sunscreen
8-10 Very high. Avoid being outside during midday hours. Shirt, sunscreen and hat are
essential
11 or
over
Extreme. Avoid being outside during midday hours. Shirt, sunscreen and hat
essential.
*/

    switch ($uvalue) {
    
    case $uvalue >=1 && $uvalue <=2:
	 $uvAdvice =  "The UV index is low. No protection required. You can safely stay outside";
	 break;
    
     case $uvalue >=3 && $uvalue <=5:
	 $uvAdvice =  "The UV index is moderate. Seek shade during midday hours, cover up and wear sunscreen";
	 break;
	 
	 case $uvalue >=6 && $uvalue <=7:
	 $uvAdvice =  "The UV Index is High. Seek shade during midday hours, cover up and wear sunscreen";
	 break;
	 
	  case $uvalue >=8 && $uvalue <=10:
	 $uvAdvice = "The UV Index is Very high. Avoid being outside during midday hours. Shirt, sunscreen and hat are
essential";
	 break;
    }
	 
	 return $uvAdvice;
    }

    
    function W_assessment($wvalue) {
    /* Index
   NA Not available
   0 Clear night
   1 Sunny day
   2 Partly cloudy (night)
   3 Partly cloudy (day)
   4 Not used
   5 Mist
   6 Fog
   7 Cloudy
   8 Overcast
   9 Light rain shower (night)
   10 Light rain shower (day)
   11 Drizzle
   12 Light rain
   13 Heavy rain shower (night)
   14 Heavy rain shower (day)
   15 Heavy rain
   16 Sleet shower (night)
   17 Sleet shower (day)
   18 Sleet
   19 Hail shower (night)
   20 Hail shower (day)
   21 Hail
   22 Light snow shower (night)
   23 Light snow shower (day)
   24 Light snow
   25 Heavy snow shower (night)
   26 Heavy snow shower (day)
   27 Heavy snow
   28 Thunder shower (night)
   29 Thunder shower (day)
   30 Thunder
   */

    switch ($wvalue) {
    
    case 0:
        $wvalue= "clear";
        return $wvalue;
        break;
    
    case 1:
        $wvalue ="sunny day";
        return $wvalue;;
        break;
    
    case 2:
        $wvalue ="partly cloudy (night)";
        return $wvalue;
        break;    
        
    case 3:
        $wvalue ="partly cloudy (day)";
       return $wvalue;
        break; 
    
    case 5:
        $wvalue ="mist";
        return $wvalue;
        break; 
        
    case 6:
        $wvalue ="fog";
        return $wvalue;
        break; 
        
    case 7:
        $wvalue ="cloudy";
        return $wvalue;
        break; 
    
     case 8:
        $wvalue ="Overcast";
        return $wvalue;
        break;
    
      case 9:
        $wvalue ="light rain";
        return $wvalue;
        break;
        
    case 10:
        $wvalue =" light rain";
        return $wvalue;
        break;
        
     case 11:
        $wvalue =" drizzle";
        return $wvalue;
        break;
        
    case 12:
        $wvalue =" Light rain shower ";
        return $wvalue;
        break;    
                
    case 13:
        $wvalue ="it's night and  heavy rain";
        return $wvalue;
        break;    
                
    case 14:
        $wvalue =" heavy rain";
        return $wvalue;
        break;    
                
    case 15:
        $wvalue =" heavy rain";
        return $wvalue;
        break;    
                
    case 18:
        $wvalue =" sleet";
        return $wvalue;
        break;    
                
    case 17:
        $wvalue ="  sleet";
        return $wvalue;
        break;    
                
    case 16:
        $wvalue =" sleet";
        return $wvalue;
        break;   
                
     case 19:
        $wvalue ="  hail showers";
        return $wvalue;
        break;    
                
    case 20:
        $wvalue =" hail showers";
        return $wvalue;
        break;  
                
     case 21:
        $wvalue ="hail";
        return $wvalue;
        break;    
                
    case 22:
        $wvalue =" heavy snow";
        return $wvalue;
        break;
        
    case 23:
        $wvalue ="  light snow";
        return $wvalue;
        break;    
                
    case 24:
        $wvalue =" light snow";
        return $wvalue;
        break;              
    
	case 25:
        $wvalue ="  heavy snow";
        return $wvalue;
        break;    
                
    case 26:
        $wvalue =" heavy snow";
        return $wvalue;
        break;    
                
    case 27:
        $wvalue =" heavy snow";
        return $wvalue;
        break;    
                
    case 28:
        $wvalue ="  thunderyshowers)";
        return $wvalue;
        break;    
                
    case 29:
        $wvalue =" thundery showers.";
        return $wvalue;
        break;    
                
    case 30:
        $wvalue ="Thunder";
        return $wvalue;
        break;            
    }
    
}

function gettrend($valuenow,$valuelater) {

    switch ($trend){

       case $valuelater = "":
       $trend = "no data";
       return $trend;

       case $valuenow < $valuelater: 
        $trend = "rising to ";
        return $trend;

        case $valuenow > $valuelater:
        $trend = "falling to ";
        return $trend;

        case $valuenow = $valuelater:
        $trend = "staying at ";
        return $trend;
    
    }
}

function forecast($loc)
{
//Build sentence for forecast
//$fvalue=$xml->DV->Location->Period[0]->Rep[0]['F'];
$myXMLData = file_get_contents('http://datapoint.metoffice.gov.uk/public/data/val/wxfcs/all/xml/'.$loc.'?res=3hourly&key=dfe3622f-228d-4f0b-a25e-f648b6cc4a97');
$xml=simplexml_load_string($myXMLData) or die("Error: Cannot create object");
$weather_now=W_assessment($xml->DV->Location->Period[0]->Rep[0]['W']);
$weather_later=W_assessment($xml->DV->Location->Period[0]->Rep[2]['W']);
$tvaluenow = $xml->DV->Location->Period[0]->Rep[0]['T'];
$tvaluelater = $xml->DV->Location->Period[0]->Rep[2]['T'];
$t_trend = gettrend($tvaluenow,$tvaluelater);
$fvaluenow = $xml->DV->Location->Period[0]->Rep[0]['F'];
$fvaluelater = $xml->DV->Location->Period[0]->Rep[2]['F'];
$f_trend = gettrend($fvaluenow,$fvaluelater);


echo "Right now it's ". $weather_now . " and the temperature is ".$tvaluenow. " degrees C. In approximately 3 hours the weather will be " . $weather_later. " and the temperature will be " . $t_trend . " to " . $tvaluelater . " degrees C";


//$temp_forecast=F_assessment($xml->DV->Location->Period[0]->Rep[0]['F'],$xml->DV->Location->Period[0]->Rep[2]['F']);



}