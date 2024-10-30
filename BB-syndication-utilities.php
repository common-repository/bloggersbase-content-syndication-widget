<?php

function xBBSWWGetPage($url, $postData = null)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	if(!ini_get('safe_mode')) {
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	}
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_REFERER, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; it; rv:1.9.0.6; .NET CLR 3.0; ffco7) Gecko/2009011913 Firefox/3.0.6");

	if ($postData != null) {
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_POST, true);
	}

	$response = curl_exec($ch);
	curl_close($ch);
	unset($ch);

	return $response;
}

?>