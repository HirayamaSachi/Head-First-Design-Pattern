<?php
class Duck
{
    public ?FlyBehavior $__flyBehavior = null;
    public function __construct()
    {
    }
    public function display()
    {
    }
    public function swim()
    {
        echo "すべての鴨は浮かびます。おとりの鴨でも！";
    }
    public function performFly()
    {
        // 細かい振る舞いは知る必要がない
        $this->__flyBehavior->fly();
    }

    // 動的に振る舞いを設定することもできる
    public function setFlyBehavior(FlyBehavior $fb){
        $this->__flyBehavior = $fb;
    }
}

class  MallardDuck extends Duck
{
    public ?FlyBehavior $__flyBehavior = null;
    public function __construct()
    {
        $this->__flyBehavior = new FlyWithWings();
    }

    function display()
    {
        echo "本物のマガモです。";
    }
}

class  RedheadDuck extends Duck
{
    public ?FlyBehavior $__flyBehavior;
    public function __construct()
    {

        $this->__flyBehavior = new FlyWithWings();
    }

    function display()
    {
        echo "本物のアメリカホシハジロです。";
    }
}

interface FlyBehavior
{
    public function fly();
}

// インターフェースに対してプログラミングする
class FlyWithWings implements FlyBehavior
{
    public function fly()
    {
        echo "飛びました!";
    }
}

class FlyNoway implements FlyBehavior
{
    public function fly()
    {
        echo "飛べません";
    }
}


$mallardDuck = new MallardDuck();
$mallardDuck->performFly();
