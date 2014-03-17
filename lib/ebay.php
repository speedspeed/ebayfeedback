<?php

class Ebay {

    private $baseHeaders = array();
    private $ebayToken = null;
    private $ebayServerURL = "https://api.ebay.com/ws/api.dll";

public function __construct($ebayDEVID, $ebayAppID, $ebayCertID, $ebayToken)
{
    $this->baseHeaders = array (
        "X-EBAY-API-COMPATIBILITY-LEVEL:863",
        "X-EBAY-API-DEV-NAME:".$ebayDEVID,
        "X-EBAY-API-APP-NAME:".$ebayAppID,
        "X-EBAY-API-CERT-NAME:".$ebayCertID,
        "X-EBAY-API-SITEID:0",
    );

    $this->ebayToken = $ebayToken;
}

public function getFeedBacks($number = 100, $page = 1, $type = "Positive")
{
    $headers = $this->baseHeaders;
    $headers[] = "X-EBAY-API-CALL-NAME:GetFeedback";

    $str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<GetFeedbackRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
<RequesterCredentials>
<eBayAuthToken>".$this->ebayToken."</eBayAuthToken>
</RequesterCredentials>
<CommentType>".$type."</CommentType>
<Pagination>
<EntriesPerPage>".$number."</EntriesPerPage>
<PageNumber>".$page."</PageNumber>
</Pagination>
<DetailLevel>ReturnAll</DetailLevel>
<Version>863</Version>
</GetFeedbackRequest>​​";

    return request($this->ebayServerURL, $headers, $str);
}
}