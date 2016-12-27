<?php
$access_token = '5xB8I03dwTqRr7bAVZxYaU4FE2C+f9yzpTen4z+B/Q28nL+5Mvio/fsOzJeVmIq0eAeRCsOuw/gxsJdcyMn5+/lPgkpd+VnPWz3YLHP4DSDZiLpaYR6GP9YU/K68+Cf/N5Hr/AfbFGGYpiJ6JOM1ewdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$text = ($text == 'Kak') ? 'กากส์' : $text;
			$text = ($text == 'จึ๊ก') ? 'หล่อ สัสๆ' : $text;
			$text = ($text == 'บอล') ? 'พ่อเทพบุตร' : $text;
			$text = ($text == 'บอลซัง') ? 'พนักงานดีเด่น' : $text;
			$text = ($text == 'เกรียน') ? 'เหี้ย กรุ๊ปกากส์' : $text;
			$text = ($text == 'ยนน') ? 'เยส แน่ นอน' : $text;
			$text = ($text == 'กี่โมงแล้ว') ? date("Y-m-d hh:MM:ss",time()) : $text;
			$text = ($text == 'แดกไรดี') ? 'เตาถ่านดิสัส คิดนาน เสียเวลาแดก' : $text;
			$text = ($text == 'สาว') ? 'เงี่ยน?' : $text;
			
			if ($text == $event['message']['text']) {
					//ignore
			}else{
				$messages = [
					'type' => 'text',
					'text' => $text
				];

				// Make a POST Request to Messaging API to reply to sender
				$url = 'https://api.line.me/v2/bot/message/reply';
				$data = [
					'replyToken' => $replyToken,
					'messages' => [$messages],
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
		}
	}
}
echo "OK";