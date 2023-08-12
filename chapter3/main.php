<?php
class Beverage
{
    public string $__description = "不明な飲み物";

    function getDescription()
    {
        return $this->__description;
    }

    public function cost()
    {
        return 0;
    }
}
class CondimentDecorator extends Beverage
{
    public function getDescription()
    {
    }
}

// 型を統一するためにextend を使用する
// コーヒーの種類
class Espresso extends Beverage
{
    public function __construct()
    {
        $this->__description = "エスプレッソ";
    }

    public function cost()
    {
        return 1.99;
    }
}

// トッピング
class Mocha extends CondimentDecorator
{
    public Beverage $__Beverage;

    // コーヒークラスをwrapして計算、説明文を出す
    public function __construct(Beverage $Beverage)
    {
        $this->__Beverage = $Beverage;
    }

    public function getDescription()
    {
        return $this->__Beverage->getDescription() . "モカ";
    }

    public function cost()
    {
        return $this->__Beverage->cost() + 0.2;
    }
}

$Beverage = new Espresso();
$Beverage = new Mocha($Beverage);
echo $Beverage->getDescription() . " $" . $Beverage->cost();
