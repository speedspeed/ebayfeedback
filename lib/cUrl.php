<?php
    function request($url, $headers, $str)
    {
        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $url);    // grab URL and pass it to the browser

        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);

//set the headers using the array of headers
        curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);

//set method as POST
        curl_setopt($connection, CURLOPT_POST, 1);

//set the XML body of the request
        curl_setopt($connection, CURLOPT_POSTFIELDS, $str);

//set it to return the transfer as a string from curl_exec
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);

//Send the Request
        $response = curl_exec($connection);

//close the connection
        curl_close($connection);

        return $response;
    }