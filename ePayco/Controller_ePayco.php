
<?php
include("../forms/conexion.php");
$reg = "";
$factura = rand(10000000, 900000000000);
$data = array();
$ip = $_SERVER['REMOTE_ADDR'];
$token = getTokenePayco();
$reg = $_REQUEST['reg'];
$reg = base64_decode($reg);
$resp = epayco($conn, $reg);
$datos = $resp->fetch();
$datosTarjeta = " ";

/** Inicia sesion en epayco y obtiene el token de seguridad */
function getTokenePayco()
{
    $curl = curl_init();
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
    curl_close($curl);
    $response = json_decode($response);
    $token = $response->token;
    return $token;
}

/** Obtiene los bancos de pse */
function getBanks($token)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://apify.epayco.co/payment/pse/banks',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response);
    return $response;
}

// Si recibe el boton del formulario genera la transacción
if (isset($_POST['btnEnviar'])) {
    if (strcmp($_POST['tipoPago'], 'pse') == 0) {
        print_r($_POST['tipoPago']);
        transactionPSE($token, $factura, $ip, $datos);
    } else {

        validacionCard($token, $datos, $ip, $_POST, $conn, $reg);
    }
}

/** Crea transacción por PSE */
function transactionPSE($token, $factura, $ip, $datos)
{
    $data = [
        'codBank' => $_POST['bancoId'],
        'value' => 50000,
        'docType' => $datos["tipodocumento"],
        'docNumber' =>  $datos["documentoCliente"],
        'name' =>  $datos["nombres"],
        'lastName' => $datos["apellidos"],
        'email' =>  $datos["correoElectronico"],
        'cellPhone' =>  $datos["celular1"],
        'description' => 'Pruebas Legal',
        'factura' => $factura,
        'urlResponse' => 'http://192.168.180.37:81/GRUPONOVUS%20PAGINA/GrupoNovus/ePayco/pp.php'
    ];

    $token = getTokenePayco();
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://apify.epayco.co/payment/process/pse',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
                "bank": "' . $data['codBank'] . '",
                "value": "' . $data['value'] . '",
                "docType": "' . $data['docType'] . '",
                "docNumber": "' . $data['docNumber'] . '",
                "name": "' . $data['name'] . '",
                "lastName": "' . $data['lastName'] . '",
                "email": "' . $data['email'] . '",
                "cellPhone": "' . $data['cellPhone'] . '",
                "ip": "' . $ip . '",
                "urlResponse": "' . $data['urlResponse'] . '",                                
                "description": "' . $data['description'] . '",
                "invoice": "' . $data['factura'] . '",
                "currency": "COP",
                "typePerson": 1,
                "address": "Cr86#56-415",                
                "urlConfirmation": "http://192.168.180.37:81/GRUPONOVUS%20PAGINA/GrupoNovus/ePayco/pp.php",
                "methodConfimation": "GET",
                "extra1": "",
                "extra2": "",
                "extra3": ""
            }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response);

    if ($response->titleResponse != 'Error') {
        //Guardar en la base y despues confirmar con confirmation.php o confirmTransactionPSE()
        $transactionID = $response->data->transactionID;
        $url = $response->data->urlbanco;
        header("Location: $url");
    } else {
        echo "Error<br><pre>";
        var_dump($response);
    }
}

