<?php
/**
 * Copyright (c) 2019-2023. ReddingWebPro / Jason J. Olson, This program is free software: you can redistribute it and/or
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
 * Version 2.0
 * Date: 3/6/2019 (rev. 9/19/23)
 */

namespace RedWebDev\src;

class USPS
{

    private string $key;
    private string $secret;

    function __construct(string $key, string $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    private function getOauthV3Token(): string
    {
        $fields['client_id'] = $this->key;
        $fields['client_secret'] = $this->secret;
        $fields['grant_type'] = "client_credentials";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.usps.com/oauth2/v3/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));

        $json = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($json, true);

        return $data['access_token'];
    }

    public function getNormalized($address, $city, $state): array
    {
        $token = $this->getOauthV3Token();
        $authorization = "Authorization: Bearer ".$token;
        $userID = "x-user-id: ".$this->key;

        $fields = array(
            'streetAddress' => $address,
            'city' => $city,
            'state' => $state,
        );

        $url = 'https://api.usps.com/addresses/v3/address?'.http_build_query($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $userID, $authorization));
        $json = curl_exec($ch);
        curl_close($ch);

        return json_decode($json, true);
    }
}
