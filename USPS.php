<?php
/**
 * Copyright (c) 2019. ReddingWebPro / Jason J. Olson, This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by the Free Software Foundation version 3
 * of the License.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License
 * for more details. You should have received a copy of the GNU General Public License along with this program.  If not,
 * see <https://www.gnu.org/licenses/>.
 */

/**
 * Created by ReddingWebPro/ReddingWebDev
 * User: Jason J. Olson
 * License: GNU GPLv3
 * GitHub: https://github.com/reddingwebpro/usps_address_validation
 * Date: 3/6/2019
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
        return $array_data;
    }
}
