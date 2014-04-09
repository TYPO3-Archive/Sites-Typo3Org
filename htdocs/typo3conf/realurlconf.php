<?php
$realurlconf = array (
	'init' => array (
		'enableCHashCache' => 1,
		'appendMissingSlash' => 'ifNotFile',
		'enableUrlDecodeCache' => 1,
		'enableUrlEncodeCache' => 1,
		'respectSimulateStaticURLs' => 0,
		'emptyUrlReturnValue' => '/',
	),

	'redirects_regex' => array (),

	'preVars' => array (
		array (
			'GETvar' => 'L',
			'noMatch' => 'bypass'
		)
	),

	'pagePath' => array (
		'type' => 'user',
		'userFunc' => 'EXT:realurl/class.tx_realurl_pagepath.php:&tx_realurl_pagepath->main',
		'spaceCharacter' => '-',
		'cacheTimeOut' => '0',
		'languageGetVar' => 'L',
		'rootpage_id' => '17',	/* honeypot pid - this page is not visible using the backend!*/
		'segTitleFieldList' => 'tx_realurl_pathsegment,alias,nav_title,title,subtitle'
	),

	'postVarSets' => array (
		'_DEFAULT' => array ( // news archive parameters
			'archive' => array (
				array (
					'GETvar' => 'tx_ttnews[year]'
				),
				array (
					'GETvar' => 'tx_ttnews[month]',
					'valueMap' => array (
						'january' => '01',
						'february' => '02',
						'march' => '03',
						'april' => '04',
						'may' => '05',
						'june' => '06',
						'july' => '07',
						'august' => '08',
						'september' => '09',
						'october' => '10',
						'november' => '11',
						'december' => '12'
					)
				)
			),  // news pagebrowser
			'browse' => array (
				array (
					'GETvar' => 'tx_ttnews[pointer]'
				)
			),  // used for security bulletin xml
			'security' => array (
				array (
					'GETvar' => 'tx_ttnews[security]'
				)
			),  // news categories
			'select_category' => array (
				array (
					'GETvar' => 'tx_ttnews[cat]'
				)
			),  // news articles and searchwords
			'article' => array (
				'0' => array (
					'GETvar' => 'tx_ttnews[tt_news]',
					'lookUpTable' => array (
						'table' => 'tt_news',
						'id_field' => 'uid',
						'languageGetVar' => 'L',
						'transOrigPointerField' => 'l18n_parent',
						'languageField' => 'sys_language_uid',
						'alias_field' => "title",
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array (
							'defineSpaceCharacters' => ' -+',
							'strtolower' => 1,
							'spaceCharacter' => '-'
						),
						'enable404forInvalidAlias' => TRUE,
					)
				),
				'1' => array (
					'GETvar' => 'tx_ttnews[swords]'
				)
			),

			// ter extensions
			'repository' => array (
				'0' => array (
					'GETvar' => 'tx_terfe_pi1[view]'
				),
				'1' => array (
					'GETvar' => 'tx_terfe_pi1[showExt]'
				),
				'2' => array (
					'GETvar' => 'tx_terfe_pi1[version]'
				)
			),
			'page' => array(
				'0' => array(
					'GETvar' => 'tx_terfe2_pi1[__widget_0][currentPage]'
				)
			),

			'ter_search' => array(
				'0' => array(
					'GETvar' => 'tx_terfe2_pi1[search][sorting]',
					'valueMap' => array(
						'title' => 'title',
						'downloads' => 'downloads',
						'updated' => 'updated'
					),
					'noMatch' => 'bypass'
				),
				'1' => array(
					'GETvar' => 'tx_terfe2_pi1[search][needle]'
				)
			),

			// snippet details
			'sd' => array(
				'0' => array(
					'GETvar' => 'tx_pastecode_pi1[code]'
				)
			),
			// snippet page
			'sp' => array(
				'0' => array(
					'GETvar' => 'tx_pastecode_pi1[page]'
				)
			),
			// snippet tag
			'st' => array(
				'0' => array(
					'GETvar' => 'tx_pastecode_pi1[tag]'
				)
			),
			// snippet author
			'sa' => array(
				'0' => array(
					'GETvar' => 'tx_pastecode_pi1[autho]'
				)
			),

			'fluid-widget' => array(
				array(
					'GETvar' => 'fluid-widget-id',
				)
			),
			'page' => array(
				array (
					'GETvar' => 'tx_typo3agencies_pi1[page]',
				)
			)
		),
		'435' => array(
			'category' => array(array(
				'GETvar' => 'tx_typo3agencies_pi1[category]',
				'lookUpTable' => array (
					'table' => 'tx_typo3agencies_domain_model_category',
					'id_field' => 'uid',
					'alias_field' => "title",
					'useUniqueCache' => 1,
					'useUniqueCache_conf' => array (
						'defineSpaceCharacters' => ' -+',
						'strtolower' => 1,
						'spaceCharacter' => '_'
					),
				),
				'valueDefault' => 'all'
			)),
			'industry' => array(array(
				'GETvar' => 'tx_typo3agencies_pi1[industry]',
				'lookUpTable' => array (
					'table' => 'tx_typo3agencies_domain_model_industry',
					'id_field' => 'uid',
					'alias_field' => "title",
					'useUniqueCache' => 1,
					'useUniqueCache_conf' => array (
						'defineSpaceCharacters' => ' -+',
						'strtolower' => 1,
						'spaceCharacter' => '_'
					),
				),
				'valueDefault' => 'all'
			)),
			'revenue' => array(array(
				'GETvar' => 'tx_typo3agencies_pi1[revenue]',
				'lookUpTable' => array (
					'table' => 'tx_typo3agencies_domain_model_revenue',
					'id_field' => 'uid',
					'alias_field' => "title",
					'useUniqueCache' => 1,
					'useUniqueCache_conf' => array (
						'defineSpaceCharacters' => ' -+',
						'strtolower' => 1,
						'spaceCharacter' => '_'
					),
				),
				'valueDefault' => 'all'
			)),
			'fortune500-listing' => array(array(
				'GETvar' => 'tx_typo3agencies_pi1[listed]',
				'valueMap' => array(
					'ignore' => 0,
					'required' => 1
				),
				'noMatch' => 'bypass'
			)),
			'afterwardsReturnTo' => array(
				array (
					'GETvar' => 'tx_typo3agencies_pi1[redirectController]',
				),
				array (
					'GETvar' => 'tx_typo3agencies_pi1[redirect]',
				),
			),
			'page' => array(
				array (
					'GETvar' => 'tx_typo3agencies_pi1[page]',
				)
			)
		)
	),

	'fixedPostVars' => array(

		// ter_fe2
		'ter' => array(
			'0' => array(
				'GETvar' => 'tx_terfe2_pi1[action]',
				'valueMap' => array(
					'view' => 'show',
					'download' => 'download',
					'search' => 'search',
				),
				'noMatch' => 'bypass'
			),
			'1' => array(
				'GETvar' => 'tx_terfe2_pi1[controller]',
				'noMatch' => 'bypass'
			),
			'2' => array(
				'GETvar' => 'tx_terfe2_pi1[extension]',
				'lookUpTable' => array (
					'table' => 'tx_terfe2_domain_model_extension',
					'id_field' => 'uid',
					'languageField' => 'sys_language_uid',
					'alias_field' => "ext_key",
					'addWhereClause' => ' AND NOT deleted',
					'useUniqueCache' => 1,
					'useUniqueCache_conf' => array (
						'defineSpaceCharacters' => ' -+',
						'strtolower' => 1,
						'spaceCharacter' => '_'
					)
				),
			),
			'3' => array(
				'GETvar' => 'tx_terfe2_pi1[versionString]',
			),
			'4' => array(
				'GETvar' => 'tx_terfe2_pi1[format]',
				'valueMap' => array(
					'zip' => 'zip',
					't3x' => 't3x',
				),
				'noMatch' => 'bypass'
			),
			'5' => array(
				'GETvar' => 'tx_terfe2_pi1[author]',
				'lookUpTable' => array (
					'table' => 'tx_terfe2_domain_model_author',
					'id_field' => 'uid',
					'languageField' => 'sys_language_uid',
					'alias_field' => "name",
					'addWhereClause' => ' AND NOT deleted',
					'useUniqueCache' => 1,
					'useUniqueCache_conf' => array (
						'defineSpaceCharacters' => ' -+',
						'strtolower' => 1,
						'spaceCharacter' => '-'
					)
				)
			)
		),

		'ter_doc' => array(
			'0' => array(
				'GETvar' => 'tx_terdoc_pi1[extensionkey]'
			),
			'1' => array(
				'GETvar' => 'tx_terdoc_pi1[version]'
			),
			'2' => array(
				'GETvar' => 'tx_terdoc_pi1[format]',
				'valueMap' => array(
					'view' => 'ter_doc_html_onlinehtml',
					'sxw' => 'ter_doc_sxw'
				)
			),
			'3' => array(
				'GETvar' => 'tx_terdoc_pi1[html_readonline_chapter]'
			),
			'4' => array(
				'GETvar' => 'tx_terdoc_pi1[html_readonline_section]'
			)
		),

		'videoOverview' => array(
			'1' => array(
				'GETvar' => 'tx_vimeoconnector_allcategories[action]',
				'noMatch' => 'bypass'
			),
			'2' => array(
				'GETvar' => 'tx_vimeoconnector_allcategories[controller]',
				'noMatch' => 'bypass'
			)
		),
		'videoPlayer' => array(
			'1' => array(
				'GETvar' => 'tx_vimeoconnector_play[video]',
				'lookUpTable' => array (
					'table' => 'tx_vimeoconnector_domain_model_video',
					'id_field' => 'uid',
					'languageField' => 'sys_language_uid',
					'alias_field' => "title",
					'addWhereClause' => ' AND NOT deleted',
					'useUniqueCache' => 1,
					'useUniqueCache_conf' => array (
						'defineSpaceCharacters' => ' -+',
						'strtolower' => 1,
						'spaceCharacter' => '-'
					),
					'enable404forInvalidAlias' => TRUE,
				)
			),
			'2' => array(
				'GETvar' => 'tx_vimeoconnector_play[action]',
				'noMatch' => 'bypass'
			),
			'3' => array(
				'GETvar' => 'tx_vimeoconnector_play[controller]',
				'noMatch' => 'bypass'
			)
		),
		'videoCategory' => array(
			array(
				'GETvar' => 'tx_vimeoconnector_category[category]',
				'lookUpTable' => array (
					'table' => 'tx_vimeoconnector_domain_model_category',
					'id_field' => 'uid',
					'languageField' => 'sys_language_uid',
					'alias_field' => "title",
					'addWhereClause' => ' AND NOT deleted',
					'useUniqueCache' => 1,
					'useUniqueCache_conf' => array (
						'defineSpaceCharacters' => ' -+',
						'strtolower' => 1,
						'spaceCharacter' => '-'
					),
					'enable404forInvalidAlias' => TRUE,
				)
			),
			array(
				'GETvar' => 'tx_vimeoconnector_category[__widget_0][currentPage]',
				'userFunc' => 'EXT:t3org_base/Classes/Realurl/Pagination.php:Tx_T3orgbase_Realurl_Pagination->main'
			),
			array(
				'GETvar' => 'tx_vimeoconnector_category[action]',
				'noMatch' => 'bypass'
			),
			array(
				'GETvar' => 'tx_vimeoconnector_category[controller]',
				'noMatch' => 'bypass'
			),
		),
		'videoArchive' => array(
			array(
				'GETvar' => 'tx_vimeoconnector_archive[year]',
			),
			array(
				'GETvar' => 'tx_vimeoconnector_archive[month]',
			),
			array(
				'GETvar' => 'tx_vimeoconnector_archive[__widget_0][currentPage]',
				'userFunc' => 'EXT:t3org_base/Classes/Realurl/Pagination.php:Tx_T3orgbase_Realurl_Pagination->main'
			),
			array(
				'GETvar' => 'tx_vimeoconnector_archive[action]',
				'noMatch' => 'bypass'
			),
			array(
				'GETvar' => 'tx_vimeoconnector_archive[controller]',
				'noMatch' => 'bypass'
			)
		),

		'news' => array (
			'0' => array (
				'GETvar' => 'tx_ttnews[tt_news]',
				'lookUpTable' => array (
					'table' => 'tt_news',
					'id_field' => 'uid',
					'languageGetVar' => 'L',
					'transOrigPointerField' => 'l18n_parent',
					'languageField' => 'sys_language_uid',
					'alias_field' => "title",
					'addWhereClause' => ' AND NOT deleted',
					'useUniqueCache' => 1,
					'useUniqueCache_conf' => array (
						'defineSpaceCharacters' => ' -+',
						'strtolower' => 1,
						'spaceCharacter' => '-'
					),
					'enable404forInvalidAlias' => TRUE,
				)
			),
			'1' => array (
				'GETvar' => 'tx_ttnews[swords]'
			)
		),
		// cz_simple_cal
		'calendar' => array(
			'0' => array(
				'GETvar' => 'tx_czsimplecal_pi1[action]',
				'noMatch' => 'bypass'
			),
			'1' => array(
				'GETvar' => 'tx_czsimplecal_pi1[controller]',
				'noMatch' => 'bypass'
			),
			'2' => array(
				'GETvar' => 'tx_czsimplecal_pi1[format]',
				'noMatch' => 'bypass'
			),
			'4' => array(
				'GETvar' => 'tx_czsimplecal_pi1[event]',
				'lookUpTable' => array (
					'table' => 'tx_czsimplecal_domain_model_event',
					'id_field' => 'uid',
					'languageGetVar' => 'L',
					'transOrigPointerField' => 'l18n_parent',
					'languageField' => 'sys_language_uid',
					'alias_field' => "title",
					'addWhereClause' => ' AND NOT deleted',
					'useUniqueCache' => 1,
					'useUniqueCache_conf' => array (
						'defineSpaceCharacters' => ' -+',
						'strtolower' => 1,
						'spaceCharacter' => '-'
					),
					'enable404forInvalidAlias' => TRUE,
				)
			)
		),
		// cz_simple_cal event submission
		'calendarSubmission' => array(
			'0' => array(
				'GETvar' => 'tx_czsimplecal_pi2[controller]',
				'noMatch' => 'bypass'
			),
			'1' => array(
				'GETvar' => 'tx_czsimplecal_pi2[action]',
				'valueMap' => array(
					'new' => 'new',
					'create' => 'create',
					'edit' => 'edit',
					'update' => 'update',
					'delete' => 'delete',
				),
				'noMatch' => 'bypass'
			),
		),

		// cz_simple_cal archive
		'calendarArchive' => array(
			'0' => array(
				'GETvar' => 'tx_czsimplecal_pi1[action]',
				'noMatch' => 'bypass'
			),
			'1' => array(
				'GETvar' => 'tx_czsimplecal_pi1[controller]',
				'noMatch' => 'bypass'
			),
			'2' => array(
				'GETvar' => 'tx_czsimplecal_pi1[getDate]',
			)
		),

		'case_studies' => array(
			array(
				'GETvar' => 'tx_typo3agencies_pi1[controller]',
				'valueMap' => array(),
				'noMatch' => 'bypass'
			),
			array (
				'GETvar' => 'tx_typo3agencies_pi1[action]',
				'valueMap' => array(
					'preview' => 'preview',
					'show' => 'show',
					'new' => 'new',
					'edit' => 'edit',
					'delete' => 'confirmDelete',
					'perfom-delete' => 'delete',
					'create' => 'create',
					'save-changes' => 'update',
					'deactivate' => 'deactivate',
					'reactivate' => 'reactivate',
					'asPDF' => 'pdf'
				),
				'noMatch' => 'bypass'
			),
			array (
				'GETvar' => 'tx_typo3agencies_pi1[reference]',
				'lookUpTable' => array (
					'table' => 'tx_typo3agencies_domain_model_reference',
					'id_field' => 'uid',
					'languageGetVar' => 'L',
					'transOrigPointerField' => 'l18n_parent',
					'languageField' => 'sys_language_uid',
					'alias_field' => "title",
					'addWhereClause' => ' AND NOT deleted',
					'useUniqueCache' => 1,
					'useUniqueCache_conf' => array (
						'defineSpaceCharacters' => ' -+',
						'strtolower' => 1,
						'spaceCharacter' => '-'
					)
				)
			),
		),
		'agencies_show' => array(
			array(
				'GETvar' => 'tx_typo3agencies_pi1[controller]',
				'valueMap' => array(),
				'noMatch' => 'bypass'
			),
			array (
				'GETvar' => 'tx_typo3agencies_pi1[action]',
			),
			array (
				'GETvar' => 'tx_typo3agencies_pi1[agency]',
				'lookUpTable' => array (
					'table' => 'tx_typo3agencies_domain_model_agency',
					'id_field' => 'uid',
					'languageGetVar' => 'L',
					'transOrigPointerField' => 'l18n_parent',
					'languageField' => 'sys_language_uid',
					'alias_field' => "name",
					'addWhereClause' => ' AND NOT deleted',
					'useUniqueCache' => 1,
					'useUniqueCache_conf' => array (
						'defineSpaceCharacters' => ' -+',
						'strtolower' => 1,
						'spaceCharacter' => '-'
					)
				)
			),
		),
		'agencies' => array(
			array(
				'GETvar' => 'tx_typo3agencies_pi2[action]',
				'valueMap' => array(
					'enterBasicInformation' => 'basic',
					'new' => 'new',
					'enterCode' => 'code',
					'enterApprovalData' => 'approve'
				)
			),
			array(
				'GETvar' => 'tx_typo3agencies_pi2[controller]',
				'noMatch' => 'bypass'
			)
		),

		'ajaxlogin' => array(
			'0' => array(
				'GETvar' => 'tx_ajaxlogin_widget[action]',
			),
			'1' => array(
				'GETvar' => 'tx_ajaxlogin_widget[controller]',
				'noMatch' => 'bypass'
			),
		),

		'donorlist' => array(
			'0' => array(
				'GETvar' => 'tx_donation_pi_donorlist[page]'
			)
		),

		'securityBulletins' => array(
			'0' => array (
				'GETvar' => 'tx_ttnews[tt_news]',
				'lookUpTable' => array(
					'table' => 'tt_news',
					'id_field' => 'uid',
					'languageGetVar' => 'L',
					'transOrigPointerField' => 'l18n_parent',
					'languageField' => 'sys_language_uid',
					'alias_field' => "IF( tx_t3orgbase_pathsegment != '', tx_t3orgbase_pathsegment, title)",
					'addWhereClause' => ' AND NOT deleted',
					'useUniqueCache' => 1,
					'useUniqueCache_conf' => array(
						'defineSpaceCharacters' => ' -+',
						'strtolower' => 1,
						'spaceCharacter' => '-'
					),
					'enable404forInvalidAlias' => TRUE,
				)
			),
		),
		// EXT: badges
		'certified' => array(
			'0' => array(
				'GETvar' => 'tx_badges_main[action]',
				'valueMap' => array(
					'search' => 'listUncached'
				),
				'noMatch' => 'bypass'
			),
			'1' => array(
				'GETvar' => 'tx_badges_main[controller]',
				'noMatch' => 'bypass'
			),
			'2' => array(
				'GETvar' => 'tx_badges_main[letter]',
			),
		),

		// assign the actual page ids
		'23' => 'ter',
		'128' => 'agencies_show',
		'143' => 'ter_doc',
		'144' => 'ter_doc',
		'145' => 'ter_doc',
		'334' => 'ter_doc',
		'493' => 'ter_doc',
		'48' => 'videoOverview',
		'57' => 'donorlist',
		'181' => 'news',	// news
		'434' => 'news',	// documentation articles
		'554' => 'calendar',
		'555' => 'calendar',
		'556' => 'calendar',
		'559' => 'calendar',
		'560' => 'calendar',
		'423' => 'agencies',
		'435' => 'case_studies',
		'598' => 'case_studies',
		'444' => 'calendarSubmission',
		'460' => 'ajaxlogin',
		'461' => 'calendarArchive',
		'464' => 'videoPlayer',
		'465' => 'videoCategory',
		'466' => 'videoArchive',
		'199' => 'securityBulletins',
		'500' => 'securityBulletins',
		'501' => 'securityBulletins',
		'502' => 'securityBulletins',
		'762' => 'securityBulletins',
		'578' => 'certified',
	),

	'fileName' => array (
		'defaultToHTMLsuffixOnPrev' => FALSE,
		'index' => array (
			'rss.xml' => array (
				'keyValues' => array (
					'type' => 100
				)
			),
			'.pdf' => array (
				'keyValues' => array (
					'type' => 123
				)
			),
			'.ics' => array (
				'keyValues' => array (
					'type' => 150
				)
			),
			'user.xml' => array(
				'keyValues' => array(
					'type' => 98987
				)
			),
			'new-extensions.rss' => array(
				'keyValues' => array(
					'type' => 95831,
					'tx_terfe2_pi1[format]' => 'rss',
					'tx_terfe2_pi1[action]' => 'listLatest',
					'tx_terfe2_pi1[controller]' => 'Extension'
				)
			),
			// used for t3org_feedparser
			'feed.xhr' => array(
				'keyValues' => array(
					'type' => 7077,
					'action' => 'remote',
				)
			),
			'feed_int.xhr' => array(
				'keyValues' => array(
					'type' => 7076,
					'action' => 'remote',
				)
			),
			'randombanners.xhr' => array(
				'keyValues' => array(
					'type' => 69,
					'tx_randombanners_list[action]' => 'list',
					'tx_randombanners_list[controller]' => 'Banner'
				)
			),
		)
	)
);

