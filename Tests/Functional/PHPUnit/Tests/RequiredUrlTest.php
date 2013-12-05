<?php
use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;

class RequiredUrlTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var string
	 */
	protected $baseUrl;

	/**
	 * @var Client
	 */
	protected $guzzle;

	public function setUp() {
		$domain = getenv('DOMAIN') ?: 't3org.dev';
		$this->baseUrl = 'http://' . $domain;
		$this->resetGuzzle();
	}

	protected function resetGuzzle($baseUrl = NULL) {
		$baseUrl = $baseUrl ?: $this->baseUrl;
		$this->guzzle = new Client($baseUrl);
		return $this->guzzle;
	}

	protected function assertBetweenInclusive($min, $max, $actual, $message = '') {
		if($actual < $min || $actual > $max) {
			$this->fail(sprintf('%d is not between %d and %d. %s', $actual, $min, $max, $message));
		}
		$this->addToAssertionCount(1);
	}

	/**
	 * Test if a resource at the given url exists.
	 * Accepts redirects
	 *
	 * @group production
	 * @dataProvider getRequiredUrls
	 */
	public function testUrl($url) {
		/** @var Response $response */
		// guzzle will follow redirects by default
		$response = $this->guzzle->get($url)->send();
		$this->assertBetweenInclusive(
			200, 299, $response->getStatusCode(),
			sprintf('request to %s answers with non-error status code', $url)
		);

	}

	public function getRequiredUrls() {
		$return = array();
		$filePath = __DIR__ . '/../ProjectComponents/required-urls.csv';
		if(!file_exists($filePath)) {
			throw new \InvalidArgumentException(sprintf('File %s does not exist.', $filePath));
		}

		$handle = @fopen($filePath, 'r');
		if(!$handle) {
			throw new \RuntimeException(sprinf('Could not open file %s.', $filePath));
		}
		$lineNr = 1;
		while (($line = fgets($handle, 4096)) !== false) {
			if(empty($line) || $line[0] == '#') {
				// ignore comment lines
			} else {
				$array = str_getcsv($line);
				if(count($array) != 1) {
					throw new \InvalidArgumentException(sprintf('Invalid line %d: Got %d arguments, but expected 1.', $lineNr, count($array)));
				}
				$return[] = $array;
			}
			$lineNr++;
		}
		fclose($handle);

		return $return;
	}

}
 