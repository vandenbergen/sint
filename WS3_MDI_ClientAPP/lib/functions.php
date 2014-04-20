<?php

function my_curl_PUT($data_string, $url)
{
	$ch = curl_init($url);                                                                     
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function my_curl_POST($data_string, $url)
{
	$ch = curl_init($url);                                                                     
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
				
function my_curl_DELETE($path)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$path);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $result;
}

function curl_del($path, $json='')
{
    $url = $this->__url.$path;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $result = json_decode($result);
    curl_close($ch);

    return $result;
} 

?>