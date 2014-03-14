<?php
require_once('config.php');

require_once ('lib/cUrl.php');
require_once ('lib/xml.php');
require_once ('lib/imagemagick.class.php');


$headers = array (
    "X-EBAY-API-COMPATIBILITY-LEVEL:863",
    "X-EBAY-API-DEV-NAME:".$ebayDEVID,
    "X-EBAY-API-APP-NAME:".$ebayAppID,
    "X-EBAY-API-CERT-NAME:".$ebayCertID,
    "X-EBAY-API-SITEID:0",
    "X-EBAY-API-CALL-NAME:GetFeedback",
);

$str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<GetFeedbackRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
<RequesterCredentials>
<eBayAuthToken>".$ebayToken."</eBayAuthToken>
</RequesterCredentials>
<CommentType>Positive</CommentType>
<Pagination>
<EntriesPerPage>10</EntriesPerPage>
<PageNumber>1</PageNumber>
</Pagination>
<DetailLevel>ReturnAll</DetailLevel>
<Version>863</Version>
</GetFeedbackRequest>​​";

$response = request($ebayServerURL, $headers, $str);


$feedbacks = XML2Array::createArray($response);

$feedbacks = isset($feedbacks["GetFeedbackResponse"]['FeedbackDetailArray']['FeedbackDetail'])?$feedbacks["GetFeedbackResponse"]['FeedbackDetailArray']['FeedbackDetail']:array();

if (empty($feedbacks)) {
    print_r('error'); exit;
}


//print_r($feedbacks);exit;

$feedbackImages = array();

foreach ($feedbacks as $feedback) {
    $texts = array(
        "str1" => $feedback['CommentText'] . ', ' . date('M-d-y H:i', strtotime($feedback['CommentTime'])),
        "str2" => $feedback['CommentingUser'] . '(' . $feedback['CommentingUserScore'] .  ')',
        "str3" => $feedback['ItemTitle'] .  '(#' . $feedback['ItemID'] .  ')'
    );

    $textImages = array();

    foreach($texts as $name => $text) {

        $textData = array(
            'font' => "Arial",
            'text' => $text,
            'size' => 16,
            'colors' => array(
                'color1' => "black",
                'color2' => "black",
            ),
            'rotate' => 0,
        );

        if ($name == 'str3') {
            $textData['colors'] = array(
                'color1' => "grey",
                'color2' => "grey",
            );
        }

        $textImages[$name] = ImageMagick::createText($textData);
    }

    ImageMagick::addPlus($textImages['str1']);
    ImageMagick::addStar($textImages['str2'], $feedback['CommentingUserScore']);
    ImageMagick::disableTr(TEXT_TOOL_TEXT_PATH . $textImages['str3']);

    $feedbackImageName = md5($feedback['CommentText'].time()).'.png';
    $path = TEXT_TOOL_TMP_PATH . $feedbackImageName;
    ImageMagick::glue3ImagesVer(TEXT_TOOL_TEXT_PATH.$textImages['str1'], TEXT_TOOL_TEXT_PATH.$textImages['str2'], TEXT_TOOL_TEXT_PATH.$textImages['str3'], $path);
    $feedbackImages[] = $feedbackImageName;

    exit;




}

