<?php

$curl = curl_init();

//API CREDENTIALS
$clientId = "ARSqHC295J546ZD6NANrJMi7ZS7YCJhQaQc1qDBwwKY1Aqxkm0YuiSxvBGHzZH4iWMPNynrAu0SeKw-o";
$secret = "ELenJV_oi9daE2HEZc3HgjO5grCa3DfiUxYuZNg7OSHbOKFU0uncjckPVxzCEThTB-sKqrAgeNbTm86E";

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/oauth2/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "grant_type=client_credentials",
  CURLOPT_USERPWD => $clientId . ":" . $secret,
  CURLOPT_HEADER => false,
  CURLOPT_HTTPHEADER => array(
    "Accept: application/json",
    "Accept-Language: en_US",

  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);


if ($err) {
  echo "<pre>cURL Error #:" . $err . "</pre>";
} else {

  $response = json_decode($response);
  $access_token = $response->access_token;
}
?>