<?php
/**
 * Configuration to get the config from xml files 
 * @package TestingFramework_Util
 */
class TestingFrameworkLight_Util_Configuration {
	/**
	 * Set the defaults
	 */
	public function __construct() {
		$this->loadDefaults();
	}
	
	/**
	 * @param string $key
	 * @return string
	 */
	public function getValue($key) {
		if (!defined($key )) {
			throw new Exception ( 'config key not found: ' . $key );
		}
		return constant($key );
	}
	/**
	 * @param string $key
	 * @return boolean
	 */
	public function issetKey($key) {
		return defined($key );
	}
	/** 
	 * Read the defaults form local xml file if exists
	 */
	private function loadDefaults(){
		$xmlfile = dirname(dirname(dirname(__FILE__))).'/conf/defaults.xml';
		$defaults = $this->readFromXmlFile($xmlfile);
		foreach($defaults as $key=>$value){
			if (!defined($key )) {
				if (isset($GLOBALS[$key ])) {
					$value = $GLOBALS[$key ];
				}
				define($key,$value);
			}
		}
	}
	/**
	 * @param string $path
	 * @return array
	 */
	public function readFromXmlFile($path){
		$defaults = array();
		if(file_exists($path)){
			$xml = new SimpleXMLElement(file_get_contents($path));
			if(isset($xml->php) && isset($xml->php->var)){
				foreach($xml->php->var as $element){
					$name = current($element['name']);
					$value = current($element['value']);
					$defaults[$name] = $value;
				}
			}
		}
		return $defaults;
	}
}