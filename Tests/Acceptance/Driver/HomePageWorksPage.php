<?php

require_once dirname(__FILE__) . '/AbstractDriver.php';


class Acceptance_Driver_HomePageWorksPage extends Acceptance_Driver_AbstractDriver{
	
	protected $heroBannerElements = 4;
	
	private $errorCode ="Error 404";	
			
	public function checkExpectedElementsPresent(){
		$this->testCase->assertElementPresent("//div[@id='top-slider']", "Heroslider is missing or broken");
		$this->testCase->assertElementPresent("//div[@class='b-social-body']", "Social Container is missing or broken");
		$this->testCase->assertElementPresent("//div[@id='footer']", "Footer is missing or broken");
		$this->testCase->assertElementPresent("//div[@id='footer']//p[contains(text(),'All rights reserved.')]", "Copyright is missing");
		$this->testCase->assertElementPresent("//div[@id='footer']//a", "Footer Links are missing");
		
		$count = $this->testCase->getKnotCount("//div[@id='footer']//dl");
		$this->testCase->assertTrue($count >0, "Footer Sponsors are missing");
	
	}
	
	public function checkSearchbox(){
		$this->testCase->assertElementPresent("//div[@class='tx-solr']", "Searchbox is missing or broken");
		$this->testCase->assertElementPresent("//div[@class='tx-solr']//div[@class='smart-search']", "Searchbox is missing or broken");
		$this->testCase->assertElementPresent("//div[@class='tx-solr']//form/label", "Searchbox is missing or broken");
		$this->testCase->assertElementPresent("//div[@class='tx-solr']//form/button", "Searchbox is missing or broken");	
	}
	
	public function checkHeroBanner(){
		$count = $this->testCase->getKnotCount("//div[@id='top-slider']//li[@class='slide']");
		$this->testCase->assertTrue($count==$this->heroBannerElements, "Slider Elements from the Topslider are missing");
	}
	
	public function checkFlyout(){	
		//TODO
		$this->testCase->assertElementPresent("//ul[@class='nav']/li/a[contains(@title,'About')]");
		//$this->testCase->assertElementPresent("//ul[@class='nav']/li/a[contains(@title,'About')]/ancestor::li/div[contains(@style,'display: none;')]");
		$this->testCase->mouseOver("//ul[@class='nav']/li/a[contains(@title,'About')]");
		$this->testCase->assertElementPresent("//ul[@class='nav']/li/a[contains(@title,'About')]/ancestor::li/div[contains(@style,'display: block;')]");				
	}	
}