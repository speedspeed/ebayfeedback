<?php

class Ebay
{

    private $baseHeaders = array();
    private $ebayToken = null;
    private $ebayServerURL = "https://api.ebay.com/ws/api.dll";

    public function __construct($ebayDEVID, $ebayAppID, $ebayCertID, $ebayToken)
    {
        $this->baseHeaders = array(
            "X-EBAY-API-COMPATIBILITY-LEVEL:863",
            "X-EBAY-API-DEV-NAME:" . $ebayDEVID,
            "X-EBAY-API-APP-NAME:" . $ebayAppID,
            "X-EBAY-API-CERT-NAME:" . $ebayCertID,
            "X-EBAY-API-SITEID:0",
        );

        $this->ebayToken = $ebayToken;
    }

    public function getFeedBacks($number = 100, $page = 1, $type = null)
    {
        $headers = $this->baseHeaders;
        $headers[] = "X-EBAY-API-CALL-NAME:GetFeedback";

        $str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<GetFeedbackRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
<RequesterCredentials>
<eBayAuthToken>" . $this->ebayToken . "</eBayAuthToken>
</RequesterCredentials>";

        if ($type) {
            $str .= "<CommentType>" . $type . "</CommentType>";
        }
        $str .= "<Pagination>
<EntriesPerPage>" . $number . "</EntriesPerPage>
<PageNumber>" . $page . "</PageNumber>
</Pagination>
<DetailLevel>ReturnAll</DetailLevel>
<Version>863</Version>
</GetFeedbackRequest>​​";

        return request($this->ebayServerURL, $headers, $str);
    }

    public function getCases($number = 200, $page = 1)
    {
        $url = "https://svcs.ebay.com/services/resolution/ResolutionCaseManagementService/v1";

        $headers = array(
            "X-EBAY-SOA-SERVICE-NAME:ResolutionCaseManagementService",
            "X-EBAY-SOA-OPERATION-NAME:getUserCases",
            "X-EBAY-SOA-SERVICE-VERSION:1.1.0",
            "X-EBAY-SOA-SECURITY-TOKEN:{$this->ebayToken}",
            "X-EBAY-SOA-REQUEST-DATA-FORMAT:XML",
            "X-EBAY-SOA-MESSAGE-PROTOCOL: SOAP12",
            "X-EBAY-SOA-GLOBAL-ID: EBAY-US",
            "Content-Type: application/soap+xml"
    );

        $str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
            <soap:Envelope xmlns:soap=\"http://www.w3.org/2003/05/soap-envelope\"
               xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
               xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">
            <soap:Body>
                <getUserCasesRequest xmlns=\"http://www.ebay.com/marketplace/resolution/v1/services\">
                    <paginationInput>
                        <pageNumber>$page</pageNumber>
                        <entriesPerPage>$number</entriesPerPage>
                    </paginationInput>
                </getUserCasesRequest>
            </soap:Body>
        </soap:Envelope>";
        return request($url, $headers, $str);
    }

    public function getCaseDetails($id, $type)
    {
        $url = "https://svcs.ebay.com/services/resolution/ResolutionCaseManagementService/v1";

        $headers = array(
            "X-EBAY-SOA-SERVICE-NAME:ResolutionCaseManagementService",
            "X-EBAY-SOA-OPERATION-NAME:getEBPCaseDetail",
            "X-EBAY-SOA-SERVICE-VERSION:1.1.0",
            "X-EBAY-SOA-SECURITY-TOKEN:{$this->ebayToken}",
            "X-EBAY-SOA-REQUEST-DATA-FORMAT:XML",
            "X-EBAY-SOA-MESSAGE-PROTOCOL: SOAP12",
            "X-EBAY-SOA-GLOBAL-ID: EBAY-US",
            "Content-Type: application/soap+xml"
        );

        $str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
            <soap:Envelope xmlns:soap=\"http://www.w3.org/2003/05/soap-envelope\"
               xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
               xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">
            <soap:Body>
                <getEBPCaseDetailRequest xmlns=\"http://www.ebay.com/marketplace/resolution/v1/services\">
                    <caseId>
                        <id>$id</id>
                        <type>$type</type>
                    </caseId>
                </getEBPCaseDetailRequest>
            </soap:Body>
        </soap:Envelope>";

        return request($url, $headers, $str);
    }


    public function getCompleteOrders($number = 200, $page = 1)
    {
        $headers = $this->baseHeaders;
        $headers[] = "X-EBAY-API-CALL-NAME:GetOrders";

        $from = date('Y-m-d', strtotime('-90 days'));
        $to = date('Y-m-d');

        $str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<GetOrdersRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
    <RequesterCredentials>
        <eBayAuthToken>".$this->ebayToken."</eBayAuthToken>
    </RequesterCredentials>
    <CreateTimeFrom>".$from."</CreateTimeFrom>
    <CreateTimeTo>".$to."</CreateTimeTo>
    <OrderRole>Seller</OrderRole>
    <OrderStatus>Completed</OrderStatus>
    <Pagination>
        <EntriesPerPage>" . $number . "</EntriesPerPage>
        <PageNumber>" . $page . "</PageNumber>
    </Pagination>
    <Version>869</Version>
</GetOrdersRequest>​​";


        return request($this->ebayServerURL, $headers, $str);
    }
}