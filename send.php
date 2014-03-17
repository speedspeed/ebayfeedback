<?php

require_once('config.php');

if (!isset($_POST['file'])) {
    print_r('Error file');
}


$filePath = TEXT_TOOL_TMP_PATH . $_POST['file'];
if (!file_exists($filePath)) {
    print_r('Error file exists' . $_POST['file']);
}



if (isset($_POST['twitter']) && $_POST['twitter'] ==1) {
    include('lib/tmhOAuth/tmhOAuth.php');

    $tmhOAuth = new tmhOAuth(array(
        'consumer_key'    => $tw_consumer_key,
        'consumer_secret' => $tw_consumer_secret,
        'user_token'      => $tw_user_token,
        'user_secret'     => $tw_user_secret,
    ));



    $params = array(
        'media[]' => "@{$filePath};type=image/png;filename=".basename($filePath),
        'status'  => "New Feedback"
    );

    $code = $tmhOAuth->user_request(array(
        'method' => 'POST',
        'url' => $tmhOAuth->url("1.1/statuses/update_with_media"),
        'params' => $params,
        'multipart' => true
    ));

    $tmhOAuth->render_response();
}



if (isset($_POST['facebook']) && $_POST['facebook'] ==1) {

}