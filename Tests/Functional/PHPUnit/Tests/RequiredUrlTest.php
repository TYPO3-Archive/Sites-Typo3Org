<?php
use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;

class RequiredUrlTest extends AbstractTestCase {

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
		$response = $this->getGuzzle()->get($url)->send();
		$this->assertBetweenInclusive(
			200, 299, $response->getStatusCode(),
			sprintf('request to %s answers with non-error status code', $url)
		);

	}

	public function getRequiredUrls() {
		return $this->parseCsvFile(__DIR__ . '/../ProjectComponents/required-urls.csv');
	}

}
 