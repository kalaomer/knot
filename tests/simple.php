<?php
/**
 * Created by PhpStorm.
 * User: kalaomer
 * Date: 4/20/14
 * Time: 3:38 PM
 */

require_once 'bootstrap.php';

$knot = ar();

// For debug mode!
PHPUnit_TextUI_Command::main();

die();

$obj = arr([
    "foo" => [
        "sub" => [
            "vuu" => "uuuuvvv"
        ],
        "another" => "pff"
    ],
    "my" => [
        "name", "is", "Knot!"
    ],
    "string" => "info.."
]);

$child = $obj->foo;

$child["new"]["way"] = "goo!";

var_dump($child);

$obj["new"]["way"] = "goo!";

$child->kill();
