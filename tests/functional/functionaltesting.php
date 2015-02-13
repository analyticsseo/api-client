<?php

##################################################################################
#   Tests that should pass
##################################################################################
$tests = array(
 	"google global" => array(
    "request" => array(
      'region'=>'in',
          'search_engine' => 'google',
           'phrase' => 'আপনি এক কাপ চা বা কফি এক কাপ বা নরম পানীয় একটি কাপ চান?',
		   'language' => 'bn',
			)
        ),
);

##################################################################################
#   Tests that should return an api error message about max results being over 500
##################################################################################
$errormaxresults = array(
    
);

// Uncomment the following lines and add the proper values
 //define('API_KEY', 'a');
 //define('API_SECRET', 'b');
 //define('SALT', 'c');

// optionally you can define the constants in a file named settings.php
@include 'settings.php';



# Do not modify below this line
##################################################################################

include __DIR__ . '/../../vendor/autoload.php';


$guzzle = new Guzzle\Http\Client('http://v3.api.analyticsseo.com');

$auth = new Aseo\Api\Auth\KeyAuth;
$auth->setApiKey(API_KEY);
$auth->setApiSecret(API_SECRET);
$auth->setSalt(SALT);

$serps = new Aseo\Api\V3\Serps\SerpsApiClient($guzzle, $auth);
$serps->debug = TRUE;



foreach ($tests as $testName => $testData) {
    echo "testing '$testName'\t";
    $request = new Aseo\Api\V3\Serps\SerpsRequest($testData['request']);
    try {
        $searchResultsResponse = $serps->searchResults($request);
        $jobId = $searchResultsResponse['jid'];
        $testData['jid'] =  $searchResultsResponse['jid'];

        while (true) {
            $fetchJobResponse = $serps->fetchJobData($jobId);

            if (false == $fetchJobResponse['ready']) {
                sleep(1);
                continue;
            }

            if (array_key_exists('error', $fetchJobResponse)) {
                echo "[ERROR]\n";
                echo "\t ==> " . $fetchJobResponse['error'] . "\n\n";
                break;
            }

            if (false === array_key_exists('payload', $fetchJobResponse)) {
                echo "[ERROR]\n";
                echo "\t ==> No payload response\n\n";
                break;
            }

            if (false === is_array($fetchJobResponse['payload'])) {
                echo "[ERROR]\n";
                echo "\t ==> Payload response not an array\n\n";
                break;
            }

            if (0 ==  count($fetchJobResponse['payload'])) {
                echo "[ERROR]\n";
                echo "\t ==> Empty payload response\n\n";
                break;
            }

            echo "[OK]\n";
            break;
        }


    } catch (\Exception $e) {
            echo "[ERROR]\n";
            echo "\t ==> " . $e->getMessage() . "\n\n";
    }
}

foreach ($errorTests as $testName => $testData) {
    echo "testing '$testName'\t";
    $request = new Aseo\Api\V3\Serps\SerpsRequest($testData['request']);
    try {
        $searchResultsResponse = $serps->searchResults($request);
        $jobId = $searchResultsResponse['jid'];
        $testData['jid'] =  $searchResultsResponse['jid'];

        while (true) {
            $fetchJobResponse = $serps->fetchJobData($jobId);

            if (false == $fetchJobResponse['ready']) {
                sleep(1);
                continue;
            }

            if (array_key_exists('error', $fetchJobResponse)) {
                echo "[OK]";
                echo "\t ==> " . $fetchJobResponse['error'] . "\n\n";
                break;
            }



            echo "[ERROR]\n";
            echo "\t ==> Api returned no Error\n\n";
            break;
        }


    } catch (\Exception $e) {
            echo "[OK??]\n";
            echo "\t ==> " . $e->getMessage() . "\n\n";
    }
}
