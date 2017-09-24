<?php
return array(
	'id' => 'auth:kirche-oldesloe.de', # notrans
	'version' => '0.9',
	'name' => /* trans */ 'kirche-oldesloe.de Authentication',
	'author' => 'Lars Knickrehm',
	'description' => /* trans */ 'Allows for the kirche-oldesloe.de server to perform the authentication of the user. osTicket will match the username from the server authentication to a username defined internally.',
	'url' => 'http://kirche-oldesloe.de/',
	'plugin' => 'authentication.php:KircheOldesloeDeAuthPlugin'
);
?>