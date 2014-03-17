<?php
require_once('config.php');

require_once ('lib/ebay.php');
require_once ('lib/cUrl.php');
require_once ('lib/xml.php');

$pages = 5;

$ebay = new Ebay($ebayDEVID, $ebayAppID, $ebayCertID, $ebayToken);
$allFeedbacks = array();
$getNeutral = 1;
$getNegative = 1;
for ($i=1; $i<=$pages; $i++) {
    if ($getNeutral) {
        $feedbacks = XML2Array::createArray($ebay->getFeedBacks(200, $i, 'Neutral'));
        $feedbacks = isset($feedbacks["GetFeedbackResponse"]['FeedbackDetailArray']['FeedbackDetail'])?$feedbacks["GetFeedbackResponse"]['FeedbackDetailArray']['FeedbackDetail']:array();
        if (!empty($feedbacks)) {
            foreach($feedbacks as $i => $feedback) {
                if (isset($feedback['ItemPrice'])) {
                    $feedbacks[$i]['ItemPrice'] = $feedback['ItemPrice']['@value'] . ' ' . $feedback['ItemPrice']['@attributes']['currencyID'];
                }
                $allFeedbacks[] = $feedbacks[$i];
            }
        } else {
            $getNeutral = 0;
        }
    }
    if($getNegative) {
        $feedbacks = XML2Array::createArray($ebay->getFeedBacks(200, $i, 'Negative'));
        $feedbacks = isset($feedbacks["GetFeedbackResponse"]['FeedbackDetailArray']['FeedbackDetail'])?$feedbacks["GetFeedbackResponse"]['FeedbackDetailArray']['FeedbackDetail']:array();
        if (!empty($feedbacks)) {
            foreach($feedbacks as $i => $feedback) {
                if (isset($feedback['ItemPrice'])) {
                    $feedbacks[$i]['ItemPrice'] = $feedback['ItemPrice']['@value'] . ' ' . $feedback['ItemPrice']['@attributes']['currencyID'];
                }
                $allFeedbacks[] = $feedbacks[$i];
            }
        } else {
            $getNegative  = 0;
        }
    }
    //
}

function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}

function array2csv(array &$array)
{
    if (count($array) == 0) {
        return null;
    }
    ob_start();
    $df = fopen("php://output", 'w');
    fputcsv($df, array_keys(reset($array)));
    foreach ($array as $row) {
        fputcsv($df, $row);
    }
    fclose($df);
    return ob_get_clean();
}

download_send_headers("feedback_export_" . date("Y-m-d") . ".csv");
echo array2csv($allFeedbacks);
die();