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
    $orders = XML2Array::createArray($ebay->getCompleteOrders(100, $i));

    $orders = isset($orders["GetOrdersResponse"]['OrderArray']['Order'])?$orders["GetOrdersResponse"]['OrderArray']['Order']:array();
    //print_r($orders);exit;

    if (!empty($orders)) {
        print_r("orders: ".count($orders) . "\n");
        foreach($orders as $j => $order) {

            $sql = "SELECT * FROM orders where OrderID = '".$order['OrderID']."'";
            $rs = $db->Execute($sql);
            $row = $rs->FetchRow();
            if (isset($row['OrderID'])) {
                print_r("order: ".$row['OrderID'] . " exists" . "\n");
                continue;
            }

            $tmp = array(
                "OrderID" => $order['OrderID'],
                "AmountPaid" => $order["AmountPaid"]['@value'] . ' ' . $order["AmountPaid"]['@attributes']['currencyID'],
                "CreatedTime" =>$order['CreatedTime'],
                "PaymentMethods" => $order['PaymentMethods'],
                "ItemID" => $order['TransactionArray']['Transaction']['Item']['ItemID'],
                "QuantityPurchased" => $order['TransactionArray']['Transaction']['QuantityPurchased'],
                "TransactionID" => $order['TransactionArray']['Transaction']['TransactionID'],
                "BuyerUserID" => $order['BuyerUserID']
            );

            $updateSQL = $db->GetInsertSQL($rs, $tmp);

            $db->Execute($updateSQL);
        }
    } else {
        print_r('no orders');exit;
    }


}

