<?php
require_once('config.php');

require_once ('lib/ebay.php');
require_once ('lib/cUrl.php');
require_once ('lib/xml.php');


$ebay = new Ebay($ebayDEVID, $ebayAppID, $ebayCertID, $ebayToken);

$cases = XML2Array::createArray($ebay->getCases(100));
print_r($cases["soapenv:Envelope"]["soapenv:Body"]["getUserCasesResponse"]['cases']["caseSummary"]);
exit;
//$case = XML2Array::createArray($ebay->getCaseDetails(562217998,	"PAYPAL_SNAD"));

print_r($case["soapenv:Envelope"]["soapenv:Body"]["getEBPCaseDetailResponse"]);
