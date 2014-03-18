<?php

require_once('config.php');

if (!isset($_GET['file'])) {
    print_r('Error file');
}


$filePath = TEXT_TOOL_TMP_PATH . $_GET['file'];
if (!file_exists($filePath)) {
    print_r('Error file exists' . $_GET['file']); exit;
}



if (isset($_GET['twitter']) && $_GET['twitter'] ==1) {
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

    print_r($code);
}



if (isset($_GET['facebook']) && $_GET['facebook'] ==1) {

    include('lib/facebook.php');

    $name = urldecode("ebayfeedback");


    $fbConf = array(
        'appId' => $fbApId,
        'secret' => $fbAppSecret,
        'cookie' => true,
    );

    $facebook = new Facebook($fbConf);

    $session = $facebook->getUser(); //print_r($session);
    $me = null;

    if ($session) {
        try {
            $me = $facebook->api('/me');
        } catch (FacebookApiException $e) {
            error_log($e);
        }
    }
    $message = '';

    try {

        if ($me && $facebook->checkPermission('user_photos') && $facebook->checkPermission('publish_stream')) {

            $facebook->setFileUploadSupport(true);

            $albums = $facebook->api('/me/albums', 'get');
            $album_uid = null;
            if (isset($albums['data'])) {
                foreach ($albums['data'] as $row) {
                    if ($row['name'] == $name) {
                        $album_uid = $row['id'];
                    }
                }
            }
            if (!$album_uid) {
                //Create an album
                $album_details = array(
                    'message' => $name,
                    'name' => $name
                );
                $create_album = $facebook->api('/me/albums', 'post', $album_details);
                //Get album ID of the album you've just created
                $album_uid = $create_album['id'];
            }

            $uid = $facebook->getUser();
            $type = 'self';

            //Upload a photo to album of ID...
            $photo_details = array(
                'message' => $name
            );

                $file = $filePath;
                $photo_details['image'] = '@' . realpath($file);

                $upload_photo = $facebook->api('/' . $album_uid . '/photos', 'post', $photo_details);

            $message = "You're Almost Done!";
        } else {
            $loginUrl = $facebook->getLoginUrl(array('scope' => 'user_photos,publish_stream'));
            header("Location:$loginUrl");
        }
    } catch (Exception $e) {
        $erMes = $e->getMessage();
        $message = "Something went wrong. Please try again later." . $erMes;
    }

    print_r($message);
}