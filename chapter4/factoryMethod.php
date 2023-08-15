<?php

abstract class PizzaStore
{
    public function __construct()
    {
    }

    function orderPizza(string $type)
    {
        $Pizza = $this->createPizza($type);
        $Pizza->prepare();
        $Pizza->bake();
        $Pizza->cut();
        $Pizza->box();
    }

    // 製品の作成はサブクラスが行う
    abstract public function createPizza(string $item);
}

class NYPizzaStore extends PizzaStore
{
    public function createPizza(string $item)
    {
        if ($item == "チーズ") {
            $pizza = new NYCheesePizza();
        } elseif ($item == "ペペロニ") {
            $pizza = new NYPepperoniPizza();
        } elseif ($item == "野菜") {
            $pizza = new NYVeggiePizza();
        } else {
            return null;
        }
        return $pizza;
    }
}

abstract class Pizza
{
    public $__name = "";
    public $__dough = "";
    public $__sauce = "";
    public $__toppings = [];

    public function prepare()
    {
        echo $this->__name . "を下処理\n";
        echo "生地を捏ねる\n";
        echo "ソースを追加\n";
        echo "トッピングを追加\n";
        for ($i = 0; $i < count($this->__toppings); $i++) {
            echo " " . $this->__toppings[$i] . "\n";
        }
    }

    public function bake()
    {
        echo "350度で25分焼く\n";
    }

    public function cut()
    {
        echo "ピザを扇状に切り分ける\n";
    }

    public function box()
    {
        echo "箱にピザを入れる\n";
    }
    public function getName()
    {
        return $this->__name;
    }
}

class NYCheesePizza extends Pizza
{
    public function __construct()
    {
        $this->__name = "NYピザ";
        $this->__dough = "薄いクラスト生地";
        $this->__sauce = "マリナラソース";
        array_push($this->__toppings, "粉エッジャーノチーズ");
    }
}

class NYPepperoniPizza extends Pizza
{
}

class NYVeggiePizza extends Pizza
{
}

$nyStore = new NYPizzaStore();
$nyStore->orderPizza("チーズ");
