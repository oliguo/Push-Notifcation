<?php

function applePush($content){
$select="select * from push where push_device='iOS' and push_allow='on'";
  $deviceToken=[];  
    $result=mysql_query($select);
    while($row=mysql_fetch_assoc($result)){
    array_push($deviceToken, $row['push_tokenApple']);
    }
// Put your device token here (without spaces):
//$deviceToken = 'fcb3339d194d399b1dcc47afe1c955e478ef11487dae186e1fa1d5ec0208fbb5';

// Put your private key's passphrase here:
$passphrase = 'xxxxxxxx';

// Put your alert message here:
//$message = 'My first push notification!';

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'CK.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

//echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
	'alert' => $content,
        'badge'=>'1',
	'sound' => 'default'
	);

// Encode the payload as JSON
$payload = json_encode($body);
$n=0;

for($i=0;$i<count($deviceToken);$i++){
// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken[$i]) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result){
	//echo '<br/>Message not delivered' . PHP_EOL;
}else{
	//echo '<br/>Message successfully delivered' . PHP_EOL;
        $n++;
}

}

echo $n;
// Close the connection to the server

fclose($fp);
}