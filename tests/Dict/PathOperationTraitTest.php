<?php

/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 18.06.2015
 * Time: 16:39
 */
class PathOperationTraitTest extends PHPUnit_Framework_TestCase {

	protected $objArray = array(
		"foo"    => array(
			"sub"     => array(
				"vuu" => "uuuuvvv"
			),
			"another" => "pff"
		),
		"my"     => array(
			"name",
			"is",
			"Knot!"
		),
		"string" => "info.."
	);


	/**
	 * @dataProvider simpleObj
	 */
	public function testGet($obj)
	{

		$this->assertEquals("nothing", $obj->get("foo.sub.vuu.ee", "nothing"));

		$this->assertEquals(array( 1, 2, 3 ), $obj->get("foo.sub.vuu.new", array( 1, 2, 3 ))->toArray());

		$this->assertEquals("name", $obj->get("my.0"));

		$this->assertEquals(array(
			"name",
			"is",
			"Knot!"
		), $obj->get("my")->toArray());

		$this->assertEquals('ok!', $obj->get('create.later', function ()
		{
			return 'ok!';
		}));

		$this->assertEquals('ok!', $obj->get('create.later'));

	}


	/**
	 * @dataProvider simpleObj
	 * @expectedException \Knot\Exceptions\WrongArrayPathException
	 */
	public function testOnlyGet($obj)
	{
		$this->assertEquals("info..", $obj->getOnly("string"));

		$this->assertEquals("Nothing", $obj->getOnly("foo.string.bla-bla", "Nothing"));

		$this->assertFalse($obj->isPath("foo.string.bla-bla"));

		$this->assertEquals("ok!", $obj->getOnly("nothing", function ()
		{
			return "ok!";
		}));

		// Exception HERE!
		$this->assertEquals("Nothing", $obj->getOnly("foo.string.bla-bla"));
	}


	/**
	 * @dataProvider simpleObj
	 */
	public function testSet($obj)
	{
		$obj->set("a.b.c", "d");

		$this->assertEquals("d", $obj->get("a.b.c"));

		$this->assertEquals("foo!", $obj->set("here.is", function ()
		{
			return "foo!";
		}));
	}


	/**
	 * @dataProvider simpleObj
	 */
	public function testIsPath($obj)
	{
		$this->assertEquals(true, $obj->isPath("foo.sub"));

		$this->assertEquals(false, $obj->isPath("foo.sub.aa.bb"));

		$this->assertEquals(true, $obj->isPath("string"));
	}


	/**
	 * @dataProvider simpleObj
	 */
	public function testDel($obj)
	{
		$obj->del("foo.sub");

		$this->assertEquals(false, $obj->isPath("foo.sub"));

		$obj->del("string");

		$this->assertEquals(false, $obj->isPath("string"));

		$obj->del("string");

		$this->assertSame($obj, $obj->del("no.way"));
	}


	public function simpleObj()
	{
		return array(
			array( arr($this->objArray) )
		);
	}
}
