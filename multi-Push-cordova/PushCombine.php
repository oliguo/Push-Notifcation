<?php
require './mysql.php';

include './androidPush.php';
include './applePush.php';

$content=$_REQUEST['content'];


androidPush($content);
echo '-';
applePush($content);