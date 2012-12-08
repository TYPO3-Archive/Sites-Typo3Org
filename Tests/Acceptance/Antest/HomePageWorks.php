<?php

require_once dirname(__FILE__).'/../SeleniumBaseTestCase.php';
require_once dirname(__FILE__).'/../Driver/HomePageWorksPage.php';

class Acceptance_Antest_HomePageWorks extends Acceptance_SeleniumBaseTestCase {

	protected $homeId = "/?id=3";
	
	public function setUp() {
		$this->setBrowserUrl($this->getConfig()->getValue('testing.maindomain'));
	}		
	
	 /**
     * @dataProvider provider
     * @test
     */
	public function homePageWorks($pageName, $pageID) {
		$homePageWorks = new Acceptance_Driver_HomePageWorksPage($this);
		$homePageWorks->openPage($pageID. $this->homeId);
		$homePageWorks->checkExpectedElementsPresent();
		$homePageWorks->checkSearchbox();
		$homePageWorks->checkHeroBanner();
		//$homePageWorks->checkFlyout();				 
	}

}
