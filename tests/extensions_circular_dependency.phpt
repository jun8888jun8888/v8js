--TEST--
Test V8::registerExtension() : Circular dependencies
--SKIPIF--
<?php require_once(dirname(__FILE__) . '/skipif.inc'); ?>
--FILE--
<?php

V8Js::registerExtension('a', 'print("A");', array('b'));
V8Js::registerExtension('b', 'print("B");', array('a'));

var_dump(V8JS::getExtensions());

$a = new V8Js('myobj', array(), array('a'));
?>
--EXPECTF--
array(2) {
  ["a"]=>
  array(2) {
    ["auto_enable"]=>
    bool(false)
    ["deps"]=>
    array(1) {
      [0]=>
      string(1) "b"
    }
  }
  ["b"]=>
  array(2) {
    ["auto_enable"]=>
    bool(false)
    ["deps"]=>
    array(1) {
      [0]=>
      string(1) "a"
    }
  }
}

Warning: Fatal V8 error in v8::Context::New(): Circular extension dependency in %s on line 8

Fatal error: Uncaught V8JsException: Failed to create V8 context. Check that registered extensions do not have errors. in %s:8
Stack trace:
#0 %s(8): V8Js->__construct('myobj', Array, Array)
#1 {main}
  thrown in %s on line 8
