<?php
//load RSA library
include 'Crypt/RSA.php';
//initialize RSA
$rsa = new Crypt_RSA();
//decode & get POST parameters
$payment = base64_decode($_POST ["payment"]);
$signature = base64_decode($_POST ["signature"]);
$custom_fields = base64_decode($_POST ["custom_fields"]);
//load public key for signature matching
// $publickey = "-----BEGIN PUBLIC KEY-----
// MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCvLjaQKOblsZfepcOkvUwDBr0z
// QqcCtsfD29RtYdJ8lL5Wj+kmF8OiIjXbQeSIgzmkdUejguTLS3PHqUjYb1ElFaLQ
// CxW5oUWCwFSNYPUaVe+6wa/j6JfFTfsx4lvJHDIWeIBDrZMZ/wS6YTU+BnMvFhFj
// JaT9Q/mwtnxHdD0dbQIDAQAB
// -----END PUBLIC KEY-----";

$publickey = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDRg2S31xYCmYHXB2S3Duh+0ESq
e/U8DdQ0bqNQs7q041cwh/7bz7bAgjfGawbntBT2Lx9STUc0uga9Pa8RpfPmIoZi
A4U6OMCIinAiePfxbVHx+K3qEYv2w5PeH70+pk+OhySQrnOm11SMnjR1pewbWwE2
hboMuuBBDt0s/CV7WQIDAQAB
-----END PUBLIC KEY-----";
$rsa->loadKey($publickey);
//verify signature
$signature_status = $rsa->verify($payment, $signature) ? TRUE : FALSE;
//get payment response in segments
//payment format: order_id|order_refference_number|date_time_transaction|payment_gateway_used|status_code|comment;
$responseVariables = explode('|', $payment);       

if($signature_status == true)
{
	//display values
	echo $signature_status .'<br/>';
	$custom_fields_varible = explode('|', $custom_fields);
	
     $newURL="http://localhost:3000/#/response";
     header('Location: '.$newURL.'/'.json_encode(['response'=>$responseVariables[4]]));

}else
{
	echo 'Error Validation'; 
}
	
?>