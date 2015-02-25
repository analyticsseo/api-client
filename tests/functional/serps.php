<?php

##################################################################################
#   Tests that should pass
##################################################################################
$tests = array(
    "google global" => array(
        "request" => array(
          'region'=>'global',
              'output' => 'test',
              'search_engine' => 'google',
               'phrase' => 'cricket world cup',
                'universal' => 0,
            )
    ),

    "google fr" => array(
        "request" => array(
           'region'=>'fr',
            'output' => 'test',
            'search_engine' => 'google',
            'phrase' => 'voulez-vous une tasse de thé ou une tasse de café ou une tasse de boisson gazeuse?',
            'language' => 'fr',
        )
    ),

    "google hk" => array(
        "request" => array(
            'region'=>'hk',
            'output' => 'test',
            'search_engine' => 'google',
            'phrase' => '你要一杯茶或一杯咖啡或一杯饮料吗？',
            'language' => 'zh-TW',
        )
    ),
    "google cn" => array(
        "request" => array(
            'region'=>'cn',
            'output' => 'test',
            'search_engine' => 'google',
            'phrase' => '你要一杯茶或一杯咖啡或一杯饮料吗？',
            'language' => 'zh-CN',
        )
    ),

    "google tw" => array(
        "request" => array(
            'output' => 'test',
            'region'=>'tw',
            'search_engine' => 'google',
            'phrase' => '你要一杯茶或一杯咖啡或一杯饮料吗？',
            'language' => 'zh-TW',
        )
    ),
    "google dz" => array(
        "request" => array(
            'region'=>'dz',
            'output' => 'test',
            'search_engine' => 'google',
            'phrase' => 'هل تريد فنجانا من الشاي أو فنجان من القهوة أو كوب من المشروبات الغازية؟',
            'language' => 'ar',
        )
    ),

    "google il" => array(
        "request" => array(
            'region'=>'il',
            'output' => 'test',
            'search_engine' => 'google',
            'phrase' => 'אתה רוצה כוס התה או כוס קפה או כוס שתייה קלה?',
            'language' => 'he',
        )
    ),

    "bing global" => array(
        "request" => array(
            'output' => 'test',
            'region'=>'global',
            'search_engine' => 'bing',
            'phrase' => 'best place to take selfie in London',
            'language' => 'en',
        )
    ),
    "yahoo global" => array(
        "request" => array(
            'region'=>'global',
            'output' => 'test',
            'search_engine' => 'yahoo',
            'phrase' => 'best place to take selfie in London',
            'language' => 'en',
        )
    ),

    "yandex global" => array(
        "request" => array(
            'region'=>'global',
            'output' => 'test',
            'search_engine' => 'yandex',
            'phrase' => 'best place to take selfie in London',
            'language' => 'en',
        )
    ),

    "google hu" => array(
        "request" => array(
            'region'=>'hu',
            'output' => 'test',
            'search_engine' => 'google',
            'phrase' => 'kérsz egy csésze tea vagy egy csésze kávé vagy egy pohár üdítő?',
            'language' => 'hu',
        )
    ),

    "google pt" => array(
        "request" => array(
            'region'=>'pt',
            'output' => 'test',
            'search_engine' => 'google',
            'phrase' => 'você quer uma xícara de chá ou uma xícara de café ou um copo de refrigerante?',
            'language' => 'pt-PT',
        )
    ),

    "google kr" => array(
        "request" => array(
            'region'=>'kr',
            'output' => 'test',
            'search_engine' => 'google',
            'phrase' => '당신은 차 한 잔 또는 커피 한 잔 또는 소프트 드링크 한 잔할까요?',
            'language' => 'ko',
        )
    ),

    "google in" => array(
        "request" => array(
            'region'=>'in',
            'output' => 'test',
            'search_engine' => 'google',
            'phrase' => 'আপনি এক কাপ চা বা কফি এক কাপ বা নরম পানীয় একটি কাপ চান?',
            'language' => 'bn',
        )
    ),
);

##################################################################################
#   Tests that should return an api error message
##################################################################################
$errorTests = array(
   "invalid language" => array(
        "request" => array(
           'region'=>'global',
           'output' => 'test',
           'search_engine' => 'google',
           'phrase' => 'abc',
           'universal' => 0,
           'language' => 'asd',
        )
    ),
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
$serps->debug = false;



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
            break 1;
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
                // echo "\t ==> " . $fetchJobResponse['error'] . "\n\n";
                break;
            }



            echo "[ERROR]\n";
            echo "\t ==> Api returned no Error\n\n";
            break;
        }


    } catch (\Exception $e) {
            echo "[??]\n";
            echo "\t ==> " . $e->getMessage() . "\n\n";
    }
}

echo "\n";
