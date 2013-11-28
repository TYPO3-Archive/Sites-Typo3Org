<?php


class HelloWorldTest extends PHPUnit_Framework_TestCase {

	public function testBasic() {
		$this->assertSame(
			2,
			1 + 1,
			'basic math still works'
		);
	}

}