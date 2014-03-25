<?php
require_once('config.php');

require_once ('lib/ebay.php');
require_once ('lib/cUrl.php');
require_once ('lib/xml.php');

$pages = 500;

$ebay = new Ebay($ebayDEVID, $ebayAppID, $ebayCertID, $ebayToken);
$allFeedbacks = array();

$header = array("CommentingUser","CommentingUserScore","CommentText","CommentTime","CommentType","ItemID","Role","FeedbackID","TransactionID","OrderLineItemID","ItemTitle","ItemPrice");
$sql = "SELECT 1 FROM feedbacks";
$rs = $db->Execute($sql);

for ($i=1; $i<=$pages; $i++) {
    print_r($i);
    $feedbacks = XML2Array::createArray($ebay->getFeedBacks(200, $i));
    $feedbacks = isset($feedbacks["GetFeedbackResponse"]['FeedbackDetailArray']['FeedbackDetail'])?$feedbacks["GetFeedbackResponse"]['FeedbackDetailArray']['FeedbackDetail']:array();

    if (!empty($feedbacks)) {
        foreach($feedbacks as $j => $feedback) {
            if (isset($feedback['ItemPrice'])) {
                $feedbacks[$j]['ItemPrice'] = $feedback['ItemPrice']['@value'] . ' ' . $feedback['ItemPrice']['@attributes']['currencyID'];
            }
            $tmp = array();
            foreach($header as $key) {
                $tmp[$key] = isset($feedbacks[$j][$key])?$feedbacks[$j][$key]:'';
            }

            $updateSQL = $db->GetInsertSQL($rs, $tmp);

            $db->Execute($updateSQL);
        }
    } else {
        print_r('no f');exit;
    }


}

