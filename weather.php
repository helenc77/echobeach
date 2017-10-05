<?php
require_once('functions.php');

function getRequestData($request){
    
    //get the data
    $requestArray = json_decode($request, true);
    
    //get the variables from the slots

    $valuesToGet = array();
    $Slots = $requestArray['request']['intent']['slots'];
    foreach($Slots as $key => $val){
        $valuesToGet[$key] = $val['value'];
    }
    
    return $valuesToGet;
}

function getWeatherLocationId($locationText){
    
    //get location from text
    $locationData = 'http://www.metoffice.gov.uk/public/data/services/location-search/v1/'.$locationText.'/?max=5&filter=';
    $locationDataContents = file_get_contents($locationData);
    $locationDataArray = json_decode($locationDataContents, true);
    $locationID = $locationDataArray['0']['nearestSspaId'];
    
    return $locationID;
    
}

function getWeatherDateData($locationId){
    
    //get date
    
    //get location from id
    $url = 'http://datapoint.metoffice.gov.uk/public/data/val/wxfcs/all/json/'.$locationId.'?res=3hourly&key=dfe3622f-228d-4f0b-a25e-f648b6cc4a97';

    $str = file_get_contents($url);
    $jsonArray = json_decode($str, true);
    
    return $jsonArray;
    
}

function dateToPeriod($date){
    
    $unixTimeNow = time();
    $unixTime = strtotime($date);
    
    $date = date('Y-m-d', $unixTime);
    $periodArray['0'] = date('Y-m-d');
    $periodArray['1'] = date('Y-m-d', strtotime('tomorrow')); 
    $periodArray['2'] = date('Y-m-d', strtotime('tomorrow + 1 day'));
    $periodArray['3'] = date('Y-m-d', strtotime('tomorrow + 2 day'));
    $periodArray['4'] = date('Y-m-d', strtotime('tomorrow + 3 day'));

    if ($date == $periodArray['0']) {
      //echo "today";
      $period = 0;
    } else if ($date == $periodArray['1']) {
      //echo "tomorrow";
      $period = 1;
    } else if ($date == $periodArray['2']) {
      //echo "dayaftertomorrow";
      $period = 2;
    } else if ($date == $periodArray['3']) {
      $period = 3;
    } else if ($date == $periodArray['4']) {
      $period = 4;
    }
    
    return $period;
}

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
    
    $request = $HTTP_RAW_POST_DATA;

} else {
    
    $request = '{
        "session": {
          "sessionId": "SessionId.xxxxxxxxxxxxxxxxxxxxxxx",
          "application": {
            "applicationId": "amzn1.ask.skill.2d0e51d1-2d72-4ca0-a324-dd486fa17213"
          },
          "attributes": {},
          "user": {
            "userId": "amzn1.ask.account.xxxxxxxxxxxxxxxxxxxxxxx"
          },
          "new": true
        },
        "request": {
          "type": "IntentRequest",
          "requestId": "EdwRequestId.b49018be-8265-418a-9226-72a0a3862550",
          "locale": "en-GB",
          "timestamp": "2017-04-29T13:45:17Z",
          "intent": {
            "name": "Simple",
            "slots": {
              "Activity": {
                "name": "Activity",
                "value": "swim",
                "confirmationStatus": "NONE"
              },
              "Date": {
                "name": "Date",
                "value": "2017-05-01",
                "confirmationStatus": "NONE"
              },
              "Location": {
                "name": "Location",
                "value": "Torquay",
                "confirmationStatus": "NONE"
              }
            }
          }
        },
        "version": "1.0"
      }';
    
}



$valuesToGet = getRequestData($request);
$period = dateToPeriod($valuesToGet['Date']);

$locationId = getWeatherLocationId('exmouth');
$weatherDateData = getWeatherDateData($locationId);

if($valuesToGet['Activity']){
    
    $uv = $weatherDateData['SiteRep']['DV']['Location']['Period'][$period]['Rep']['0']['U'];
    $temperature = $weatherDateData['SiteRep']['DV']['Location']['Period'][$period]['Rep']['0']['T'];
    $uvAdvice = U_assessment($uv);
    
    //select image based on temp
    if($temperature > 15){
        $img = 'high_temp';
    } else if($temperature < 10){
        $img = 'low_temp';
    } else {
        $img = 'med_temp';
    }
    
    if($valuesToGet['Activity'] == 'sunbathe'){

          $response = '{
          "version": "1.0",
          "response": {
            "outputSpeech": {
              "type": "PlainText",
              "text": "The temperature is '.$temperature.' degrees celsius. '.$uvAdvice.'"
            },
            "card": {
              "text": "The temperature is '.$temperature.' degrees celsius. '.$uvAdvice.'",
              "title": "Temperature",
              "image": {
                "smallImageUrl": "https://letsgotothebeach.azurewebsites.net/images/small/'.$img.'.png",
                "largeImageUrl": "https://letsgotothebeach.azurewebsites.net/images/large/'.$img.'.png"
              },
              "type": "Standard"
            },
            "shouldEndSession": true
          },
          "sessionAttributes": {}
        }';
        
    } elseif($valuesToGet['Activity'] == 'swim'){

          $response = '{
          "version": "1.0",
          "response": {
            "outputSpeech": {
              "type": "PlainText",
              "text": "The temperature is '.$temperature.' degrees celsius. '.$uvAdvice.'"
            },
            "card": {
              "text": "The temperature is '.$temperature.' degrees celsius. '.$uvAdvice.'",
              "title": "Temperature",
              "image": {
                "smallImageUrl": "https://letsgotothebeach.azurewebsites.net/images/small/'.$img.'.png",
                "largeImageUrl": "https://letsgotothebeach.azurewebsites.net/images/large/'.$img.'.png"
              },
              "type": "Standard"
            },
            "shouldEndSession": true
          },
          "sessionAttributes": {}
        }';
        
    }  
    
} 

echo($response);

