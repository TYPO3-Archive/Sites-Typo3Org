<?php

error_reporting(E_ALL & ~E_NOTICE);

require('api-keys.php');

define('PATH_thisScript', str_replace('//', '/', str_replace('\\', '/',
	(PHP_SAPI == 'fpm-fcgi' || PHP_SAPI == 'cgi' || PHP_SAPI == 'isapi' || PHP_SAPI == 'cgi-fcgi') &&
	(!empty($_SERVER['ORIG_PATH_TRANSLATED']) ? $_SERVER['ORIG_PATH_TRANSLATED'] : $_SERVER['PATH_TRANSLATED']) ?
	(!empty($_SERVER['ORIG_PATH_TRANSLATED']) ? $_SERVER['ORIG_PATH_TRANSLATED'] : $_SERVER['PATH_TRANSLATED']) :
	(!empty($_SERVER['ORIG_SCRIPT_FILENAME']) ? $_SERVER['ORIG_SCRIPT_FILENAME'] : $_SERVER['SCRIPT_FILENAME']))));

define('PATH_site', dirname(PATH_thisScript).'/');

	// db connection
require(PATH_site . '../typo3conf/localconf.php');
define ('TYPO3_DB_NAME', $typo_db);
define ('TYPO3_DB_HOST', $typo_db_host);
define ('TYPO3_DB_USERNAME', $typo_db_username);
define ('TYPO3_DB_PASSWORD', $typo_db_password);

	// no user serviceable parts below...
if (empty($_SERVER['HTTPS'])) {
	syslog(LOG_WARNING, 'userinfo.php: This service must be called through a SSL connection!');
	header('HTTP/1.0 403 Forbidden');
	die('Not using HTTPS');
}

if (isset($apiKeys[$_SERVER['HTTP_X_FORWARDED_FOR']]) && $apiKeys[$_SERVER['HTTP_X_FORWARDED_FOR']] === $_GET['apiKey']) {
	echo json_encode(getUserData());
} else {
	syslog(LOG_NOTICE, 'userinfo.php: API key for remote address ' . $_SERVER['HTTP_X_FORWARDED_FOR'] . ' not found or invalid.');
	header('HTTP/1.0 403 Forbidden');
	die('Invalid token');
}

function getUserData() {
	$userData = array();
	mysql_select_db(TYPO3_DB_NAME, mysql_connect(TYPO3_DB_HOST, TYPO3_DB_USERNAME, TYPO3_DB_PASSWORD));
	mysql_query('SET NAMES utf8');
	$result = mysql_query('SELECT username, email, name, tx_t3ocla_hassignedcla FROM fe_users WHERE username = \'hudson\' OR lastlogin > ' . ($_SERVER['REQUEST_TIME'] - (86400 * 90)));
	while ($row = mysql_fetch_assoc($result)) {
		$userData[] = $row;
	}
	return $userData;
}

?>
