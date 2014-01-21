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
			$this->fail($this->displayXmlError(libxml_get_last_error()));
		}

		$dom = new DOMDocument();
		$dom->loadXML($xml);
		libxml_clear_errors();
		$validated = $dom->schemaValidate(__DIR__ . '/../ProjectComponents/rss-2_0.xsd');
		if(!$validated) {
			$this->fail($this->displayXmlError(libxml_get_last_error()));
		}
		$this->assertTrue(
			$validated,
			sprintf('the document at %s is a valid RSS Feed', $url)
		);

		$title = $xmlElement->xpath('/rss/channel/title');
		$this->assertCount(1, $title, 'feed has a title');
		$this->assertGreaterThan(3, strlen(trim((string)$title[0])), 'feed has a non-empty title');

		$items = $xmlElement->xpath('/rss/channel/item');
		$this->assertGreaterThan(0, count($items), 'feed has at least one item');

		$lastBuildDate = $xmlElement->xpath('/rss/channel/lastBuildDate');
		if($lastBuildDate) {
			$lastBuildDateTime = strtotime($lastBuildDate[0]);
			$this->assertNotSame(FALSE, $lastBuildDate, 'lastBuildDate is a parseable date');
			$this->assertGreaterThanOrEqual(
				strtotime('-3 months'),
				$lastBuildDateTime,
				sprintf('lastBuildDate (%s) is later than 3 months ago.', $lastBuildDate[0])
			);

			if($response->hasHeader('Last-Modified')) {
				$lastModifiedHeader = $response->getHeader('Last-Modified');
				$lastModifiedDateTime = strtotime($lastModifiedHeader);
				$this->assertNotSame(FALSE, $lastModifiedHeader, 'Last-Modified Header is a parseable date');
				// http://forge.typo3.org/issues/53084
				$this->assertGreaterThanOrEqual(
					$lastBuildDateTime,
					$lastModifiedDateTime,
					sprintf('Last-Modified header (%s) is greater than lastBuildDate (%s) in RSS.', $lastModifiedHeader, $lastBuildDate)
				);
			}
		}
		$this->assertGreaterThan(0, count($items), 'feed has at least one item');
	}

	public function getRequiredUrls() {
		return $this->parseCsvFile(__DIR__ . '/../ProjectComponents/rssfeed-urls.csv');
	}

	protected function displayXmlError($error) {
		if($error) {
			/** @var LibXMLError $msg */
			$msg = sprintf(
				"Parser error with message \"%s\" in line %d, column %d.",
				$error->message,
				$error->line,
				$error->column
			);
		} else {
			$msg = "There was some error while parsing the XML. That's all I know - sorry.";
		}

		return $msg;
	}

}
 