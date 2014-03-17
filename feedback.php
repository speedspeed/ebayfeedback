<?php
require_once('config.php');

require_once ('lib/ebay.php');
require_once ('lib/cUrl.php');
require_once ('lib/xml.php');
require_once ('lib/imagemagick.class.php');

$ebay = new Ebay($ebayDEVID, $ebayAppID, $ebayCertID, $ebayToken);
$fbNumber = isset($_GET['number'])?(int)$_GET['number']:5;

$feedbacks = XML2Array::createArray($ebay->getFeedBacks($fbNumber));

$feedbacks = isset($feedbacks["GetFeedbackResponse"]['FeedbackDetailArray']['FeedbackDetail'])?$feedbacks["GetFeedbackResponse"]['FeedbackDetailArray']['FeedbackDetail']:array();

if (empty($feedbacks)) {
    print_r('error'); exit;
}

ImageMagick::deleteOldFiles(TEXT_TOOL_TMP_PATH);

$feedbackImages = array();

foreach ($feedbacks as $feedback) {
    $texts = array(
        "str1" => $feedback['CommentText'] . ', ' . date('M-d-y H:i', strtotime($feedback['CommentTime'])),
        "str2" => $feedback['CommentingUser'] . ' (' . $feedback['CommentingUserScore'] .  ')',
        "str3" => ' '.$feedback['ItemTitle'] .  ' (#' . $feedback['ItemID'] .  ')'
    );

    $textImages = array();

    foreach($texts as $name => $text) {

        $textData = array(
            'font' => "Arial",
            'text' => $text,
            'size' => 16,
            'color' => "black",
            'rotate' => 0,
        );

        if ($name == 'str3') {
            $textData['color'] = "gray";
        }

        $textImages[$name] = ImageMagick::createText($textData);
    }

    ImageMagick::addPlus($textImages['str1']);
    ImageMagick::addStar($textImages['str2'], $feedback['CommentingUserScore']);
    ImageMagick::addBorder(TEXT_TOOL_TEXT_PATH . $textImages['str1'], 3);
    ImageMagick::addBorder(TEXT_TOOL_TEXT_PATH . $textImages['str2'], 3);
    ImageMagick::addBorder(TEXT_TOOL_TEXT_PATH . $textImages['str3'], 3);

    $feedbackImageName = md5($feedback['CommentText'].time()).'.png';
    $path = TEXT_TOOL_TMP_PATH . $feedbackImageName;
    ImageMagick::glueImagesVer(array(TEXT_TOOL_TEXT_PATH.$textImages['str1'], TEXT_TOOL_TEXT_PATH.$textImages['str2'], TEXT_TOOL_TEXT_PATH.$textImages['str3']), $path);
    ImageMagick::addBorder($path, 5);
    $feedbackImages[] = TEXT_TOOL_TMP_PATH.$feedbackImageName;
    if (count($feedbackImages) == $fbNumber) {
        break;
    }
}

$feedbacksImageName = md5(rand(0,100000).time()).'.png';
$path = TEXT_TOOL_TMP_PATH . $feedbacksImageName;
ImageMagick::glueImagesVer($feedbackImages, $path);

ImageMagick::addBorder($path, 5);
?>
<img src="tmp/<?=$feedbacksImageName?>" width="500px">
<br>
Send image to Social Networks:
<br>
<form method="POST" action="send.php">
    <input type="hidden" name="file" value="<?=$feedbacksImageName?>">
    <label>Facebook</label>
    <input type="checkbox" value="1" name="facebook">
    <br>
    <label>Twitter</label>
    <input type="checkbox" value="1" name="twitter">
    <br>
    <input type="submit" value="Send">
</form>
