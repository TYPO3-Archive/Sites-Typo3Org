<?php

require_once dirname(__FILE__) . '/AbstractDriver.php';


class Acceptance_Driver_WebsiteRunsPage extends Acceptance_Driver_AbstractDriver{
	
	/*
	 * xpath to an element present on every page (for example: page logo)
	 * */
	protected $context = "//a[@id='logo']";
	
	protected $debug = "//table[@class='typo3-debug']";
	
	protected $blacklist = array ("Merchandise", "Forum", "Wiki", "Past Changelogs");

	/*
	 * Error Code for 404 Pages (String)
	 * */  
	private $errorCode ="Breathe deeply. Stay calm.";	
	
	public function http200Check(){
		try {
			$this->testCase->assertTextNotPresent("Error!");
		} catch (PHPUnit_Framework_AssertionFailedError $e) {
			array_push($this->testCase->verificationErrors, $e->toString());
		}			
	}
	
	public function http404Check(){
		$this->testCase->assertTextPresent($this->errorCode);	
	}
	
	public function httpRedirectCheck(){
		$this->testCase->assertTextPresent($this->errorCode);
	}
	
	/**
	 * checks all Main Menu Link 1st/2nd lvl; if second Parameter is set to TRUE it also checks if Content is present
	 * @param string $pageID
	 * @param boolean $contentCheck
	 */
	public function checkAllLinks($pageID,$contentCheck){
		
		$count = $this->testCase->getKnotCount("(//ul[@class='nav']/li//a/@href)");		

		for ($id=1; $id<=$count; $id++){
			$hrefName = $this->testCase->getText("xpath=(//ul[@class='nav']//a)[".$id."]");
			
			$href = $this->testCase->getValue("xpath=(//ul[@class='nav']//a/@href)[".$id."]");
			if(!in_array($hrefName, $this->blacklist)){
				echo $hrefName.chr(10);
				$this->goToPageOverMainMenu($pageID."/".$href);
				$divcount = $this->testCase->getKnotCount("//div[@id='section']//div");
				echo $pageID."/".$href." hat " . $divcount. " content divs";
				if($contentCheck === TRUE){
					$this->testCase->assertTrue($divcount>0, "Content Missing on Page: ". $pageID."/".$href);
					$this->testCase->assertTextNotPresent($this->errorCode, "Error on Page". $pageID."/".$href);				
				}
			}
		}		
	}
}