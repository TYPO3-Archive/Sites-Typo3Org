<?php
$productionContext = '';
/* Christian Zenker (2011-09-30):
* - saltedpswd (the sysext) requires rsa
* - t3sec_saltedpasswd seemed to be ok with "normal" security
*/
$GLOBALS['BE']['pageTree']['preloadLimit'] = '500';
$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['tt_news_cache'] = array(
	'frontend' => 't3lib_cache_frontend_VariableFrontend',
	'backend' => 't3lib_cache_backend_DbBackend',
	'options' => array(
		'cacheTable' => 'tt_news_cache',
		'tagsTable' => 'tt_news_cache_tags',
	)
);
if ($productionContext) {
$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['cache_pages'] = array(
	'frontend' => 't3lib_cache_frontend_VariableFrontend',
	'backend' => 't3lib_cache_backend_RedisBackend',
	'options' => array (
	'database' => 2,
	'compression' => TRUE,
),
);
$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['cache_pagesection'] = array(
	'frontend' => 't3lib_cache_frontend_VariableFrontend',
	'backend' => 't3lib_cache_backend_RedisBackend',
	'options' => array (
	'database' => 3,
	'compression' => TRUE,
),
);
$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['cache_hash'] = array(
	'frontend' => 't3lib_cache_frontend_VariableFrontend',
	'backend' => 't3lib_cache_backend_RedisBackend',
	'options' => array (
	'database' => 4,
),
);
$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['cache_extbase_reflection'] = array(
	'frontend' => 't3lib_cache_frontend_VariableFrontend',
	'backend' => 't3lib_cache_backend_RedisBackend',
	'options' => array (
	'database' => 5,
),
);
$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['cache_extbase_object'] = array(
	'frontend' => 't3lib_cache_frontend_VariableFrontend',
	'backend' => 't3lib_cache_backend_RedisBackend',
	'options' => array (
	'database' => 6,
),
);
/*
* Double check the number of available databases in redis.conf before uncommenting this one
*/
/*
$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['tt_news_cache'] = array(
	'frontend' => 't3lib_cache_frontend_VariableFrontend',
	'backend' => 't3lib_cache_backend_RedisBackend',
	'options' => array (
		'database' => 7,
	),
);
*/
}
?>