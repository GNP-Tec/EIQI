<?php

	date_default_timezone_set('UTC');
	//Datenbank-Einstellungen
	$hs_db_user="eiqi";
	$hs_db_pass="fBTvStW2vqy62KhS";
	$hs_db_name="eiqi";
	$hs_db_host="localhost";
	$hs_db_type="mysql";

	//Benutzer-Einstellungen

	define("HS_TEMP_GROUP",2);
	define("HS_TEMP_NAME","temp-user");

	define("HS_REG_ENABLED",1);
	define("HS_REG_TIMEOUT",20);
	define("HS_REG_DEFAULT_GROUP",1);
	//define("HS_REG_DEFAULT_LANG", "german");
	
	define("HS_REG_ADDRESS",1);
	define("HS_REG_REAL_NAME",1);
	define("HS_REG_UNLOCK",0);

	define("HS_LOGIN_TIMEOUT",3600);

	define("HS_ERR_ADDR",-2);
	define("HS_ERR_NAME",-3);
	define("HS_ERR_EMAIL",-4);
	define("HS_ERR_DB",-1);

	define("HS_ERR_USER",-5);
	define("HS_ERR_TIMEOUT",-6);
	define("HS_ERR_LANG", -7);
	define("HS_ERR_TIMEZONE", -8);
	define("HS_ERR",1);
	define("HS_ERR_AUTH",2);
	

?>
