<?php

$ebayDEVID = "G1D6H1F51LPC75V715818MBNS15FJ5";
$ebayAppID = "Chandler-62db-42de-a6f5-9de7e39ec71e";
$ebayCertID = "4827cc52-fb15-4756-9a78-ce04fceae1cf";
$ebayToken = "AgAAAA**AQAAAA**aAAAAA**sh0jUw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wDkICgCZaDowSdj6x9nY+seQ**QigCAA**AAMAAA**CM5ukzqlgmRmzd7ez0L+Gjjf+wxed+eeSsjiOuWKip2lyRbGbbnOR8DIfpOgLBu9vthXmgzYR5R1JcgEyDETJQ1t095o9q4IDd0Ez6D8/XqJeSCtWl+n9542eNrLpNKl04OVBNjrFAqhcllfBDRYUriNz1JfmeGQJVX5iaE8sGfnu10hvyBoQ9WxyvHkQ0CFXxVPOQipPPkyP8LdqvAMJlnLOTyxx5eYYGjsLrdM0dxJqBQA55MC3Bv8SNLY3cxJfNJUSr6nIhLLzJmWobikckCGyr+ASLDATNAGQx8PwVXsgAgthHj0PvMLHdGCZNdzEmnFpV4Wu0TB0HgtnJdrM/oEUAGY1JYgCLoOjfGwDVnMtY0amm/KSXOeNV7mNfPp9AnfxLipBsk3BD8Q9AZpvSyBvWw/i0nBnS6MIlsbfXkE0Y68KxYB7UGJeS1GNK3q4hMt6UsriXL60qM/B0liRkPjG4WM7KZGQH6vOGYNFIkgCUroxNZUcaKpQYt1sprdDMGzcpDEUpBZBHJuAjRhAJBHAB76O8qK+JGxO3cT5O57S9O9CNolbG1pz3p7NM/FdhKI8or3z9r3RudJctUvn+/P3bP7v5QD8mmc/GS3Vu/QAShq7z05ff3PXi0NveOl/b8zq9+T044FE+AaSMkEDq3noJSGujHjKhie7Ei6QVMBlUN7paThjWvEjFq9/obmahpQUV5wguYwMcmNmycpFgXpblZdnLyahdk1lfCH/zp0qhw9NsGQOg/35JQEOQSy";

$ebayServerURL = "https://api.ebay.com/ws/api.dll";


define('TEXT_TOOL_PATH', dirname(__FILE__) . '/');
define('TEXT_TOOL_TMP_PATH', TEXT_TOOL_PATH . 'tmp/');
define('TEXT_TOOL_ORG_PATH', TEXT_TOOL_TMP_PATH . 'original/');
define('TEXT_TOOL_PRV_PATH', TEXT_TOOL_TMP_PATH . 'preview/');
define('TEXT_TOOL_TEXT_PATH', TEXT_TOOL_TMP_PATH . 'text/');
define('EBAY_IMAGES_PATH', dirname(__FILE__) . '/ebay_images/');

set_include_path(TEXT_TOOL_PATH . '/lib' . PATH_SEPARATOR. get_include_path());

define('TEXT_TOOL_TEXTEFFECT_PATH', TEXT_TOOL_PATH . 'lib/texteffect');