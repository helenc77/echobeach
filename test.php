<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$url = 'http://www.metoffice.gov.uk/public/data/services/location-search/v1/beach/?max=5&filter=';
$request = 'request.json';

$str = file_get_contents($request);
$jsonArray = json_decode($str, true);

echo('<pre>');
print_r($jsonArray);
echo('</pre>');

$response = '{
  "version": "1.0",
  "response": {
    "outputSpeech": {
      "type": "PlainText",
      "text": "Split. Though Kevin has evidenced 23 personalities to his trusted psychiatrist, Dr. Fletcher, there remains one still submerged who is set to materialize and dominate all the others. Compelled to abduct three teenage girls led by the willful, observant Casey, Kevin reaches a war for survival among all of those contained within him — as well as everyone around him — as the walls between his compartments shatter apart."
    },
    "card": {
      "text": "Though Kevin has evidenced 23 personalities to his trusted psychiatrist, Dr. Fletcher, there remains one still submerged who is set to materialize and dominate all the others. Compelled to abduct three teenage girls led by the willful, observant Casey, Kevin reaches a war for survival among all of those contained within him — as well as everyone around him — as the walls between his compartments shatter apart.",
      "title": "Split",
      "image": {
        "smallImageUrl": "https://image.tmdb.org/t/p/w780//4G6FNNLSIVrwSRZyFs91hQ3lZtD.jpg",
        "largeImageUrl": "https://image.tmdb.org/t/p/w1280//4G6FNNLSIVrwSRZyFs91hQ3lZtD.jpg"
      },
      "type": "Standard"
    },
    "shouldEndSession": true
  },
  "sessionAttributes": {}
}';





/*
 * 
 * {
  "version": "1.0",
  "response": {
    "outputSpeech": {
      "type": "PlainText",
      "text": "Split. Though Kevin has evidenced 23 personalities to his trusted psychiatrist, Dr. Fletcher, there remains one still submerged who is set to materialize and dominate all the others. Compelled to abduct three teenage girls led by the willful, observant Casey, Kevin reaches a war for survival among all of those contained within him — as well as everyone around him — as the walls between his compartments shatter apart."
    },
    "card": {
      "text": "Though Kevin has evidenced 23 personalities to his trusted psychiatrist, Dr. Fletcher, there remains one still submerged who is set to materialize and dominate all the others. Compelled to abduct three teenage girls led by the willful, observant Casey, Kevin reaches a war for survival among all of those contained within him — as well as everyone around him — as the walls between his compartments shatter apart.",
      "title": "Split",
      "image": {
        "smallImageUrl": "https://image.tmdb.org/t/p/w780//4G6FNNLSIVrwSRZyFs91hQ3lZtD.jpg",
        "largeImageUrl": "https://image.tmdb.org/t/p/w1280//4G6FNNLSIVrwSRZyFs91hQ3lZtD.jpg"
      },
      "type": "Standard"
    },
    "shouldEndSession": true
  },
  "sessionAttributes": {}
}
 */


