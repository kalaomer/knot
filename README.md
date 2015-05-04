# Knot

[![Build Status](https://travis-ci.org/kalaomer/knot.svg?branch=v1.1.2)](https://travis-ci.org/kalaomer/knot)
[![Dependency Status](https://www.versioneye.com/user/projects/53530290fe0d079af90001d5/badge.png)](https://www.versioneye.com/user/projects/53530290fe0d079af90001d5)
[![Latest Version](http://img.shields.io/github/tag/kalaomer/knot.svg)](https://github.com/kalaomer/knot/releases)
[![Coverage Status](https://coveralls.io/repos/kalaomer/knot/badge.png)](https://coveralls.io/r/kalaomer/knot)

## Other README Files
- [Türkçe Kılavuz](./README-TR.md)

Knot is a very powerful tool for array. Knot help for using arrays like objects! And Knot have very rich function library.

Simple Example;
```
$obj = ar(1,2,3);

$obj->merge(array(3,3,4,5,6,7))->unique();

$obj->child = array("a", "b", "c");

$array = $obj->toArray();
```

In this example, first Knot created and Knot's data have ```array(1,2,3)``` for now. Then $obj's data is merged with ```array(3,3,4,5,6,7)```. Then ```array_unique``` function called and $obj's data changed. The next line, created child key in data and equalized to ```array("a", "b", "c")```. In the last line, $obj's data is converted to Array.

Knot is prepared with [PSR-0](http://www.php-fig.org/psr/psr-0/) and [PSR-1](http://www.php-fig.org/psr/psr-1/) standards.

## Install

Knot is available for Composer.
```
{
    "require": {
        "knot/knot": "v1.*"
    }
}
```

Or download from [Github](https://github.com/kalaomer/knot/archive/master.zip).

## Startup

This is three ways for creating Knot object with easy way.

### ar(...)

This function create Knot data with sent arguments.

Example:
```
$obj = ar(1,2,3);

// Returns array(1,2,3)
$obj->toArray();
```

### arr($array)

This function use first Array argument for Knot data.

Örnek:
```
$obj = arr(array(1,2,3,'a'=>4));

// Returns array(1,2,3,'a'=>4)
$obj->toArray();
```

### arrRef(&$array)

This function likes arr() function. Different for using first argument reference for Knot data.

## Using Knot Object

```toArray``` functions using when convert Knot's data to Array.

Example:
```
$obj = ar(1,2,3);

// Returns array(1,2,3)
$obj->toArray();
```

In addition, ```toArray``` gives reference to Knot's data.

Example:
```
$obj = ar();

$array =& $obj->toArray();

$array["foo"] = 1;

// Returns array("foo"=>1)
$obj->toArray();
```

### Use like Array

Knot object can be used like Arrays. Because Knot have [ArrayAccess](http://www.php.net/manual/en/class.arrayaccess.php) interface.

Example:
```
$obj = ar();

$obj["new"]["way"] = "new way value";

$obj[][][][] = 1;
```

Knot's data can be changed with this way.

### Other Using Ways

Also ```__get``` method can be access to Knot's data. But if target is an Array, then ```get``` return Knot Child. So functions can be used with recursive.

Also ```__set``` functions can be changed to Knot's data.

Example:
```
$obj = ar();

$obj->new = array(
    "way" => "new value"
);

// Returns array("way" => "new value")
$obj->new->toArray();
```

This is a point to take into consideration. If trying to setting nonexistent way, then Knot's data merged with stdClass objects.

Examlpe:
```
$obj = ar();

$obj->new->way->foo = 1;
```

In this example, $obj's data's ```new``` key is changed with stdClass object.

## Functions

Knot have many functions. Also It can be added new functions to Knot.

### Knot Functions

Knot have many own functions.

#### get($path, [$default_value])

Knot can find target data with address. So Knot can find target with small commands.

Knot using ```.``` letter for show address.

Example Address: ```foo.sub.target```

In this example's target is "sub" key of "foo" of Knot's data.

Let's get target with this way.

Example:
```
$obj = arr(array(
    "foo" => array(
        "sub" => array(
            "target" => 123
        )
    )
));

// Returns $obj["foo"]["sub"]["target"]
$target = $obj->get("foo.sub.target");
```

Also ```get``` can be used with default value. If ```get``` have default value and target nonexistent, then ```get``` create target and change this value to default value.

If target is nonexistent and default value doesn't given, then ```get``` throws an error.

In addition, if target is an array, then Knot will return Knot Child for recursive using.

#### set($path, $value)

```set``` use same thing that ```get``` functions address usage. ```set``` change to value from target of Knot's data.

If changed value is an array, Knot return Knot Child so

In addition, if target is an array, then Knot will return Knot Child for recursive using.

#### del($path)

```del``` use same thing that ```get``` functions address usage. ```del``` delete targets.

[... to be continued]

## Last

PHP 5.3 not supported yet, but this will be fixed!

Please contact me kalaomer@hotmail.com