<?php
function callApi(){
	
    $curl = curl_init();

	$url = "http://localhost/api-senac-php/api.php/ping";
	$url = "https://apisenac2022.herokuapp.com/api.php/auxilios";
    
	curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "x-api-key: BE406D16ABFB8AB03A6AC07C25EBFA9E0D05DB778E0E679F214A13180530D46E1E62D206D4DF7FF8397B18DEFBE3847334809E314AAD2607E15DE7F9597CC990"
        ],
    ]);
	
	$aDadosParam = new stdClass();
	$aDadosParam->codigoibge = "4214805";
	$aDadosParam->mesano = "202101";
	$aDadosParam->pagina = "1";
	
	
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($aDadosParam)); 
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 



    $response = curl_exec($curl);
	
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
	   $aDados = json_decode($response);
	   echo "<pre>" . print_r($aDados, true) . "</pre>";	   
    }	
}

callApi();