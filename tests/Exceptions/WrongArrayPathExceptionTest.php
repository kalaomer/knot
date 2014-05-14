<?php

class WrongArrayPathExceptionTest extends PHPUnit_Framework_TestCase {

	public function testToString()
	{
		$e = new \Knot\Exceptions\WrongArrayPathException("foo");

		$this->assertEquals('Knot\\Exceptions\\WrongArrayPathException:[0]: Wrong Path. Path: foo\n', $e->__toString());
	}
}