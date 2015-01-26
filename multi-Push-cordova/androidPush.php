<?php

// API access key from Google API's Console
//define( 'API_ACCESS_KEY', 'YOUR-API-ACCESS-KEY-GOES-HERE' );
define( 'API_ACCESS_KEY', 'xxxxxxx' );

function androidPush($content){
          $select="select * from push where push_device='Android' and push_allow='on'";
  $registrationIds=[];  
    $result=mysql_query($select);
    while($row=mysql_fetch_assoc($result)){
    array_push($registrationIds, $row['push_idGoogle']);
    }
   
// prep the bundle
$msg = array
(
	'message' 	=> $content,
	'title'		=> 'PiggyRebates',
	'subtitle'	=> ' ',
	'tickerText'	=> ' ',
	'vibrate'	=> 1,
	'sound'		=> 1,
	'largeIcon'	=> 'large_icon',
	'smallIcon'	=> 'small_icon'
);

$fields = array
(
	'registration_ids' 	=> $registrationIds,
	'data'			=> $msg
);
 
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );

$jsonResult=json_decode($result, true);
echo $jsonResult['success'];
}