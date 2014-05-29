<?php
require_once('config.php');

require_once ('lib/ebay.php');
require_once ('lib/cUrl.php');
require_once ('lib/xml.php');

$pages = 500;

$ebay = new Ebay($ebayDEVID, $ebayAppID, $ebayCertID, $ebayToken);
$allFeedbacks = array();

$header = array("CommentingUser","CommentingUserScore","CommentText","CommentTime","CommentType","ItemID","Role","FeedbackID","TransactionID","OrderLineItemID","ItemTitle","ItemPrice", "currencyID");

for ($i=1; $i<=$pages; $i++) {
    print_r($i);
    $orders = XML2Array::createArray($ebay->getCompleteOrders(10, $i));

    $orders = isset($orders["GetOrdersResponse"]['OrderArray']['Order'])?$orders["GetOrdersResponse"]['OrderArray']['Order']:array();
    print_r($orders);exit;

    if (!empty($feedbacks)) {
        foreach($feedbacks as $j => $feedback) {
            if (isset($feedback['ItemPrice'])) {
                $feedbacks[$j]['ItemPrice'] = $feedback['ItemPrice']['@value'];
                $feedbacks[$j]['currencyID'] = $feedback['ItemPrice']['@attributes']['currencyID'];
            }
            $tmp = array();
            foreach($header as $key) {
                $tmp[$key] = isset($feedbacks[$j][$key])?$feedbacks[$j][$key]:'';
            }
            $sql = "SELECT * FROM feedbacks where FeedbackID = {$tmp['FeedbackID']}";
            $rs = $db->Execute($sql);
            $row = $rs->FetchRow();
            if (isset($row['FeedbackID'])) {
                exit;
            }
            $updateSQL = $db->GetInsertSQL($rs, $tmp);

            $db->Execute($updateSQL);
        }
    } else {
        print_r('no f');exit;
    }


}

