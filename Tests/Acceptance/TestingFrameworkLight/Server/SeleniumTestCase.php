<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
require_once dirname ( __FILE__ ) . '/../Util/Configuration.php';
class PHPUnit_Extensions_SeleniumTestCase_Driver_Party extends PHPUnit_Extensions_SeleniumTestCase_Driver {
	public function getCommandsInfo() {
		return $this->commands;
	}

}
/**
 * abstract class for selenium test wich called remotly
 * @package TestingFrameworkLight_Server
 */
abstract class TestingFrameworkLight_Server_SeleniumTestCase extends PHPUnit_Extensions_SeleniumTestCase {
	/**
	 * @var TestingFrameworkLight_Util_Configuration
	 */
	private $configuration;
	
	protected $currentFunctionName;
	
	/**
	 * @return boolean
	 */
	public function getAutoStop() {
		return $this->autoStop;
	}
	/**
	 * log all selenium call
	 * @param string $command
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call($command, $arguments) {		
		return parent::__call ( $command, $arguments );
	}
	/**
	 * @return PHPUnit_Extensions_SeleniumTestCase_Driver
	 */
	public function getSeleniumDriver() {
		return $this->drivers [0];
	}
	/**
	 * @return string
	 */
	public function getTestId() {
		return $this->testId;
	}
	/**
	 * @param string $id
	 */
	public function setTestId($id) {
		$this->testId = $id;
	}
	/**
	 * @param array $callback
	 * @param integer $timeout
	 */
	protected function waitForCondition(array $callback, $timeout = 60) {
		for($second = 0;; $second ++) {
			if ($second >= $timeout) {
				$this->fail ( 'waitForCondition failed after ' . $timeout . ' secounds' );
			}
			if (call_user_func ( $callback )) {
				break;
			}
			sleep ( 1 );
		}
	}
	/**
	 * @param integer $timeout
	 */
	protected function waitForAlert($timeout = 60) {
		for($second = 0;; $second ++) {
			if ($second >= 60)
				$this->fail ( "timeout" );
			try {
				if ("" == $this->getAlert ())
					break;
			} catch ( Exception $e ) {
			}
			sleep ( 1 );
		}
	}
	
	/**
	 * @param  array $browser
	 * @return PHPUnit_Extensions_SeleniumTestCase_Driver
	 * @throws InvalidArgumentException
	 */
	protected function getDriver(array $browser) {
				
		if(!($this->getConfiguration ()->getValue ( 'testing.selenium.captureScreenshotOnFailure' )==='') && ($this->getConfiguration ()->getValue ( 'testing.selenium.captureScreenshotOnFailure' )=== "TRUE")){
			$this->captureScreenshotOnFailure = $this->getConfiguration ()->getValue ( 'testing.selenium.captureScreenshotOnFailure' );
		}
		
		if (is_dir($this->getConfiguration ()->getValue ( 'testing.selenium.screenshotPath' ))){
			$this->screenshotPath = $this->getConfiguration ()->getValue ( 'testing.selenium.screenshotPath' );
		}
		
		if (is_dir($this->getConfiguration ()->getValue ( 'testing.selenium.screenshotUrl' ))){
			$this->screenshotUrl = $this->getConfiguration ()->getValue ( 'testing.selenium.screenshotUrl' );
		}
		
		if ($this->getConfiguration ()->issetKey ( 'testing.selenium.rc' )) {
			$browser ['host'] = $this->getConfiguration ()->getValue ( 'testing.selenium.rc' );
		}
		if ($this->getConfiguration ()->issetKey ( 'testing.selenium.browser' )) {
			$browser ['browser'] = $this->getConfiguration ()->getValue ( 'testing.selenium.browser' );
		} elseif (! isset ( $browser ['browser'] )) {
			$browser ['browser'] = '*firefox';
		}
		if (! isset ( $browser ['name'] )) {
			$browser ['name'] = '';
		}
		if (! isset ( $browser ['browser'] )) {
			$browser ['browser'] = '';
		}
		if (! isset ( $browser ['host'] )) {
			$browser ['host'] = 'localhost';
		}
		if (! isset ( $browser ['port'] )) {
			$browser ['port'] = 4444;
		}
		if ($this->getConfiguration ()->issetKey ( 'testing.selenium.timeout' )) {
			$browser ['timeout'] = (int) $this->getConfiguration ()->getValue ( 'testing.selenium.timeout' );
		}elseif (! isset ( $browser ['timeout'] )) {
			$browser ['timeout'] = 30000;
		}
		
		
		$driver = new PHPUnit_Extensions_SeleniumTestCase_Driver_Party();
		$driver->setName ( $browser ['name'] );
		$driver->setBrowser ( $browser ['browser'] );
		$driver->setHost ( $browser ['host'] );
		$driver->setPort ( $browser ['port'] );
		$driver->setTimeout ( $browser ['timeout'] );
		$driver->setTestCase ( $this );
		$driver->setTestId ( $this->testId );
		$this->drivers [] = $driver;
		if (TRUE === isset ( $this->data ['testing.maindomain'] )) {
			$this->setBrowserUrl ( $this->data ['testing.maindomain'] );
		}
		return $driver;
	}
	
