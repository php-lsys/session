<?php
return array(
	'native'=>array(
		'handler'=>\LSYS\Session\Native::class,
		'name'=>ini_get("session.name"),
		'lifetime'=>ini_get("session.cookie_lifetime"),
		'domain'=>ini_get("session.cookie_domain"),
		'path'=>ini_get("session.cookie_path"),
		'secure'=>ini_get("session.cookie_secure"),
		'httponly'=>ini_get("session.cookie_httponly"),
	)	
);
