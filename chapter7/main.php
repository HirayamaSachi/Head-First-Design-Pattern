<?php

use MallardDuck as GlobalMallardDuck;

interface Duck2
{
    public function fly();
    public function quack();
}

class MallardDuck implements Duck2
{
    public function quack()
    {
        echo "ガーガー";
    }

    public function fly()
    {
        echo "飛んでます";
    }
}
interface Turkey
{
    public function gobble();
    public function fly();
}

class WildTurkey implements Turkey
{
    public function gobble()
    {
        echo "ごろごろ";
    }

    public function fly()
    {
        echo "短い距離を飛んでます";
    }
}

class TurkeyAdapter implements Duck2
{
    public Turkey $turkey;
    public function __construct(Turkey $turkey)
    {
        $this->turkey = $turkey;
    }
    public function quack()
    {
        $this->turkey->gobble();
    }
    public function fly()
    {
        for ($i = 0; $i < 5; $i++) {
            $this->turkey->fly();
        }
    }
}

$duck = new MallardDuck();
$turkey = new WildTurkey();

$turkeyAdapter = new TurkeyAdapter($turkey);

$turkey->gobble();
$duck->quack();
$turkeyAdapter->quack();
