<?php

require_once dirname(__FILE__) . '/AbstractDriver.php';


class Acceptance_Driver_BackendTYPO3LoginPage extends Acceptance_Driver_AbstractDriver{
	
	protected $defaultusername = "selenium.user";
	protected $defaultpassword = "test1234";
	protected $defaulthomeID = "3";
	protected $username;
	protected $password;
	protected $homeID;
	
	public function getBackendUser(){
		$this->username = $this->testCase->getConfiguration()->getValue( 'testing.backend.user' );
		$this->password = $this->testCase->getConfiguration()->getValue( 'testing.backend.password' );
		$this->homeID = $this->testCase->getConfiguration()->getValue( 'testing.backend.homeid' );
		
		if($this->username==null){
			$this->username = $this->defaultusername;
		}
		if($this->password==null){
			$this->password = $this->defaultpassword;
		}
		if($this->homeID==null){
			$this->homeID = $this->defaulthomeID;
		}
	}
	
	public function checkIfBackendPresent(){
		$this->testCase->waitForElementPresent("//div[@id='t3-login-image']");
		$this->testCase->assertElementPresent("//div[@id='t3-login-image']");
		$this->testCase->assertElementPresent("//div[@id='t3-login-form-outer']");
		$this->testCase->assertelementPresent("//input[@id='t3-username']");
		$this->testCase->assertelementPresent("//input[@id='t3-password']");
		$this->testCase->assertelementPresent("//input[@id='t3-login-submit']");
		
	}
	 
	public function loginBackend(){
		$this->testCase->type("//input[@id='t3-username']",$this->username);
		$this->testCase->type("//input[@id='t3-password']",$this->password);
		$this->testCase->click("//input[@id='t3-login-submit']");
		sleep(3);		
	}
	
	public function checkIfLogedIn(){
		$this->testCase->assertElementPresent("//div[@id='typo3-logo']");
		$this->testCase->assertElementPresent("//div[@id='username']");
		$this->testCase->assertElementPresent("//ul[@id='typo3-menu']");
		$this->testCase->assertElementPresent("//li[@id='web']");
		$this->testCase->assertElementPresent("//li[@id='workspace-selector-menu']");	
	}
	
	public function getIframeFromHome($pageID){
		//click on Web -> Page
		$this->testCase->type("//li[@id='web_txtemplavoilaM1']/a");
		sleep(2);
		//get source of the iframe
		$src = $this->testCase->getValue("xpath=(//div[@id='typo3-card-web_txtemplavoilaM1']//iframe/@src)");
		$src = substr( $src, strpos( $src, '/' ) , (strlen( $src ) - strrpos( $src, '=') - 1) * -1 );		
		return "backend.".trim($pageID, "www.").$src.$this->homeID;
	}
	
	public function getThumbURL($pageID){	
		$this->testCase->waitForElementPresent("//div[@id='typo3-docbody']");
		$thumb = $this->testCase->getValue("xpath=((//img[(contains(@src,'thumb'))])[1]/@src)");
		$thumb = substr ($thumb, strrpos($thumb,'/typo3'));
		return $imgURL = "backend.".trim($pageID, "www.").$thumb;					
	}
	
	public function checkThumb($url){
		$imgcontent = file_get_contents("http://".$url);
		//$img = base64_encode($imgcontent);
		//var_dump($img);
		$this->testCase->assertTrue(stristr($imgcontent,"fatal") == false, " Fatal Error present");
		$this->testCase->assertTrue(stristr($imgcontent,"error") == false, " Error present ");
		$this->testCase->assertTrue(stristr($imgcontent,"warning")== false, " Warning present");	
	}

	public function logoutBackend(){	
	 	$this->testCase->waitForElementPresent("//input[contains(@value,'Logout')]");	
		$this->testCase->click("//input[contains(@value,'Logout')]");
		sleep(3);
	}
	
}