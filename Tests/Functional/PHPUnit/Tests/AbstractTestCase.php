<?php
use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;

abstract class AbstractTestCase extends PHPUnit_Framework_TestCase {

	/**
	 * @var string
	 */
	protected $baseUrl;


	public function setUp() {
		$domain = getenv('DOMAIN') ?: 't3org.dev';
		$this->baseUrl = 'http://' . $domain;
	}

	/**
	 * @param null $baseUrl
	 * @return Client
	 */
	protected function getGuzzle($baseUrl = NULL) {
		$baseUrl = $baseUrl ?: $this->baseUrl;
		return new Client($baseUrl);
	}

	protected function assertBetweenInclusive($min, $max, $actual, $message = '') {
		if($actual < $min || $actual > $max) {
			$this->fail(sprintf('%d is not between %d and %d. %s', $actual, $min, $max, $message));
		}
		$this->addToAssertionCount(1);
	}

	public function parseCsvFile($filePath) {
		$parser = new CsvParser();
		return $parser->parseCsvFile($filePath);
	}

}
 