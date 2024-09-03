<?php 
	//----------------------------------------------------------------------------------//	
	//                               COMPULSORY SETTINGS
	//----------------------------------------------------------------------------------//
	
	/*  Set the URL to your Sendy installation (without the trailing slash) */
	define('APP_PATH', 'https://your_sendy_installation_url');
	
	/*  MySQL database connection credentials (please place values between the apostrophes) */
	$dbHost = 'localhost'; //MySQL Hostname
	$dbUser = 'lawsmart_root'; //MySQL Username
	$dbPass = '4(xE}snlIP.w85po'; //MySQL Password
	$dbName = 'lawsmart_agricopel'; //MySQL Database Name
	
	
	//----------------------------------------------------------------------------------//	
	//								  OPTIONAL SETTINGS
	//----------------------------------------------------------------------------------//	
	
	/* 
		Change the database character set to something that supports the language you'll
		be using. Example, set this to utf16 if you use Chinese or Vietnamese characters
	*/
	$charset = 'utf8mb4';
	
	/*  Set this if you use a non standard MySQL port.  */
	$dbPort = 3306;	
	
	/*  Domain of cookie (99.99% chance you don't need to edit this at all)  */
	define('COOKIE_DOMAIN', 'https://www.lawsmart.online/sendy');
	
	//----------------------------------------------------------------------------------//
?>