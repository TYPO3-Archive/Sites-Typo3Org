<?php
/**
 * Configuration to get the config from xml files 
 * @package TestingFramework_Util
 */
class TestingFrameworkLight_Util_PageIdProvider {

	/** 
	 * Read the page IDs from local xml file if exists
	 */
	 public static function pageIdProvider($pageIdXml){
		$xmlfile = dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'conf'.DIRECTORY_SEPARATOR.$pageIdXml;
		if (!is_file($xmlfile)) {
				throw new Exception('XML file with page ids not available - expected:'.$xmlfile);
		}
		$pageIDs = self::readFromXmlFile($xmlfile);
        return $pageIDs;
    }


	/**
	 * @param string $path
	 * @return array
	 */
	public static function readFromXmlFile($path){
		$defaults = array();
		if(file_exists($path)){
			$xml = new SimpleXMLElement(file_get_contents($path));
				foreach($xml->var as $element){
					$name = current($element['name']);
					$value = current($element['value']);
					$defaults[] = array($name,$value);					
				}
			}			
		return $defaults;
	}
}