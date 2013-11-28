Which tests go here?
--------------------

This is the place for Unit Tests.

Unit Tests test a *single class*, preferably a single method.
If you think of mocking the TYPO3 Backend or want to have a filled test database then
this is probably a better candidate for a functional or an acceptance test.


Annotations
-----------

You can use the @group annotation to specify tests that only run on latest or deploy.

	class MyTest extends PHPUnit_Framework_TestCase {
		/**
		 * @group latest
		 */
		public function testSomethingOnLatestOnly() {
			// ...
		}

		/**
		 * @group deploy
		 */
		public function testSomethingOnDeployOnly() {
			// ...
		}
	}

http://phpunit.de/manual/3.7/en/appendixes.annotations.html#appendixes.annotations.group

