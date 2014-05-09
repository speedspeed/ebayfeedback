<?php

require_once('config.php');

$csv = file_get_contents("customers_report.csv");

$strings = explode("\n", $csv);
foreach($strings as $i => $str) {
    if ($i == 0) continue;
    list($order_source, $account, $txn_id, $txn_id2, $date, $payment_type, $payment_auth_info, $first_name, $last_name, $payer_email, $contact_phone, $address_country, $address_state, $address_zip, $address_city, $address_street, $address_street2, $total, $shipping, $tax, $discount, $fee, $ship_date, $carrier, $method, $tracking, $postage, $num_order_lines, $items, $qtys, $skus, $subtotals)
        = explode(',', $str);

    $tmp = array(
        'order_source' => $order_source,
        'account' => $account,
        'txn_id' => $txn_id,
        'txn_id2' => $txn_id2,
        'date' => $date,
        'payment_type' => $payment_type,
        'payment_auth_info' => $payment_auth_info,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'payer_email' => $payer_email,
        'contact_phone' => $contact_phone,
        'address_country' => $address_country,
        'address_state' => $address_state,
        'address_zip' => $address_zip,
        'address_city' => $address_city,
        'address_street' => $address_street,
        'address_street2' => $address_street2,
        'total' => $total,
        'shipping' => $shipping,
        'tax' => $tax,
        'discount' => $discount,
        'fee' => $fee,
        'ship_date' => $ship_date,
        'carrier' => $carrier,
        'method' => $method,
        'tracking' => $tracking,
        'postage' => $postage,
        'num_order_lines' => $num_order_lines,
        'items' => $items,
        'qtys' => $qtys,
        'skus' => $skus,
        'subtotals' => $subtotals,
    );

    foreach($tmp as $key => $value) {
        $tmp[$key] = trim($value, '"');
    }

    $sql = "SELECT * FROM customer_reports where 1 = 1";
    $rs = $db->Execute($sql);

    $updateSQL = $db->GetInsertSQL($rs, $tmp);
    $db->Execute($updateSQL);
    //exit;
}



