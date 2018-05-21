<?php
/*
 *  CoinbaseSDK Class
 *  Author : gitshinesun
 */

class CoinbaseSDK 
{

	private $API_KEY = "";
	private $API_SECRET = "";
	private $API_ENDPOINT = "https://coinbase.com/api/v1/";

    public function __construct() {
        $this->_ci = & get_instance();
    }

    public function set_init($api_key, $api_secret)
    {
        $this->API_KEY = $apikey;
		$this->API_SECRET = $apisecret;
    }

    public function GenerateNewAddress($parameters)
    {
        $result = $this->MakeRequest("account/generate_receive_address", "post", $parameters);
        return $result;
    }

    public function GetAccountAddresses()
    {
        $results = $this->MakeRequest("addresses", "get", false);
        return $results;
    }

    public function GetBalance()
    {
        $results = $this->MakeRequest("account/balance", "get", false);
        return $results;
    }

    public function GetTransactions()
    {
        $results = $this->MakeRequest("transactions", "get", false);
        return $results;
    }

	public function MakeRequest($directory, $request, $parameters)
	{
		$nonce = file_get_contents("nonce.txt") + 1;
		file_put_contents("nonce.txt", $nonce, LOCK_EX);

		$url =  $this->API_ENDPOINT . $directory . "&";

		if($parameters != ""){
			$parameters = http_build_query(json_decode($parameters), true);
		}

		$signature = hash_hmac("sha256", $nonce . $url . $parameters, $this->API_SECRET);

		$ch = curl_init();

		curl_setopt_array($ch, array(	CURLOPT_URL => $url,
										CURLOPT_HTTPHEADER => array(
										"ACCESS_KEY: " . $this->API_KEY,
										"ACCESS_NONCE: " . $nonce,
										"ACCESS_SIGNATURE: " . $signature)));

		if($request == "post"){
			curl_setopt_array($ch, array(CURLOPT_POSTFIELDS => $parameters,
										 CURLOPT_POST => true));
		}

		$results = curl_exec($ch);
		curl_close($ch);

		return $results;
	}
}
