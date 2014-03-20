<?php

require_once('config.php');

if (!isset($_GET['file'])) {
    print_r('Error file');
}


$filePath = TEXT_TOOL_TMP_PATH . $_GET['file'];
if (!file_exists($filePath)) {
    print_r('Error file exists' . $_GET['file']); exit;
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

    $session = $facebook->getUser();
    $token = file_put_contents(dirname(__FILE__).'fb_token', $access_token);

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
                $album_details = array(
                    'message' => $name,
                    'name' => $name
                );
                $create_album = $facebook->api('/me/albums', 'post', $album_details);
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

            $message = "Uploaded to facebook<br>";

    print_r($message);
}