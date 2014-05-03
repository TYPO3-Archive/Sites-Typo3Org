<?php
	// internal name for system (see pagetree)
$TYPO3_CONF_VARS['SYS']['sitename'] = '';

	// db connection data
$typo_db_username = '';
$typo_db_password = '';
$typo_db_host = '';
$typo_db = '';

$productionContext = FALSE;

	// add custom rootline fields in order to make this fields slideable by typoscript
$TYPO3_CONF_VARS['FE']['addRootLineFields'] = ',subtitle,author,keywords,description,tx_realurl_pathsegment,tx_realurl_exclude,tx_templavoila_ds,tx_templavoila_to,tx_templavoila_next_ds,tx_templavoila_next_to';

	// Frontend sessionTimeout
$TYPO3_CONF_VARS['FE']['lifetime'] = '604800';
//$TYPO3_CONF_VARS['FE']['cookieDomain'] = '.typo3.org';
$TYPO3_CONF_VARS['FE']['disableNoCacheParameter'] = '1';
$TYPO3_CONF_VARS['FE']['hidePagesIfNotTranslatedByDefault'] = '1';
$TYPO3_CONF_VARS['FE']['loginSecurityLevel'] = 'rsa';

	// Page not found handling
$TYPO3_CONF_VARS['FE']['pageNotFound_handling_statheader'] = 'HTTP/1.1 404 Not Found';
$TYPO3_CONF_VARS['FE']['pageNotFound_handling'] = 'USER_FUNCTION:tx_ajaxlogin_pagenotfoundhandler->handleError';
$TYPO3_CONF_VARS['FE']['pageUnavailable_handling'] = '/error_503.html';
$TYPO3_CONF_VARS['FE']['versionNumberInFilename'] = 'embed';
$TYPO3_CONF_VARS['FE']['cHashExcludedParametersIfEmpty'] = '*';

$TYPO3_CONF_VARS['EXTCONF']['ajaxlogin']['pageNotFound_handling'] = '/index.php?id=15';
$TYPO3_CONF_VARS['EXTCONF']['ajaxlogin']['unauthorized_handling'] = 'REDIRECT:/my-account/login/';
$TYPO3_CONF_VARS['EXTCONF']['ajaxlogin']['unauthorized_handling_statheader'] = 'HTTP/1.1 401 Unauthorized';

	// default System configuration

	// set to normal - but t3sec_saltedpasswd takes care of hasing
	/* Christian Zenker (2011-09-30):
	 * - saltedpswd (the sysext) requires rsa
	 * - t3sec_saltedpasswd seemed to be ok with "normal" security
	 */
$TYPO3_CONF_VARS['BE']['loginSecurityLevel'] = 'rsa';
$TYPO3_CONF_VARS['BE']['installToolPassword'] = 'f0263f26a9409df1a61156366543bce6';
$TYPO3_CONF_VARS['BE']['forceCharset'] = 'utf-8';
$TYPO3_CONF_VARS['BE']['sessionTimeout'] = '60000';
$TYPO3_CONF_VARS['BE']['explicitADmode'] = 'explicitAllow';
$TYPO3_CONF_VARS['BE']['unzip_path'] = 'unzip';
$TYPO3_CONF_VARS['BE']['elementVersioningOnly'] = '1';
$TYPO3_CONF_VARS['BE']['flexformForceCDATA'] = '1';
$TYPO3_CONF_VARS['BE']['allowDonateWindow'] = '0';
$TYPO3_CONF_VARS['BE']['versionNumberInFilename'] = '1';

$TYPO3_CONF_VARS['BE']['pageTree']['preloadLimit'] = '500';
# The next line is currently needed because of #25431. It can be removed on TYPO3 4.5.3 and later.
$GLOBALS['BE']['pageTree']['preloadLimit'] = '500';

	// set umask
$TYPO3_CONF_VARS['BE']['fileCreateMask'] = '0664';
$TYPO3_CONF_VARS['BE']['folderCreateMask'] = '02775';

