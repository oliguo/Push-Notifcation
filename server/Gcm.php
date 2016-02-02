<?php

if (isset($_POST['deviceID']) && (!empty($_POST['deviceID']))) {

    define('API_ACCESS_KEY', 'AIzaSyCDw3Evi0_e8jDE5O2ibv003emvti51Os0');
    $registrationIds = [$_POST['deviceID']];
    $message=(isset($_POST['appMessage'])&&(!empty($_POST['appMessage'])))?$_POST['appMessage']:'';
    $title=(isset($_POST['appTitle'])&&(!empty($_POST['appTitle'])))?$_POST['appTitle']:'';
    $key=(isset($_POST['extraKey'])&&(!empty($_POST['extraKey'])))?$_POST['extraKey']:'';
    $value=(isset($_POST['extraValue'])&&(!empty($_POST['extraValue'])))?$_POST['extraValue']:'';
// prep the bundle
    $msg = array
        (
        'message' => $message,
        'title' => $title,
        'datas' => [$key => $value]
    );

    $fields = array
        (
        'registration_ids' => $registrationIds,
        'data' => $msg
    );

    $headers = array
        (
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);

    echo $result;
}else{
    echo json_encode('GCM Device ID Required');
}
