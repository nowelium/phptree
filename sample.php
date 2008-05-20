<?php
class Class_Hoge {
    const const_A = 0;
    const const_B = 1.021;
    private $propertyA = array();
    private static $static_propertyB;
    protected $propertyC = array(1, 'hello', 'key_hoge' => 'value_foo', array('k1' => 'v1', 'k2' => 'v2', 'k3' => 'k4'), 1 => '7', 2 => '8');
    public $propertyD = false;
    public function public_method_aaa(){
        $hoge = new Hoge;
    }
    protected function protected_method_bbb(Hoge $a){
        $foo = $a;
    }
    private function private_method_ccc(){
        $bar = null;
    }
    public static function public_static_method_getInstance(){
        return new Hoge;
    }
}
interface Interface_Foo {
    const CONST_AAA = 1;
    const CONST_BBB = "hello";
    const CONST_CCC = false;
    public function methodA();
    public function methodB(Hoge $hoge);
    public function methodC(Hoge $foo, Hoge $bar);
}
interface Interface_Foo2 {
    const CONST_AAAAAAA = 0.123;
}
abstract class Abstract_QWERT implements Interface_Foo {
}
class Class_Hoge2 implements Interface_Foo {
    public function methodA(){
    }
    public function methodB(Hoge $hoge){
    }
    public function methodC(Hoge $hoge, Hoge $foo = null){
    }
}
class Class_Hoge3 extends Abstract_QWERT {
    public function methodA(){
    }
    public function methodB(Hoge $hoge){
    }
    public function methodC(Hoge $hoge, Hoge $foo = null){
    }
}
class Class_Hoge4 extends Class_Hoge {
}

$foofoofoo = array();
function global_bar(){
}
?>
