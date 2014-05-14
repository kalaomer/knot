<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 4/20/14
 * Time: 3:38 PM
 */

require_once 'bootstrap.php';

$obj = arr(array(
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
));

$child = $obj->foo;

$cild["new"]["way"] = "goo!";

var_dump($child);

$obj["new"]["way"] = "goo!";

$child->kill();