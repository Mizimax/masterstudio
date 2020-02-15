<?php


	namespace App\Services;

	require_once dirname(dirname(__FILE__)) . '/omise/lib/Omise.php';
	define('OMISE_PUBLIC_KEY', 'pkey_test_5ikuyw9bd25g1ku53mh');
	define('OMISE_SECRET_KEY', 'skey_test_5ikuyw9bnjlgv3iwmev');
	define('OMISE_API_VERSION', '2019-05-29');

	class Omise
	{
		public static function charge(Array $data)
		{
			return \OmiseCharge::create($data);
		}
	}