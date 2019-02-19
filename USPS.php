<?php
/**
 * Created by PhpStorm.
 * User: reddingWebPro
 * Date: 2/28/2019
 * Version 1.0
 * Time: 7:05 PM
 */

namespace RedWebDev;

class USPS
{
    function __construct($api) {
        $this->api = $api;
    }
    public function getNormalized($address,$city,$state)
    {
        $api = $this->api;
        $input_xml = "<ZipCodeLookupRequest USERID=\"$api\"><Address ID= \"0\"><Address1>$address</Address1><City>$city</City><State>$state</State></Address></ZipCodeLookupRequest>";
        $fields = array(
            'API' => 'ZipCodeLookup',
            'XML' => $input_xml
        );
        $url = 'https://secure.shippingapis.com/ShippingAPI.dll?' . http_build_query($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        $data = curl_exec($ch);
        curl_close($ch);
        $array_data = json_decode(json_encode(simplexml_load_string($data)), true);
        return $array_data['Address'];
    }
}
