<?php
/*
 *  Example Class
 *  Comment : You can see transactions of your wallet
 *  Author : gitshinesun
 */

class Example 
{	
	//api key and secret
	public $api_key = "1234567890abcdef";
	public $api_secret = "1234567890abcdefghijklmnopqrstuv";

	public function __construct()
	{
		parent::__construct();
		
		//load bigto library
		$this->load->library('CoinbaseSDK');
	}

	public function index()
	{
		
		//set token and endpoint
		$this->CoinbaseSDK->set_init($api_key, $api_secret);

		//list transactions
		$result = $this->CoinbaseSDK->GetTransactions();

		var_dump($result);
	}
}

?>