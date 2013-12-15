<?php
use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;

class RssFeedsTest extends AbstractTestCase {

	/**
	 * Test if a given resource is a valid rss feed
	 *
	 * @group production
	 * @dataProvider getRequiredUrls
	 */
	public function testRssFeeds($url) {
		/** @var Response $response */
		// guzzle will follow redirects by default
		$response = $this->getGuzzle()->get($url)->send();
		$xml = $response->getBody(TRUE);

		libxml_use_internal_errors(TRUE);
		libxml_clear_errors();

		$xmlElement = simplexml_load_string($xml);

		// error handling when whatever is found is no valid XML
		if($xmlElement === FALSE) {
			$error = libxml_get_last_error();
			if($error) {
				/** @var LibXMLError $msg */
				$msg = sprintf(
					"Parser error in xml file with message \"%s\" in line %d, column %d.\nXML String was\n %s",
					$error->message,
					$error->line,
					$error->column,
					$xml
				);
			} else {
				$msg = sprintf("The following could not be parsed as XML:\n%s", $xml);
			}
			$this->fail($msg);
		}

		$dom = new DOMDocument();
		$dom->loadXML($xml);
		$this->assertTrue(
			$dom->schemaValidate(__DIR__ . '/../ProjectComponents/rss-2_0.xsd'),
			sprintf('the document at %s is a valid RSS Feed', $url)
		);

		$title = $xmlElement->xpath('/rss/channel/title');
		$this->assertCount(1, $title, 'feed has a title');
		$this->assertGreaterThan(3, strlen(trim((string)$title[0])), 'feed has a non-empty title');

		$description = $xmlElement->xpath('/rss/channel/description');
		$this->assertCount(1, $description, 'feed has a description');
		$this->assertGreaterThan(3, strlen(trim((string)$description[0])), 'feed has a non-empty description');

		$items = $xmlElement->xpath('/rss/channel/item');
		$this->assertGreaterThan(0, count($items), 'feed has at least one item');
	}

	public function getRequiredUrls() {
		return $this->parseCsvFile(__DIR__ . '/../ProjectComponents/rssfeed-urls.csv');
	}

}
 