$TYPO3_CONF_VARS['SYS']['encryptionKey'] = '2603cd41e53a29d7111386d12df8d87ce95851d8ea1de42060fe872f6c23c0f2d896f695c8b5a83746830fcc2ccd7a1e';
$TYPO3_CONF_VARS['SYS']['compat_version'] = '4.5';
$TYPO3_CONF_VARS['SYS']['setDBinit'] = 'SET NAMES utf8';
$TYPO3_CONF_VARS['SYS']['t3lib_cs_utils'] = 'iconv';
$TYPO3_CONF_VARS['SYS']['forceReturnPath'] = '1';
$TYPO3_CONF_VARS['SYS']['t3lib_cs_convMethod'] = 'iconv';
$TYPO3_CONF_VARS['SYS']['curlUse'] = '1';
$TYPO3_CONF_VARS['SYS']['no_pconnect'] = '1';
$TYPO3_CONF_VARS['SYS']['UTF8filesystem'] = '1';
$TYPO3_CONF_VARS['SYS']['maxFileNameLength'] = '120';
$TYPO3_CONF_VARS['SYS']['useCachingFramework'] = false;
$TYPO3_CONF_VARS['SYS']['recursiveDomainSearch'] = '1';

	// Image Configurations
$TYPO3_CONF_VARS['GFX']['im_path'] = '/usr/bin/';
$TYPO3_CONF_VARS['GFX']['im_combine_filename'] = 'combine';
$TYPO3_CONF_VARS['GFX']['im_version_5'] = 'gm';
$TYPO3_CONF_VARS['GFX']['TTFdpi'] = '96';
$TYPO3_CONF_VARS['GFX']['jpg_quality'] = '92';
$TYPO3_CONF_VARS['GFX']['gdlib_2'] = '1';
$TYPO3_CONF_VARS['GFX']['png_truecolor'] = '1';

	// debug settings
$TYPO3_CONF_VARS['SYS']['devIPmask'] = '127.0.0.1';
$TYPO3_CONF_VARS['SYS']['displayErrors'] = '0';
$TYPO3_CONF_VARS['SYS']['enableDeprecationLog'] = '1';
$TYPO3_CONF_VARS['SYS']['syslogErrorReporting'] = E_ALL & ~(E_STRICT|E_NOTICE|E_WARNING);
$TYPO3_CONF_VARS['SYS']['belogErrorReporting'] = E_ALL & ~(E_STRICT|E_NOTICE|E_WARNING);
$TYPO3_CONF_VARS['SYS']['systemLog'] = '';
$TYPO3_CONF_VARS['EXT']['extCache'] = '1';
$TYPO3_CONF_VARS['SYS']['sqlDebug'] = '0';
$TYPO3_CONF_VARS['FE']['debug'] = '0';

	// mailer settings
$TYPO3_CONF_VARS['MAIL']['defaultMailFromAddress'] = '';
$TYPO3_CONF_VARS['MAIL']['defaultMailFromName'] = '';
$TYPO3_CONF_VARS['MAIL']['transport'] = 'mail';
$TYPO3_CONF_VARS['MAIL']['transport_mbox_file'] = '';
$TYPO3_CONF_VARS['MAIL']['transport_sendmail_command'] = '/usr/sbin/sendmail -bs';
$TYPO3_CONF_VARS['MAIL']['transport_smtp_encrypt'] = '';
$TYPO3_CONF_VARS['MAIL']['transport_smtp_password'] = '';
$TYPO3_CONF_VARS['MAIL']['transport_smtp_server'] = 'localhost:25';
$TYPO3_CONF_VARS['MAIL']['transport_smtp_username'] = '';

	// binaries
$TYPO3_CONF_VARS['SYS']['binSetup'] = 'java = /usr/bin/java';

$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['tt_news_cache'] = array(
		'frontend' => 't3lib_cache_frontend_VariableFrontend',
		'backend' => 't3lib_cache_backend_DbBackend',
		'options' => array(
				'cacheTable' => 'tt_news_cache',
				'tagsTable' => 'tt_news_cache_tags',
		)
);

	// cachingFramework Settings