/* disable realurl decode cache for search pages
 *
 * facetting and pagination creates lots of urls that are rarely needed and flood the encode
 * cache with useless entries. Disabling the encode cache for that pages prevents that.
 *
 * @ugly
 * @see http://forge.typo3.org/issues/54000
 */
if(t3lib_div::_GET('q') || t3lib_div::_GET('tx_solr')) {
	$realurlconf['init']['enableUrlEncodeCache'] = 0;
}

include('domainconf.php');

$TYPO3_CONF_VARS['EXTCONF']['realurl'][$domainAlias['www']] = $realurlconf;
$TYPO3_CONF_VARS['EXTCONF']['realurl'][$domainAlias['www']]['pagePath']['rootpage_id'] = 2;
$TYPO3_CONF_VARS['EXTCONF']['realurl'][$domainAlias['backend']] = $realurlconf;
$TYPO3_CONF_VARS['EXTCONF']['realurl'][$domainAlias['backend']]['pagePath']['rootpage_id'] = 8;

$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'] = $realurlconf;
$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT']['init'] = array (
	'enableCHashCache' => 0,
	'appendMissingSlash' => 'ifNotFile',
	'enableUrlDecodeCache' => 0,
	'enableUrlEncodeCache' => 0,
	'respectSimulateStaticURLs' => 0,
);

?>
