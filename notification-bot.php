<?php
date_default_timezone_set('Asia/Bangkok');
$access_token = '5xB8I03dwTqRr7bAVZxYaU4FE2C+f9yzpTen4z+B/Q28nL+5Mvio/fsOzJeVmIq0eAeRCsOuw/gxsJdcyMn5+/lPgkpd+VnPWz3YLHP4DSDZiLpaYR6GP9YU/K68+Cf/N5Hr/AfbFGGYpiJ6JOM1ewdB04t89/1O/w1cDnyilFU=';
$groupId = 'U37d948cd0f83293486fc2b7bd339adc1';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$build = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($build['build'])) {

	$name = $build['name'];
	$buildUrl =  $build['build']['full_url'];
	$buildNumber = $build['build']['number'];
	$status = $build['build']['status'];
	$branch = $build['build']['scm']['branch'];

	try{
	if(	!is_null($name) &&
			!is_null($buildUrl) &&
			!is_null($buildNumber) &&
			!is_null($status) &&
			!is_null($branch)){

				//Construct message
				$text = 	'[.'. $status .'.]'.'\n'.
									'name: '. $name.'\n'.
									'buildUrl: '.$buildUrl.'\n'.
									'buildNumber: '.$buildNumber.'\n'.
									'branch: '.$branch;

				echo $text;

				$messages = [
					'type' => 'text',
					'text' => $text
				];

				sendTextMessage($access_token, $messages);

			}else{
				//error null value
				echo 'null value';
			}
	}catch(Exception $ex){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}
echo "OK";

function sendTextMessage($access_token, $messageObject){
	// Make a POST Request to Messaging API to reply to sender
	$url = 'https://api.line.me/v2/bot/message/reply';
	$data = [
		'replyToken' => $replyToken,
		'messages' => [$messageObject],
	];
	$post = json_encode($data);
	$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$result = curl_exec($ch);
	curl_close($ch);

	echo $result . "\r\n";
}
