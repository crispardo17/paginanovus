<?php

print_r($_GET);
print_r($_POST);
$curl = curl_init();

/** Inicia sesion en epayco y obtiene el token de seguridad */
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apify.epayco.co/login',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic ZDQ1ZjkwMDYwNTY2NGRmNWNiMjU1ZjY3ZTY0NzY1MDc6ZjY4M2YyYmU0ZTgzNmY5NWEyZmYwNjMyMzFmZjVjODY='
  ),
));
  
$response = curl_exec($curl);
$response = json_decode($response);    
$token = $response->token;  

$curl = curl_init();

/** Confirma el estado de la transacción */
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apify.epayco.co/payment/pse/transaction',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "transactionID":725987441640034589
} ',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer '. $token
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo "Confirmación<pre><br>";
$response = json_decode($response);    
print_r($response);


?>