/** Confirma transacción por PSE */
function confirmTransactionPSE($token, $transactionID)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://apify.epayco.co/payment/pse/transaction',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => "{
                'transactionID': $transactionID
            } ",
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));
    $response = curl_exec($curl);

    curl_close($curl);
    $response = json_decode($response);
    echo "Confirmación<pre><br>";
    print_r($response);
}
function Actualizarpago($conn, $reg)
{

    $procesos = Obtenerproceso($conn, $reg);
    print_r("<pre>");
    foreach ($procesos as $proceso) {
        $sql = "UPDATE  proceso set estadoId= 3 where procesoId=" . $proceso['procesoId'];
        //print_r($sql);
        $conn->query($sql);
        $almacenado = $conn->prepare(" CALL legal.asignarabogado(:procesoId);");

        $almacenado->execute([":procesoId" => $proceso['procesoId']]);
    };
}
function guardartransaccion($conn, $reg, $response)
{
    $factura = Obtenerfactura($conn, $reg);
    $factura = $factura->fetch();
    $idfactura = $factura['facturaId'];


    $epayco = json_decode($response)->data->transaction->data;
    echo "<pre>";
    print_r($factura);


    $sql = "INSERT INTO transaccion (facturaId,fechaTransaccion,estado,valorTransaccion,medioPagoId,ref_payco,iva,ico,baseiva,autorizacion,recibo,ticketId,transactionID,ip) 
     VALUES(:facturaId, now(),:estado,:valorTransaccion,:medioPagoId,:ref_payco,:iva,:ico ,	:baseiva, :autorizacion, :recibo,:ticketId,:transactionID,:ip);' ";
    $insert = $conn->prepare($sql);

    $insert->execute([
        ':facturaId'            => $idfactura,
        ':estado'                 => $epayco->cod_respuesta,
        ':valorTransaccion'     => $epayco->valor,
        ':medioPagoId'            => 1,
        ':ref_payco'            => $epayco->ref_payco,
        ':iva'                  => $epayco->iva,
        ':ico'                  => $epayco->ico,
        ':baseiva'              => $epayco->baseiva,
        ':autorizacion'         => $epayco->autorizacion,
        ':recibo'               => $epayco->recibo,
        ':ticketId'             => $epayco->factura,
        ':transactionID'        => isset($epayco->transactionID) ? $epayco->transactionID : null,
        ':ip'                   => $epayco->ip,

    ]);
}



function createCard($token, $datosTarjeta)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://apify.epayco.co/token/card',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
        "cardNumber":"' . $datosTarjeta['numTarjeta'] . '",
        "cardExpYear":"' . $datosTarjeta['expiracionAnno'] . '",
        "cardExpMonth":"' . $datosTarjeta['expiracionMes'] . '",
        "cardCvc":"' . $datosTarjeta['cvc'] . '"
    }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);
    return json_decode($response)->data->id;
}
/** validacon tarjeta*/
function validacionCard($token, $datos, $ip, $datosTarjeta, $conn, $reg)
{
    $token = getTokenePayco();
    if (!isset($datos["tokenTarjeta"])) {

        $tokencard = createCard($token, $datosTarjeta);
        $tokenSql = "update cliente set tokenTarjeta='" . $tokencard . "' where documentoCliente= " . $datos['documentoCliente'];
      
        $conn->query($tokenSql);
    } else {
        $tokencard = $datos["tokenTarjeta"];
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://apify.epayco.co/payment/process',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
              "value":"5000",
              "docType": "' .  $datos['tipodocumento'] . '",
              "docNumber":"' .  $datos['documentoCliente'] . '",
              "name": "' .  $datos['nombres'] . '",
              "lastName": "' .  $datos['apellidos'] . '",
              "email": "' .  $datos['correoElectronico'] . '",
              "cellPhone":"' .  $datos['celular1'] . '",
              "phone":"' .  $datos['celular1'] . '",
              "cardNumber":"' .  $datosTarjeta['numTarjeta'] . '",
              "cardExpYear":"' .  $datosTarjeta['expiracionAnno'] . '",
              "cardExpMonth":"' .  $datosTarjeta['expiracionMes'] . '",
              "cardCvc":"' .  $datosTarjeta['cvc'] . '",
              "dues":"' .  $datosTarjeta['cuotas'] . '",
              "ip": "' . $ip . '",
              "_cardTokenId":"' . $tokencard . '"
          }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;
    guardartransaccion($conn, $reg, $response);
    $epayco = json_decode($response)->data->transaction->data;
    //   if( $epayco->cod_respuesta==1){

    Actualizarpago($conn, $reg);

    // }
}
