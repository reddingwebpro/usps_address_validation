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

// example code shown below:

require('USPS.php');
use RedWebDev\USPS;

$uspsZip = new USPS('YOUR_API_KEY_HERE');  // insert your api key from USPS

$address = '1600 Amphitheatre Parkway'; // address line is required
$city = 'Mountain View';
$state = 'CA';  //looking for the two character state

$return = $uspsZip->getNormalized($address, $city, $state);
echo "<ul>";
echo "<li>Address: " . $return['Address1'];
echo "<li>City: " . $return['City'];
echo "<li>State: " . $return['State'];
echo "<li>Zip: " . $return['Zip5'];
