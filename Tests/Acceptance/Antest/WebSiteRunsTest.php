<?php

require_once dirname(__FILE__).'/../SeleniumBaseTestCase.php';
require_once dirname(__FILE__).'/../Driver/WebSiteRunsPage.php';

class Acceptance_Antest_WebSiteRunsTest extends Acceptance_SeleniumBaseTestCase {
	
	protected $homeId = "/?id=3";
	
	/** 
	 * needs to be boolean
	 * **/
	protected $checkContent = FALSE;
	
	public function setUp() {
		$this->setBrowserUrl($this->getConfig()->getValue('testing.maindomain'));
	}		
	
	 /**
     * @dataProvider provider
     * @test
     */
	public function http200($pageName, $pageID) {
		$http200 = new Acceptance_Driver_WebsiteRunsPage($this);
		$http200->openPage($pageID.$this->homeId);
		$http200->http200Check(); 
	}
	
    /**
     * @dataProvider provider
     * @test
     */
	public function http404 ($pageName, $pageID) {
		$http404 = new Acceptance_Driver_WebsiteRunsPage($this);
		$http404->openPage($pageID.'/error-404/'); 
		$http404->http404Check();		
	}
	
    /**
     * @dataProvider provider
     * @test
     */	
	public function httpRedirectWorks ($pageName, $pageID){
		$httpRnd = new Acceptance_Driver_WebsiteRunsPage($this);
		$httpRnd->openPage($pageID.'/'.md5(microtime()));
		$httpRnd->httpRedirectCheck(); 
	}
	
    /**
     * @dataProvider provider
     * @test
     */		
	public function checkMainMenuLinks ($pageName, $pageID){
		$linkCheck = new Acceptance_Driver_WebsiteRunsPage($this);
		$linkCheck->openPage($pageID.$this->homeId);
		$linkCheck->checkAllLinks($pageID,$this->checkContent);
	}
}