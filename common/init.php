<?php
	//define web application context root path variable
	define('UNICORN_ROOT', (isset($_SERVER['HTTPS']) ? "https" : "http"). "://".$_SERVER['HTTP_HOST']."/CS5281Unicorn");

	//define document root path variable
	define('UNICORN_DOC_ROOT', $_SERVER['DOCUMENT_ROOT']."/CS5281Unicorn");
	
?>