	public function getFunctionName(){
		$backtrace = debug_backtrace();
		return $backtrace[0]['object']->getName(false);
	}
	
	public function getCommands($time){
		$name = $this->getFunctionName();
		$this->count = $this->count++; 
		
	}
		
	protected function onNotSuccessfulTest(Exception $e){
		date_default_timezone_set("Europe/Berlin");
		$time = date("Y-m-d_H-i-s");
		
    	$this->getCommands($time);		
		$this->currentFunctionName= $this->getFunctionName();
				
        if ($e instanceof PHPUnit_Framework_ExpectationFailedException) {
            $buffer  = 'Current URL: ' . $this->drivers[0]->getLocation() .
                       "\n";
            $message = $e->getCustomMessage();

            if ($this->captureScreenshotOnFailure &&
                !empty($this->screenshotPath) &&
                !empty($this->screenshotUrl)) {
                $this->drivers[0]->captureEntirePageScreenshot(
                  $this->screenshotPath . DIRECTORY_SEPARATOR  . $this->currentFunctionName . "_" . $time .
                  '.png'
                );
				file_put_contents( $this->screenshotPath . DIRECTORY_SEPARATOR  . $this->currentFunctionName . "_" . $time . '.txt',implode(chr(10), $this->drivers[0]->getCommandsInfo()));
                $buffer .= 'Screenshot: ' . $this->screenshotUrl . '/' .
                           $this->testId . ".png\n";
            }
        }

        if ($this->autoStop) {
            try {
                $this->stop();
            }

            catch (RuntimeException $e) {
            }
        }

        if ($e instanceof PHPUnit_Framework_ExpectationFailedException) {
            if (!empty($message)) {
                $buffer .= "\n" . $message;
            }

            $e->setCustomMessage($buffer);
        }

        throw $e;
    }
	
