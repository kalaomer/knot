<?php

class ParentArrayTest extends PHPUnit_Framework_TestCase {

	protected $objArray = array(
		"foo" => array(
			"sub" => array(
				"vuu" => "uuuuvvv"
			),
			"another" => "pff"
		),
		"my" => array(
			"name", "is", "Knot!"
		),
		"string" => "info.."
	);

	public function testMagicConstruct()
	{
		$obj = new \Knot\Dict\ParentDict($this->objArray, null, '');
        
        $this->assertSame($this->objArray, $obj->toArray());
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testMagicGet($obj)
	{
		$this->assertEquals("info..", $obj->string);
		$this->assertEquals(array("name", "is", "Knot!"), $obj->my->toArray());
		$this->assertEquals(array("name", "is", "Knot!"), $obj->__get('my')->toArray());
	}
	
	/**
	 * @dataProvider simpleObj
	 */
	public function testMagicSet($obj)
	{
		$obj->string = "new string";
		$this->assertEquals("new string", $obj->string);
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testMagicIsset($obj)
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
	 * @dataProvider simpleObj
	 */
	public function testMagicCallOwnFunction($obj)
	{
		$obj->simple_function = function(&$data, $value) {
			return $data["simple_data"] = $value;
		};

		$this->assertEquals("simple!", $obj->call("simple_function", "simple!"));
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testMagicInvoke($obj)
	{
		$this->assertEquals($this->objArray["foo"], $obj("foo")->toArray());
	}

	
	/**
	 * @dataProvider simpleObj
	 */
	public function testOffsetGet($obj)
	{
		$this->assertEquals('pff', $obj['foo']['another']);
		$this->assertEquals(array("vuu" => "uuuuvvv"), $obj['foo']['sub']);
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testOffsetSet($obj)
	{
		$obj['foo']['another'] = "new pff";
		$this->assertEquals("new pff", $obj['foo']['another']);

		$obj['new']['way'] = array("road 1", "road 2");
		$this->assertEquals(array("road 1", "road 2"), $obj['new']['way']);

		$obj['new'][][] = 1;
		$this->assertEquals(1, $obj['new'][0][0]);

		$obj[][][] = 2;
		$this->assertEquals(2, $obj[0][0][0]);

		$obj[] = 3;
		$this->assertEquals(3, $obj[1]);
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testOffsetExists($obj)
	{
		$this->assertEquals(true, isset($obj["foo"]["another"]));

		$this->assertEquals(false, isset($obj["foo"]["wrong way!"]));
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testOffsetUnset($obj)
	{
		unset($obj["foo"]["another"]);
		$this->assertEquals(false, isset($obj["foo"]["another"]));

		unset($obj["foo"]);
		$this->assertEquals(false, isset($obj["foo"]));
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testPath($obj)
	{
		$this->assertEquals("foo.sub", $obj->foo->sub->path());
		$this->assertEquals("foo", $obj->foo->path());
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testToArray($obj)
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
	public function testKill($obj)
	{
		$child = $obj->foo;

		$child->kill();

		$this->assertEquals(false, isset($obj->foo));

		$this->assertEquals(array(), $child->toArray());

		$obj->kill();

		$this->assertEquals(array(), $obj->toArray());
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testCount($obj)
	{
		$this->assertEquals(count($obj->toArray()), count($obj));
		$this->assertEquals(count($obj->toArray(), COUNT_RECURSIVE), $obj->count(1));
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testIteratorAggregate($obj)
	{
		foreach ($obj as $key => $value)
		{
			$this->assertEquals($obj[$key], $value);
		}
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testFatherChildRelationship($obj)
	{
		$child = $obj->foo;

		$child["new"]["way"] = "goo!";

		$this->assertEquals("goo!", $obj->foo->new->way);

		$child->kill();

		$this->assertEquals(false, isset($obj["foo"]));

		$this->assertEquals(array(), $child->toArray());
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testLastKey($obj)
	{
		$obj->lastKey = "new value";

		$this->assertEquals("lastKey", $obj->lastKey());
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testFatherCloneRelationship($obj)
	{
		$clone = $obj->foo->copy();

		$clone["new"]["way"] = "goo!";

		$this->assertEquals(false, isset($obj["foo"]["new"]["way"]));
	}

	public function testStaticPathCombiner()
	{
		$this->assertEquals("foo.sub.way", \Knot\Dict::pathCombiner(array("foo", "sub", "way")));
	}

	public function testStaticPathParser()
	{
		$this->assertEquals(array("foo", "sub", "way"), \Knot\Dict::pathParser("foo.sub.way"));
	}

	/**
	 * @dataProvider simpleObj
	 */
	public function testGet($obj)
	{

		$this->assertEquals("nothing", $obj->get("foo.sub.vuu.ee", "nothing"));

		$this->assertEquals(array(1,2,3), $obj->get("foo.sub.vuu.new", array(1,2,3))->toArray());

		$this->assertEquals("name", $obj->get("my.0"));

		$this->assertEquals(array(
			"name", "is", "Knot!"
		), $obj->get("my")->toArray());

	}

	/**
	 * @dataProvider simpleObj
	 * @expectedException \Knot\Exceptions\WrongArrayPathException
	 */
	public function testOnlyGet($obj)
	{
		$this->assertEquals("info..", $obj->getOnly("string"));

		$this->assertEquals("Nothing", $obj->getOnly("foo.string.bla-bla", "Nothing"));

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
			array(arr($this->objArray))
		);
	}

	public function simpleObjWithPatch()
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