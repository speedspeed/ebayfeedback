<?php

require_once('config.php');

$csv = file_get_contents("2014-3-March-Paypal.csv");

$strings = explode("\n", $csv);
foreach($strings as $i => $str) {
    if ($i == 0) continue;
    list($tmp['date'], $tmp['time'], $tmp['time_zone'], $tmp['name'], $tmp['type'], $tmp['status'], $tmp['subject'], $tmp['currency'], $tmp['gross'], $tmp['fee'], $tmp['net'], $tmp['note'], $tmp['from_email_address'], $tmp['to_email_address'], $tmp['transaction_ID'], $tmp['payment_type'], $tmp['counterparty_status'], $tmp['shipping_address'], $tmp['address_status'], $tmp['item_title'], $tmp['item_ID'], $tmp['shipping_and_handling_amount'], $tmp['insurance_amount'], $tmp['sales_tax'], $tmp['option_1_name'], $tmp['option_1_value'], $tmp['option_2_name'], $tmp['option_2_value'], $tmp['auction_site'], $tmp['buyer_ID'], $tmp['item_URL'], $tmp['closing_date'], $tmp['reference_txn_ID'], $tmp['invoice_number'], $tmp['subscription_number'], $tmp['custom_number'], $tmp['receipt_ID'], $tmp['balance'], $tmp['address_line_1'], $tmp['address_line_2'], $tmp['city'], $tmp['state'], $tmp['zip'], $tmp['country'], $tmp['contact_phone_number'], $tmp['balance_impact']) = explode(',', $str);

    foreach($tmp as $key => $value) {
        $tmp[$key] = trim($value, '"');
    }

    $sql = "SELECT * FROM paypal_reports where 1 = 1";
    $rs = $db->Execute($sql);

    $updateSQL = $db->GetInsertSQL($rs, $tmp);
    $db->Execute($updateSQL);
    //exit;
}