	/**
	 * @param string $locator
	 * @param integer $timeout
	 */
	public function waitForElementPresent($locator, $timeout = 60) {
		for($second = 0;; $second ++) {
			if ($second >= $timeout)
				$this->fail ( "Timed out after " . $timeout . " seconds. Element '" . $locator . "' not found." );
			try {
				if ($this->isElementPresent ( $locator ))
					break;
			} catch ( Exception $e ) {
			}
			sleep ( 1 );
		}
	}
	/**
	 * @param string $locator
	 * @param integer $timeout
	 */
	public function waitForElementNotPresent($locator, $timeout = 60) {
		for($second = 0;; $second ++) {
			if ($second >= $timeout)
				$this->fail ( "Timed out after " . $timeout . " seconds. Element '" . $locator . "' still found." );
			try {
				if (! $this->isElementPresent ( $locator ))
					break;
			} catch ( Exception $e ) {
			}
			sleep ( 1 );
		}
	}
	/**
	 * @param string $locator
	 * @param integer $timeout
	 */
	public function waitForTextPresent($locator, $timeout = 60) {
		for($second = 0;; $second ++) {
			if ($second >= $timeout)
				$this->fail ( "Timed out after " . $timeout . " seconds. Text '" . $locator . "' not found." );
			try {
				if ($this->isTextPresent ( $locator ))
					break;
			} catch ( Exception $e ) {
			}
			sleep ( 1 );
		}
	}
	/**
	 * @param string $locator
	 * @param integer $timeout
	 */
	public function waitForTextNotPresent($locator, $timeout = 60) {
		for($second = 0;; $second ++) {
			if ($second >= $timeout)
				$this->fail ( "Timed out after " . $timeout . " seconds. Text '" . $locator . "' still found." );
			try {
				if (! $this->isTextPresent ( $locator ))
					break;
			} catch ( Exception $e ) {
			}
			sleep ( 1 );
		}
	}
	/**
	 * @param string $locator
	 * @param integer $timeout
	 */
	public function waitForVisible($locator, $timeout = 60) {
		for($second = 0;; $second ++) {
			if ($second >= $timeout)
				$this->fail ( "Timed out after " . $timeout . " seconds. Element '" . $locator . "' not visible yet." );
			try {
				if ($this->isVisible ( $locator ))
					break;
			} catch ( Exception $e ) {
			}
			sleep ( 1 );
		}
	}
	/**
	 * @param string $locator
	 * @param integer $timeout
	 */
	public function waitForNotVisible($locator, $timeout = 60) {
		for($second = 0;; $second ++) {
			if ($second >= $timeout)
				$this->fail ( "Timed out after " . $timeout . " seconds. Element '" . $locator . "' still visible." );
			try {
				if (! $this->isVisible ( $locator ))
					break;
			} catch ( Exception $e ) {
			}
			sleep ( 1 );
		}
	}
	/**
	 * Asserts that an element contains a given string.
	 *
	 * @param  string $locator
	 * @param  string $text
	 * @param  string $message
	 */
	public function assertElementContainsText($locator, $text, $message = '') {
		if ($message == '') {
			$message = sprintf ( 'Element "%1$s" does not contain text "%2$s"', $locator, $text );
		}
		$this->assertContains ( $text, $this->getText ( $locator ), $message );
	}
	/**
	 * Asserts that an element does not contain a given string.
	 *
	 * @param  string $locator
	 * @param  string $text
	 * @param  string $message
	 */
	public function assertElementNotContainsText($locator, $text, $message = '') {
		if ($message == '') {
			$message = sprintf ( 'Element "%1$s" does contain text "%2$s"', $locator, $text );
		}
		$this->assertNotContains ( $text, $this->getText ( $locator ), $message );
	}
	/**
	 * Asserts that an element is present.
	 *
	 * @param  string $locator
	 * @param  string $message
	 */
	public function assertElementPresent($locator, $message = '') {
		if ($message == '') {
			$message = sprintf ( 'Element "%s" not present.', $locator );
		}
		
		$this->assertTrue ( $this->isElementPresent ( $locator ), $message );
	}
	/**
	 * Asserts that an element is not present.
	 *
	 * @param  string $locator
	 * @param  string $message
	 */
	public function assertElementNotPresent($locator, $message = '') {
		if ($message == '') {
			$message = sprintf ( 'Element "%s" present.', $locator );
		}
		$this->assertFalse ( $this->isElementPresent ( $locator ), $message );
	}
	/**
	 * Asserts that a given text is present.
	 *
	 * @param  string $pattern
	 * @param  string $message
	 */
	public function assertTextPresent($pattern, $message = '') {
		if ($message == '') {
			$message = sprintf ( '"%s" not present.', $pattern );
		}
		$this->assertTrue ( $this->isTextPresent ( $pattern ), $message );
	}
	/**
	 * Asserts that a given text is not present.
	 *
	 * @param  string $pattern
	 * @param  string $message
	 */
	public function assertTextNotPresent($pattern, $message = '') {
		if ($message == '') {
			$message = sprintf ( '"%s" present.', $pattern );
		}
		$this->assertFalse ( $this->isTextPresent ( $pattern ), $message );
	}
	/**
	 * @param string $element
	 */
	public function clickAndWait($element) {
		$this->assertTrue ( $this->isElementPresent ( $element ), 'element: ' . $element . ' is not present' );
		$this->click ( $element );
		$this->waitForPageToLoad ( "60000" );
		$this->waitForTextNotPresent ( "Die Seite wird gerade erzeugt." );
	}
	
	/**
	 * @param string $adress
	 */
	public function open($adress) {
		parent::open ( $adress, 'true' );
		$test = DIRECTORY_SEPARATOR;
		$this->waitForTextNotPresent ( "Die Seite wird gerade erzeugt." );
	}
	
	/**
	 * @param integer $sec
	 */
	public function pause($sec) {
		usleep ( $sec * 1000 );
	}
	/**
	 * @return array
	 */
	public function getCommandLog() {
		return $this->commandLog;
	}
	/**
	 * @param string $path
	 */
	protected function clickLink($path) {
		$this->assertElementPresent ( $path );
		$this->clickAndWait ( $path );
	}
	/**
	 * @return boolean
	 */
	protected function isInternetExplorer() {
		if (FALSE === stripos ( $this->getEval ( 'navigator.appName' ), 'microsoft' )) {
			return FALSE;
		}
		return TRUE;
	}
	/**
	 * @return TestingFrameworkLight_Util_Configuration $configuration
	 */
	public function getConfiguration() {
		if (! isset ( $this->configuration )) {
			$this->configuration = new TestingFrameworkLight_Util_Configuration ();
		}
		return $this->configuration;
	}
	/**
	 * @param TestingFrameworkLight_Util_Configuration $configuration
	 */
	public function setConfiguration(TestingFrameworkLight_Util_Configuration $configuration) {
		$this->configuration = $configuration;
	}
	/**
	 * count Knot numbers
	 * 
	 * @return integer
	 */
	public function getKnotCount ($locator){		
		return $this->getXpathCount($locator);
	}	
	/**
	 * count Knot numbers
	 * 
	 * @return integer
	 */	
	public function getCssKnotCount ($locator) {
        $script = "window.document.querySelectorAll('" .$locator. "').length";
        return $this->getEval($script);
    }
	
	/**
	 * returns current URL
	 * 
	 * @return string
	 */
	public function getURL(){
		return $this->getLocation();
	}
}