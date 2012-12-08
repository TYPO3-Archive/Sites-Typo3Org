<?php

require_once dirname(__FILE__).'/TestingFrameworkLight/Server/SeleniumTestCase.php';
require_once dirname(__FILE__).'/TestingFrameworkLight/Util/Configuration.php';
require_once dirname(__FILE__).'/TestingFrameworkLight/Util/PageIdProvider.php';

abstract class Acceptance_SeleniumBaseTestCase extends TestingFrameworkLight_Server_SeleniumTestCase {
	
	/**
	 * Get new configuration
	 * 
	 * @return TestingFramework_Util_Configuration
	 */
	public function getConfig() {
		return new TestingFrameworkLight_Util_Configuration();
	}
	
	public function provider() {
		$pageIdXml = $this->getConfig()->getValue('testing.pageids');
		return TestingFrameworkLight_Util_PageIdProvider::pageIdProvider($pageIdXml);		
	}
	
}