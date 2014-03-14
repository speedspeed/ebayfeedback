<?php
require_once ('lib/cUrl.php');

$token = "AgAAAA**AQAAAA**aAAAAA**sh0jUw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wDkICgCZaDowSdj6x9nY+seQ**QigCAA**AAMAAA**CM5ukzqlgmRmzd7ez0L+Gjjf+wxed+eeSsjiOuWKip2lyRbGbbnOR8DIfpOgLBu9vthXmgzYR5R1JcgEyDETJQ1t095o9q4IDd0Ez6D8/XqJeSCtWl+n9542eNrLpNKl04OVBNjrFAqhcllfBDRYUriNz1JfmeGQJVX5iaE8sGfnu10hvyBoQ9WxyvHkQ0CFXxVPOQipPPkyP8LdqvAMJlnLOTyxx5eYYGjsLrdM0dxJqBQA55MC3Bv8SNLY3cxJfNJUSr6nIhLLzJmWobikckCGyr+ASLDATNAGQx8PwVXsgAgthHj0PvMLHdGCZNdzEmnFpV4Wu0TB0HgtnJdrM/oEUAGY1JYgCLoOjfGwDVnMtY0amm/KSXOeNV7mNfPp9AnfxLipBsk3BD8Q9AZpvSyBvWw/i0nBnS6MIlsbfXkE0Y68KxYB7UGJeS1GNK3q4hMt6UsriXL60qM/B0liRkPjG4WM7KZGQH6vOGYNFIkgCUroxNZUcaKpQYt1sprdDMGzcpDEUpBZBHJuAjRhAJBHAB76O8qK+JGxO3cT5O57S9O9CNolbG1pz3p7NM/FdhKI8or3z9r3RudJctUvn+/P3bP7v5QD8mmc/GS3Vu/QAShq7z05ff3PXi0NveOl/b8zq9+T044FE+AaSMkEDq3noJSGujHjKhie7Ei6QVMBlUN7paThjWvEjFq9/obmahpQUV5wguYwMcmNmycpFgXpblZdnLyahdk1lfCH/zp0qhw9NsGQOg/35JQEOQSy";
$serverURL = "https://api.ebay.com/ws/api.dll";
$service = "FeedbackService";

//Add the request headers
$basicHeaders = array (
    "X-EBAY-API-COMPATIBILITY-LEVEL:863",
    "X-EBAY-API-DEV-NAME:G1D6H1F51LPC75V715818MBNS15FJ5",
    "X-EBAY-API-APP-NAME:Chandler-62db-42de-a6f5-9de7e39ec71e",
    "X-EBAY-API-CERT-NAME:4827cc52-fb15-4756-9a78-ce04fceae1cf",
    "X-EBAY-API-SITEID:0",
    "X-EBAY-API-CALL-NAME:GetFeedback",
);

$str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<GetFeedbackRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
<RequesterCredentials>
<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**sh0jUw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wDkICgCZaDowSdj6x9nY+seQ**QigCAA**AAMAAA**CM5ukzqlgmRmzd7ez0L+Gjjf+wxed+eeSsjiOuWKip2lyRbGbbnOR8DIfpOgLBu9vthXmgzYR5R1JcgEyDETJQ1t095o9q4IDd0Ez6D8/XqJeSCtWl+n9542eNrLpNKl04OVBNjrFAqhcllfBDRYUriNz1JfmeGQJVX5iaE8sGfnu10hvyBoQ9WxyvHkQ0CFXxVPOQipPPkyP8LdqvAMJlnLOTyxx5eYYGjsLrdM0dxJqBQA55MC3Bv8SNLY3cxJfNJUSr6nIhLLzJmWobikckCGyr+ASLDATNAGQx8PwVXsgAgthHj0PvMLHdGCZNdzEmnFpV4Wu0TB0HgtnJdrM/oEUAGY1JYgCLoOjfGwDVnMtY0amm/KSXOeNV7mNfPp9AnfxLipBsk3BD8Q9AZpvSyBvWw/i0nBnS6MIlsbfXkE0Y68KxYB7UGJeS1GNK3q4hMt6UsriXL60qM/B0liRkPjG4WM7KZGQH6vOGYNFIkgCUroxNZUcaKpQYt1sprdDMGzcpDEUpBZBHJuAjRhAJBHAB76O8qK+JGxO3cT5O57S9O9CNolbG1pz3p7NM/FdhKI8or3z9r3RudJctUvn+/P3bP7v5QD8mmc/GS3Vu/QAShq7z05ff3PXi0NveOl/b8zq9+T044FE+AaSMkEDq3noJSGujHjKhie7Ei6QVMBlUN7paThjWvEjFq9/obmahpQUV5wguYwMcmNmycpFgXpblZdnLyahdk1lfCH/zp0qhw9NsGQOg/35JQEOQSy</eBayAuthToken>
</RequesterCredentials>
<CommentType>Positive</CommentType>
<Pagination>
<EntriesPerPage>100</EntriesPerPage>
<PageNumber>1</PageNumber>
</Pagination>
<DetailLevel>ReturnAll</DetailLevel>
<Version>863</Version>
</GetFeedbackRequest>​​";

$response = request($serverURL, $basicHeaders, $str);

//return the response
print_r($response);exit;


/*
$dateFrom = "2014-01-01T00:00:00.000Z";
$dateTo = "2014-03-10T00:00:00.000Z";
$strReq = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
$strReq .=  "<createDSRSummaryByPeriodRequest xmlns=\"http://www.ebay.com/marketplace/services\">";
$strReq .=  "<dateRange>";
$strReq .=  "<dateFrom>" . $dateFrom . "</dateFrom>";
$strReq .=  "<dateTo>" . $dateTo . "</dateTo></dateRange>";
$strReq .=  "</createDSRSummaryByPeriodRequest>";


$createHeaders = $basicHeaders;
$createHeaders[] = "X-EBAY-SOA-OPERATION-NAME: createDSRSummaryByPeriod";

$response = request($serverURL, $createHeaders, $strReq);
*/
//get jobID <?xml version='1.0' encoding='UTF-8'? ><createDSRSummaryResponse xmlns="http://www.ebay.com/marketplace/services"><ack>Success</ack><version>1.2.2</version><timestamp>2014-03-14T15:49:13.631Z</timestamp><jobId>23705360456361324601</jobId></createDSRSummaryResponse>

$jobId = "23705360456361324601";

$getHeaders = $basicHeaders;
$getHeaders[] = "X-EBAY-SOA-OPERATION-NAME: getDSRSummary";

$strReq = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
$strReq .=  "<getDSRSummaryRequest xmlns=\"http://www.ebay.com/marketplace/services\">";
$strReq .=  "<jobId>".$jobId."</jobId>";
$strReq .=  "</getDSRSummaryRequest>";

$response = request($serverURL, $getHeaders, $strReq);

//return the response
print_r($response);exit;



