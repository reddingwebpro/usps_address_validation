<?php
/**
 * Created by PhpStorm.
 * User: reddingWebPro
 * Date: 2/18/2019
 * Version 1.0
 * Time: 7:05 PM
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
