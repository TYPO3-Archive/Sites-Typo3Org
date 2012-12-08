<?php

require_once dirname(__FILE__).'/../SeleniumBaseTestCase.php';
require_once dirname(__FILE__).'/../Driver/BackendTYPO3LoginPage.php';

class Acceptance_Antest_BackendTYPO3Login extends Acceptance_SeleniumBaseTestCase {
	
	public function setUp() {
		$this->setBrowserUrl($this->getConfig()->getValue('testing.maindomain'));
	}	
	
	/**
     * @dataProvider provider
     * @test
     */
	public function backendWorks ($pageName, $pageID) {
		$url = "backend.".trim($pageID, "www.")."/typo3/";
		$backendWorks = new Acceptance_Driver_BackendTYPO3LoginPage($this);
		$backendWorks->openTYPO3BackendPage($url);
		$backendWorks->checkIfBackendPresent();
		$backendWorks->getBackendUser();	
		$backendWorks->loginBackend();
		$backendWorks->checkIfLogedIn();
		
		$iFrame = $backendWorks->getIframeFromHome($pageID);
		$backendWorks->openTYPO3BackendPage($iFrame);
		
		$thumbURL = $backendWorks->getThumbURL($pageID);
		$backendWorks->checkThumb($thumbURL);
					
		$backendWorks->openTYPO3BackendPage($url);		
		$backendWorks->logoutBackend();	
		$backendWorks->checkIfBackendPresent();			
	}

}