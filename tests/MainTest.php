<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";

class DataTest extends PHPUnit_Framework_TestCase
{

	Protected $objArray = array(
		1,2,3,
		"foo" => array(
			"sub" => array(
				"vuu" => "uuuuvvv"
			),
			"another" => "pff"
		),
		"my" => array(
			"name", "is", "EasyArray!"
		),
		"string" => "info.."
	);

	/**
	 * @dataProvider simpleObj
	 */
	Public function testMagicGet($obj)
	{
		$this->assertEquals("info..", $obj->string);
		$this->assertEquals(array("name", "is", "EasyArray!"), $obj->my->toArray());
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testMagicSet($obj)
	{
		$obj->string = "new string";
		$this->assertEquals("new string", $obj->string);
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testMagicIsset($obj)
	{
		$this->assertEquals(true, isset($obj->string));
		$this->assertEquals(false, isset($obj->nothing));
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testMagicUnset($father)
	{
		unset($father->string);
		$this->assertArrayNotHasKey("string", $father->toArray());
	}

	/**
	 * @dataProvider simpleObjWithPatch
	 */
	Public function testMagicCallMerge($obj, $patch)
	{
		$array = $obj->toArray();

		$newArray = array_merge($array, $patch);

		$obj->merge($patch);

		$this->assertEquals($newArray, $obj->toArray());
	}

	/**
	 * @dataProvider simpleObjWithPatch
	 */
	Public function testMagicCallMergeRecursive($obj, $patch)
	{
		$array = $obj->toArray();

		$newArray = array_merge_recursive($array, $patch);

		$obj->merge_recursive($patch);

		$this->assertEquals($newArray, $obj->toArray());
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testMagicCallShift($obj)
	{
		$array = $obj->toArray();

		$funcResult = array_shift($array);

		$objResult = $obj->shift();

		$this->assertEquals($array, $obj->toArray());
		$this->assertEquals($funcResult, $objResult);
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testGet($obj)
	{

		$this->assertEquals("nothing", $obj->get("foo.sub.vuu.ee","nothing"));

		$this->assertEquals(array(1,2,3), $obj->get("foo.sub.vuu.new", array(1,2,3))->toArray());

        $this->assertEquals("name", $obj->get("my.0"));

		$this->assertEquals(array(
            "name", "is", "EasyArray!"
		), $obj->get("my")->toArray());

	}

	/**
	 * @dataProvider simpleObj
	 * @expectedException \Knot\Exceptions\WrongArrayPathException
	 */
	Public function testOnlyGet($obj)
	{
		$this->assertEquals("info..", $obj->only_get("string"));

		$this->assertEquals("Nothing", $obj->only_get("foo.string.bla-bla", "Nothing"));

		$this->assertEquals("Nothing", $obj->only_get("foo.string.bla-bla", "Nothing"));

		// Exception HERE!
		$this->assertEquals("Nothing", $obj->only_get("foo.string.bla-bla"));
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testSet($obj)
	{
		$obj->set("a.b.c", "d");

		$this->assertEquals("d", $obj->get("a.b.c"));
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testMagicCallOwnFunction($obj)
	{
		$obj->simple_function = function(&$data, $value)
		{
			return $data["simple_data"] = $value;
		};

		$this->assertEquals("simple!", $obj->simple_function("simple!"));
		$this->assertEquals("simple!", $obj->get("simple_data"));
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testIsPath($obj)
	{
		$this->assertEquals(true, $obj->is_path("foo.sub"));

		$this->assertEquals(false, $obj->is_path("foo.sub.aa.bb"));

		$this->assertEquals(true, $obj->is_path("string"));
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testDel($obj)
	{
		$obj->del("foo.sub");

		$this->assertEquals(false, $obj->is_path("foo.sub"));

		$obj->del("string");

		$this->assertEquals(false, $obj->is_path("string"));
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testOffsetGet($obj)
	{
		$this->assertEquals('pff', $obj['foo']['another']);
		$this->assertEquals(array("vuu" => "uuuuvvv"), $obj['foo']['sub']);
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testOffsetSet($obj)
	{
		$obj['foo']['another'] = "new pff";
		$this->assertEquals("new pff", $obj['foo']['another']);

		$obj['new']['way'] = array("road 1", "road 2");
		$this->assertEquals(array("road 1", "road 2"), $obj['new']['way']);

		$obj['new'][][] = 1;
		$this->assertEquals(1, $obj['new'][0][0]);
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testOffsetExists($obj)
	{
		$this->assertEquals(true, isset($obj["foo"]["another"]));

		$this->assertEquals(false, isset($obj["foo"]["wrong way!"]));
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testOffsetUnset($obj)
	{
		unset($obj["foo"]["another"]);

		$this->assertEquals(false, isset($obj["foo"]["another"]));
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testPath($obj)
	{
		$this->assertEquals("foo.sub", $obj->foo->sub->path());
		$this->assertEquals("foo", $obj->foo->path());
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testToArray($obj)
	{
		$this->assertEquals($this->objArray, $obj->toArray());

		$array =& $obj->toArray();

		$array["array_patch"] = "patch!";

		$this->assertEquals("patch!", $obj->array_patch);
		$this->assertEquals($array, $obj->toArray());
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testKill($obj)
	{
		$child = $obj->foo;

		$child->kill();

		$this->assertEquals(false, isset($obj->foo));

		$this->assertEquals(array(), $child->toArray());

		$child->new = "way";

		$this->assertEquals(false, isset($obj->foo->new));
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testFatherChildRelationship($obj)
	{
		$child = $obj->foo;

		$child->set("new.way", "goo!");

		$this->assertEquals("goo!", $obj->foo->new->way);

	//	var_dump($child->toArray(),$obj->toArray());

		$child->kill();

		$this->assertEquals(false, isset($obj["foo"]));

		$this->assertEquals(array(), $child->toArray());
	}

	/**
	 * @dataProvider simpleObj
	 */
	Public function testFatherCloneRelationship($obj)
	{
		$clone = $obj->foo->copy();

		$clone->set("new.way", "goo!");

		var_dump($clone->toArray(),$obj->toArray());

		$this->assertEquals(false, $obj->is_path("foo.new.way"));
	}


	Public function simpleObj()
	{
		return array(
			array(arr($this->objArray))
		);
	}

	Public function simpleObjWithPatch()
	{
		return array(
			array(
				arr($this->objArray),
				array(
					4,5,6,
					"foo" => array(
						"sub" => array(
							"dipptt" => "ssss"
						)
					),
					"your" => array(
						"name", "is", "Sir!"
					),
					"string" => "new info"
				)
			)
		);
	}
}