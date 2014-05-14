<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 4/20/14
 * Time: 2:16 PM
 */

class PHPArrayChangerHelperTest extends PHPUnit_Framework_TestCase {

	public function testArrayShift()
	{
		$obj = ar(1, 2, 3);

		$this->assertEquals(1, $obj->shift());

		$this->assertEquals(array(2, 3), $obj->toArray());
	}

	public function testArrayUnshift()
	{
		$obj = ar(2, 3);

		$this->assertEquals(3, $obj->unshift(1));

		$this->assertEquals(array(1, 2, 3), $obj->toArray());
	}
}
 