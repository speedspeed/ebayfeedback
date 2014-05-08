<?php
require_once('config.php');

require_once ('lib/ebay.php');
require_once ('lib/cUrl.php');
require_once ('lib/xml.php');

$pages = 10;

$ebay = new Ebay($ebayDEVID, $ebayAppID, $ebayCertID, $ebayToken);

for ($i=1; $i<=$pages; $i++) {
    print_r($i);
    $cases = XML2Array::createArray($ebay->getCases(200, $i));
    $cases = isset($cases["soapenv:Envelope"]["soapenv:Body"]["getUserCasesResponse"]["cases"]["caseSummary"])?$cases["soapenv:Envelope"]["soapenv:Body"]["getUserCasesResponse"]["cases"]["caseSummary"]:array();
    if (!empty($cases)) {
        foreach($cases as $j => $case) {
            if (isset($case['user']) && $case['user']['userId'] == "chandlermotorsportsinc" && $case['user']['role'] == "SELLER") {
                $case = XML2Array::createArray($ebay->getCaseDetails($case['caseId']['id'], $case['caseId']['type']));
                $case = isset($case["soapenv:Envelope"]["soapenv:Body"]["getEBPCaseDetailResponse"])?$case["soapenv:Envelope"]["soapenv:Body"]["getEBPCaseDetailResponse"]:array();

                if (!isset($case['caseSummary']['caseId']['id'])) {
                    continue;
                }

                $caseSummary = $case['caseSummary'];
                $caseDetail = isset($case['caseDetail'])?$case['caseDetail']:array();

                $tmp = array(
                    "caseId" => $caseSummary['caseId']['id'],
                    "type" => isset($caseSummary['caseId']['type'])?$caseSummary['caseId']['type']:'',
                    "userId" => isset($caseSummary['otherParty']['userId'])?$caseSummary['otherParty']['userId']:'',
                    "EBPSNADStatus" => isset($caseSummary['status']['EBPSNADStatus'])?$case['caseSummary']['status']['EBPSNADStatus']:'',
                    "itemId" => isset($caseSummary['item']['itemId'])?$caseSummary['item']['itemId']:'',
                    "respondByDate" => isset($caseSummary["respondByDate"])?$caseSummary["respondByDate"]:'',
                    "creationDate" => isset($caseSummary["creationDate"])?$caseSummary["creationDate"]:'',
                    "lastModifiedDate" => isset($caseSummary["lastModifiedDate"])?$caseSummary["lastModifiedDate"]:'',
                    "openReason" => isset($caseDetail["openReason"])?$caseDetail["openReason"]:'',
                    "decision" => isset($caseDetail["decision"])?$caseDetail["decision"]:'',
                    "agreedRefundAmount" => isset($caseDetail["agreedRefundAmount"])?$caseDetail["agreedRefundAmount"]:'',
                    "detailStatus" => isset($caseDetail["detailStatus"])?$caseDetail["detailStatus"]:'',
                    "initialBuyerExpectation" => isset($caseDetail["initialBuyerExpectation"])?$caseDetail["initialBuyerExpectation"]:''
                );

                $sql = "SELECT * FROM cases where caseId = {$tmp['caseId']}";
                $rs = $db->Execute($sql);
                $row = $rs->FetchRow();
                if (isset($row['caseId'])) {
                    exit;
                }
                $updateSQL = $db->GetInsertSQL($rs, $tmp);

                $db->Execute($updateSQL);

            }


        }
    } else {
        print_r('no cases');exit;
    }


}