if ($productionContext) {
	// 0+1: core unit tests
	// 2...: production

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

	// Extension configuration part
$TYPO3_CONF_VARS['EXT']['noEdit'] = '1';
$TYPO3_CONF_VARS['EXT']['allowLocalInstall'] = '0';

$TYPO3_CONF_VARS['EXT']['extList'] = 'css_styled_content,tsconfig_help,context_help,extra_page_cm_options,impexp,belog,aboutmodules,felogin,setup,openid,opendocs,install,t3editor,rtehtmlarea,tstemplate,tstemplate_info,tstemplate_objbrowser,tstemplate_analyzer,func,func_wizards,wizard_crpages,wizard_sortpages,info,info_pagetsconfig,viewpage,beuser,lowlevel,reports,scheduler,rsaauth,saltedpasswords,t3skin,recycler,extbase,fluid,version,workspaces,filelist,perm';
$TYPO3_CONF_VARS['EXT']['extList_FE'] = 'extbase,fluid,css_styled_content,t3skin,install,rtehtmlarea,felogin,rsaauth,saltedpasswords';

$TYPO3_CONF_VARS['EXT']['extConf']['crawler'] = 'a:14:{s:9:"sleepTime";s:4:"1000";s:16:"sleepAfterFinish";s:2:"10";s:11:"countInARun";s:2:"50";s:14:"purgeQueueDays";s:2:"14";s:12:"processLimit";s:1:"4";s:17:"processMaxRunTime";s:3:"300";s:12:"processDebug";s:1:"0";s:16:"crawlHiddenPages";s:1:"1";s:7:"phpPath";s:13:"/usr/bin/php5";s:14:"enableTimeslot";s:1:"1";s:11:"logFileName";s:0:"";s:9:"follow30x";s:1:"0";s:18:"makeDirectRequests";s:1:"1";s:14:"maxCompileUrls";s:5:"10000";}';
$TYPO3_CONF_VARS['EXT']['extConf']['tt_news'] = 'a:20:{s:13:"useStoragePid";s:1:"1";s:17:"requireCategories";s:1:"0";s:18:"useInternalCaching";s:1:"1";s:11:"cachingMode";s:6:"normal";s:13:"cacheLifetime";s:1:"0";s:13:"cachingEngine";s:16:"cachingFramework";s:11:"treeOrderBy";s:5:"title";s:13:"prependAtCopy";s:1:"1";s:5:"label";s:5:"title";s:9:"label_alt";s:5:"short";s:10:"label_alt2";s:5:"short";s:15:"label_alt_force";s:1:"0";s:21:"categorySelectedWidth";s:1:"0";s:17:"categoryTreeWidth";s:1:"0";s:25:"l10n_mode_prefixLangTitle";s:1:"1";s:22:"l10n_mode_imageExclude";s:1:"1";s:20:"hideNewLocalizations";s:1:"0";s:24:"writeCachingInfoToDevlog";s:10:"disabled|0";s:23:"writeParseTimesToDevlog";s:1:"0";s:18:"parsetimeThreshold";s:3:"0.1";}';
$TYPO3_CONF_VARS['EXT']['extConf']['realurl'] = 'a:5:{s:10:"configFile";s:25:"typo3conf/realurlconf.php";s:14:"enableAutoConf";s:1:"0";s:14:"autoConfFormat";s:1:"0";s:12:"enableDevLog";s:1:"0";s:19:"enableChashUrlDebug";s:1:"0";}';
$TYPO3_CONF_VARS['EXT']['extConf']['scheduler'] = 'a:2:{s:11:"maxLifetime";s:4:"1440";s:11:"enableBELog";s:1:"0";}';
$TYPO3_CONF_VARS['EXT']['extConf']['phpunit'] = 'a:5:{s:18:"outoflinetestspath";s:0:"";s:17:"excludeextensions";s:51:"phpunit, templavoila, dam, aoe_realurlpath, crawler";s:7:"usepear";s:1:"0";s:10:"phpunitlib";s:0:"";s:33:"alwaysSimulateFrontendEnvironment";s:1:"1";}';
$TYPO3_CONF_VARS['EXT']['extConf']['static_info_tables'] = 'a:2:{s:7:"charset";s:5:"utf-8";s:12:"usePatch1822";s:1:"0";}';
$TYPO3_CONF_VARS['EXT']['extConf']['templavoila'] = 'a:2:{s:7:"enable.";a:2:{s:13:"oldPageModule";s:1:"0";s:16:"selectDataSource";s:1:"0";}s:9:"staticDS.";a:3:{s:6:"enable";s:1:"1";s:8:"path_fce";s:31:"EXT:t3org_base/templavoila/fce/";s:9:"path_page";s:32:"EXT:t3org_base/templavoila/page/";}}';	// Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['rsaauth'] = 'a:1:{s:18:"temporaryDirectory";s:38:"/var/www/t3org/integration/rsaAuthTmp/";}';
$TYPO3_CONF_VARS['EXT']['extConf']['saltedpasswords'] = 'a:2:{s:3:"FE.";a:5:{s:7:"enabled";s:1:"1";s:21:"saltedPWHashingMethod";s:31:"tx_saltedpasswords_salts_phpass";s:11:"forceSalted";s:1:"1";s:15:"onlyAuthService";s:1:"0";s:12:"updatePasswd";s:1:"0";}s:3:"BE.";a:5:{s:7:"enabled";s:1:"1";s:21:"saltedPWHashingMethod";s:31:"tx_saltedpasswords_salts_phpass";s:11:"forceSalted";s:1:"1";s:15:"onlyAuthService";s:1:"0";s:12:"updatePasswd";s:1:"0";}}';	// Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['scheduler'] = 'a:3:{s:11:"maxLifetime";s:4:"1440";s:11:"enableBELog";s:1:"0";s:13:"showTestTasks";s:1:"0";}';
$TYPO3_CONF_VARS['EXT']['extConf']['phpmyadmin'] = 'a:2:{s:12:"hideOtherDBs";s:1:"1";s:9:"uploadDir";s:21:"uploads/tx_phpmyadmin";}';
$TYPO3_CONF_VARS['EXT']['extConf']['rtehtmlarea'] = 'a:13:{s:21:"noSpellCheckLanguages";s:23:"ja,km,ko,lo,th,zh,b5,gb";s:15:"AspellDirectory";s:15:"/usr/bin/aspell";s:17:"defaultDictionary";s:2:"en";s:14:"dictionaryList";s:2:"en";s:20:"defaultConfiguration";s:105:"Typical (Most commonly used features are enabled. Select this option if you are unsure which one to use.)";s:12:"enableImages";s:1:"1";s:20:"enableInlineElements";s:1:"0";s:19:"allowStyleAttribute";s:1:"1";s:24:"enableAccessibilityIcons";s:1:"0";s:16:"enableDAMBrowser";s:1:"0";s:16:"forceCommandMode";s:1:"0";s:15:"enableDebugMode";s:1:"0";s:23:"enableCompressedScripts";s:1:"1";}';	//  Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['be_groups'] = 'a:1:{s:13:"explicitAllow";s:1:"0";}';
$TYPO3_CONF_VARS['EXT']['extConf']['dam_ttnews'] = 'a:2:{s:13:"media_add_ref";s:1:"1";s:20:"media_add_orig_field";s:1:"0";}';	// Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['dam'] = 'a:6:{s:8:"tsconfig";s:7:"default";s:13:"file_filelist";s:1:"0";s:15:"hideMediaFolder";s:1:"0";s:8:"mediatag";s:1:"1";s:15:"htmlAreaBrowser";s:1:"1";s:5:"devel";s:1:"0";}';	//  Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['css_filelinks'] = 'a:4:{s:16:"dont_default_css";s:1:"0";s:20:"allow_read_from_path";s:1:"0";s:11:"default_dam";s:1:"1";s:11:"pathtoicons";s:0:"";}';	// Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['dam_filelinks'] = 'a:7:{s:26:"ctype_media_add_orig_field";s:1:"0";s:15:"readFromPathDam";s:1:"0";s:11:"minElements";s:1:"0";s:11:"maxElements";s:2:"20";s:10:"allowedExt";s:0:"";s:22:"allowedExtReadFromPath";s:0:"";s:9:"dam_1_0_9";s:1:"1";}';	//  Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['dam_ttcontent'] = 'a:4:{s:28:"ctypes_textpic_image_add_ref";s:1:"1";s:35:"ctypes_textpic_image_add_orig_field";s:1:"1";s:19:"add_css_styled_hook";s:1:"1";s:17:"add_ws_mod_xclass";s:1:"1";}';	// Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['ter'] = 'a:1:{s:13:"repositoryDir";s:34:"/var/www/t3o/htdocs/fileadmin/ter/";}';	// Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['ter_fe'] = 'a:2:{s:7:"WSDLURI";s:41:"http://www.t3o.local/wsdl/tx_ter_wsdl.php";s:14:"SOAPServiceURI";s:37:"http://www.t3o.local/index.php?id=ter";}';	//  Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['ter_doc'] = 'a:6:{s:13:"repositoryDir";s:34:"/var/www/t3o/htdocs/fileadmin/ter/";s:12:"unzipCommand";s:46:"unzip -qq ###ARCHIVENAME### -d ###DIRECTORY###";s:10:"cliVerbose";s:1:"0";s:11:"logFullPath";s:0:"";s:14:"typoscriptFile";s:46:"EXT:ter_doc/Configuration/TypoScript/static.ts";s:10:"storagePid";s:3:"417";}';    //  Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['docondemand'] = 'a:3:{s:13:"repositoryDir";s:34:"/var/www/t3o/htdocs/fileadmin/ter/";s:12:"unzipCommand";s:46:"unzip -qq ###ARCHIVENAME### -d ###DIRECTORY###";s:11:"logFullPath";s:0:"";}';	// Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['tika'] = 'a:5:{s:9:"extractor";s:4:"solr";s:8:"tikaPath";s:0:"";s:8:"solrHost";s:25:"solr.t3o-relaunch-week.de";s:8:"solrPort";s:4:"8080";s:8:"solrPath";s:17:"/solr/deployment/";}';
$TYPO3_CONF_VARS['EXT']['extConf']['devlog'] = 'a:11:{s:10:"maxLogRuns";s:2:"15";s:14:"entriesPerPage";s:2:"25";s:7:"maxRows";s:4:"1000";s:8:"optimize";s:1:"0";s:8:"dumpSize";s:7:"1000000";s:11:"minLogLevel";s:2:"-1";s:11:"excludeKeys";s:0:"";s:14:"highlightStyle";s:60:"padding: 2px; background-color: #fc3; border: 1px solid #666";s:16:"refreshFrequency";s:1:"2";s:13:"prototypePath";s:0:"";s:11:"autoCleanup";s:1:"0";}';
$TYPO3_CONF_VARS['EXT']['extConf']['tika'] = 'a:7:{s:9:"extractor";s:4:"solr";s:8:"tikaPath";s:0:"";s:8:"solrHost";s:14:"192.168.20.110";s:8:"solrPort";s:4:"8080";s:8:"solrPath";s:15:"/solr/t3o_live/";s:10:"solrScheme";s:4:"http";s:11:"solrUseCurl";s:1:"0";}';
$TYPO3_CONF_VARS['EXT']['extConf']['pdf_generator2'] = 'a:3:{s:17:"simulateStaticPdf";s:1:"0";s:17:"disableGzipForPdf";s:1:"1";s:7:"typeNum";s:3:"123";}';	// Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['vimeo_connector'] = 'a:5:{s:3:"api";s:28:"http://vimeo.com/api/rest/v2";s:11:"consumerKey";s:32:"83dc97295d5e0a7bac63e23c4383650f";s:14:"consumerSecret";s:16:"e2a9e63f5dd2d6b6";s:11:"userAccount";s:11:"typo3videos";s:10:"storagePid";s:3:"447";}';
$TYPO3_CONF_VARS['EXT']['extConf']['powermail'] = 'a:8:{s:10:"usePreview";s:1:"1";s:12:"cssSelection";s:1:"1";s:14:"feusersPrefill";s:70:"name, address, telephone, fax, email, zip, city, country, www, company";s:12:"disableIPlog";s:1:"0";s:20:"disableBackendModule";s:1:"0";s:16:"disableStartStop";s:1:"0";s:7:"useIRRE";s:1:"1";s:12:"fileToolPath";s:9:"/usr/bin/";}';	//  Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['wt_spamshield'] = 'a:10:{s:12:"useNameCheck";s:1:"1";s:12:"usehttpCheck";s:1:"3";s:9:"notUnique";s:0:"";s:13:"honeypotCheck";s:1:"1";s:15:"useSessionCheck";s:1:"1";s:16:"SessionStartTime";s:2:"10";s:14:"SessionEndTime";s:4:"1800";s:10:"AkismetKey";s:0:"";s:12:"email_notify";s:0:"";s:3:"pid";s:2:"-1";}';
$TYPO3_CONF_VARS['EXT']['extConf']['js_css_optimizer'] = 'a:17:{s:10:"bundle_css";s:1:"1";s:9:"bundle_js";s:1:"1";s:13:"remove_bslash";s:1:"0";s:15:"compress_colors";s:1:"0";s:20:"compress_font-weight";s:1:"0";s:11:"lowercase_s";s:1:"0";s:19:"optimise_shorthands";s:1:"0";s:11:"remove_last";s:1:"0";s:15:"case_properties";s:1:"0";s:15:"sort_properties";s:1:"0";s:14:"sort_selectors";s:1:"0";s:15:"merge_selectors";s:1:"0";s:26:"discard_invalid_properties";s:1:"0";s:9:"css_level";s:6:"CSS2.1";s:12:"preserve_css";s:1:"1";s:9:"timestamp";s:1:"0";s:10:"charsetCSS";s:0:"";}';
$TYPO3_CONF_VARS['EXT']['extConf']['linkhandler'] = 'a:2:{s:32:"applyXclassHideSaveAndViewButton";s:1:"0";s:32:"applyXclassToEnableSoftrefParser";s:1:"0";}';
$TYPO3_CONF_VARS['EXT']['extConf']['typo3_agencies'] = 'a:2:{s:10:"storagePid";s:3:"329";s:14:"clearCachePids";s:7:"128,435";}';
$TYPO3_CONF_VARS['EXT']['extConf']['ter_fe'] = 'a:3:{s:7:"WSDLURI";s:37:"http://typo3.org/wsdl/tx_ter_wsdl.php";s:14:"SOAPServiceURI";s:34:""http://typo3.org/index.php?id=ter";s:13:"repositoryDir";s:57:"/var/www/vhosts/typo3.org/home/site/htdocs/fileadmin/ter/";}';
$TYPO3_CONF_VARS['EXT']['extConf']['purge'] = 'a:5:{s:15:"overrideDomains";s:9:"localhost";s:11:"expainsPids";s:0:"";s:16:"enablePurgeCalls";s:1:"1";s:27:"disableL10nmgrPurgeRequests";s:1:"0";s:28:"enableAsynchronousProcessing";s:1:"0";}';
$TYPO3_CONF_VARS['EXT']['extConf']['amqp'] = 'a:5:{s:8:"username";s:5:"admin";s:8:"password";s:5:"typo3";s:4:"host";s:11:"example.com";s:4:"port";s:4:"5672";s:5:"vhost";s:7:"vagrant";}';
## INSTALL SCRIPT EDIT POINT TOKEN - all lines after this points may be changed by the install script!
