<?php

require_once dirname(__FILE__).'/../SeleniumBaseTestCase.php';
require_once dirname(__FILE__).'/../Driver/SearchPage.php';

class Acceptance_Antest_HomePageWorks extends Acceptance_SeleniumBaseTestCase {
	
	protected $searchWord = 'typo3';
	
	public function setUp() {
		$this->setBrowserUrl($this->getConfig()->getValue('testing.maindomain'));
	}		
	
	 /**
     * @dataProvider provider
     * @test
     */
	public function searchWorks($pageName, $pageID) {
		$searchPage = new Acceptance_Driver_SearchPage($this);
		$searchPage->openPage($pageID);
		$searchPage->searchFor($this->searchWord);
		$searchPage->searchResultRenders();
		$searchPage->facetsRenders();
		$searchPage->checkFacette();
		$searchPage->checkLeftFacette();
		$searchPage->goToNextPage();
		$searchPage->goToPreviousPage();
		$searchPage->searchResultPerPage();			  
	}
}
