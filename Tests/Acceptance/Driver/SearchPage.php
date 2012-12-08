<?php

require_once dirname(__FILE__) . '/AbstractDriver.php';


class Acceptance_Driver_SearchPage extends Acceptance_Driver_AbstractDriver{
		
	public function enterSearchTerm($searchWord) {
		$this->testCase->assertElementPresent ( "//input[@id='form-element-21']" );
		$this->testCase->type( "//input[@id='form-element-21']", $searchWord );
	}
	
	public function searchFor($searchWord) {
		$this->enterSearchTerm($searchWord);
		$this->testCase->clickAndWait ( "//div[@class='quick-search']//button" );
		$this->testCase->assertElementPresent ( "//div[@class='b-search-result-info']//strong[contains(text(), '" . $searchWord . "')]" );
	}
	
	public function searchResultRenders() {
		$count = $this->testCase->getKnotCount ( "//div[@class='tab-panes lite-tab-panes-black b-search']//h2" );
		$this->testCase->assertTrue ( $count > 0, "no results" );
	}
	
	public function facetsRenders() {
		$count = $this->testCase->getKnotCount ( "//ul[@class='tabs lite-tabs']/li" );
		$this->testCase->assertTrue ( $count > 1, "Facets missing" );				
		$count = $this->testCase->getKnotCount ( "//div[@class='b-filter-body']//a" );
		$this->testCase->assertTrue ( $count > 0, "boardhierarchy facets missing" );
	}
	
	public function checkFacette() {		
		$currentPage = $this->testCase->getText ( "//ul[@class='tabs lite-tabs']/li[@class='act']" );
		$this->testCase->clickAndWait ("//ul[@class='tabs lite-tabs']/li[2]/a");		
		$this->testCase->waitForElementPresent("//ul[@class='tabs lite-tabs']/li[2]/@class");
		$currentPageAfterFiltering = $this->testCase->getText ( "//ul[@class='tabs lite-tabs']/li[@class='act']" );		
		$this->testCase->assertTrue ( $currentPage != $currentPageAfterFiltering, "Search results fail" );
		$this->testCase->clickAndWait ("//ul[@class='tabs lite-tabs']/li[1]/a");		
		$this->testCase->waitForElementPresent("//ul[@class='tabs lite-tabs']/li[1]/@class");
		$startPage = $this->testCase->getText ( "//ul[@class='tabs lite-tabs']/li[@class='act']" );
		$this->testCase->assertTrue ( $startPage != $currentPageAfterFiltering, "going Facette back is not working" );
	}
	
	public function checkLeftFacette() {
		$this->testCase->assertElementPresent("//ul[@class='b-filter-list']");	
		$this->testCase->clickAndWait("//ul[@class='b-filter-list']//li[1]//a");
		$this->testCase->assertElementPresent("//div[@id='tx-solr-facets-in-use']//div[@class='b-filter-head']/h4");
		$this->testCase->clickAndWait("//div[@class='b-filter-body']/ul[@class='b-filter-list active-filter-list']/li/a");			
	}	
	
	public function goToNextPage() {
		$currentPage = $this->testCase->getText ( "//li[@class='pager-current act']" );
		$this->testCase->clickAndWait ( "//li[@class='pager-next']/a" );		
		$nextPage = $this->testCase->getText ( "//li[@class='pager-current act']" );
		$this->testCase->assertTrue ( $currentPage != $nextPage, "Pagination does not work" );
	}
	
	public function goToPreviousPage() {		
		$currentPage = $this->testCase->getText ( "//li[@class='pager-current act']" );
		$this->testCase->clickAndWait ( "//li[@class='pager-prev']/a" );		
		$nextPage = $this->testCase->getText ( "//li[@class='pager-current act']" );		
		$this->testCase->assertTrue ( $currentPage != $nextPage, "Pagination does not work" );			
	}
	
	public function searchResultPerPage(){
		$landingResult = $this->testCase->getKnotCount("//div[@class='s-body']//div[@class='g']");
		$this->testCase->select("//select[@id='results']","20");
		$this->testCase->waitForElementPresent("//option[@value=20]/@selected");
		$landingResultAfterSelect = $this->testCase->getKnotCount("//div[@class='s-body']//div[@class='g']");
		$this->testCase->assertTrue ( $landingResult != $landingResultAfterSelect, "Search Result per Page Dropdown does not work" );
	}
}