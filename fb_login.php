<?php
require_once('config.php');
require_once('lib/facebook.php');

$fbConf = array(
    'appId' => $fbApId,
    'secret' => $fbAppSecret,
    'cookie' => true,
);

$facebook = new Facebook($fbConf);

$session = $facebook->getUser();
$me = null;

if ($session) {
    try {
        $me = $facebook->api('/me');
    } catch (FacebookApiException $e) {
        error_log($e);
    }
}

if ($me) {

    $session = array(
        'fbusername' => $me['username'],
        'fbid' => $me['id'],
    );
    $_SESSION = $session;

    header('Location:/');

} else {
    $loginUrl = $facebook->getLoginUrl(
        array(
            'scope' => 'user_photos,publish_stream,email',
        )
    );
    //print_r($loginUrl);exit;
    header("Location: $loginUrl ");
}