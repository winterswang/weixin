<?php
define("TOKEN", "jia2052013");
$echoStr = $_GET["echostr"];

if(checkSignature())
{
	echo $echoStr;
}

function checkSignature()
{
	$signature = $_GET["signature"];
	$timestamp = $_GET["timestamp"];
	$nonce = $_GET["nonce"];

	$token = TOKEN;
	$tmpArr = array($token, $timestamp, $nonce);
	sort($tmpArr);
	$tmpStr = implode( $tmpArr );
	$tmpStr = sha1( $tmpStr );

	if( $tmpStr == $signature ){
		return true;
	}else{
		return false;
	}
}

?>