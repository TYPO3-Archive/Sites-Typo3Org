<?php

class Acceptance_Driver_AbstractDriver {
	/**
	 * @var TestingFramework_Server_SeleniumTestCase
	 */
	protected $testCase;
	
	/**
	 * XPath expression to evaluation the current context.
	 *
	 * @var string
	 */
	protected $context;
	
	/**
	 * XPath expression to check if Debug Messages are present.
	 *
	 * @var string
	 */
	protected $debug;
	
	/**
	 * @param TestingFramework_Server_SeleniumTestCase $testCase
	 */
	public function __construct(TestingFrameworkLight_Server_SeleniumTestCase $testCase) {
		$this->testCase = $testCase;
	}
	
	/**
	 * checks if debug Messages are üresemt	 
	 */
	public function debugCheck(){
		$count = $this->testCase->getKnotCount($this->debug);
		$this->testCase->assertTrue($count == 0, "Debug Messages present");
	}
	
	/**
	 * opens page (and verify that Elements are given)
	 * @param string $pageID
	 */
	public function openPage($pageID) {
		$this->testCase->windowFocus();
		$this->testCase->windowMaximize(); 				
		$this->testCase->open($pageID);
		if (!($this->context=='')){
			$this->testCase->assertElementPresent($this->context);
		}
		if (!($this->debug=='')){
			$this->debugCheck();
		}
	}
	
	public function openTYPO3BackendPage($pageID) {
		$this->testCase->windowFocus();
		$this->testCase->windowMaximize(); 				
		$this->testCase->open($pageID);					
	}
	
	public function goToPageOverMainMenu($pageID){
		$this->testCase->open($pageID);				
	}	
}