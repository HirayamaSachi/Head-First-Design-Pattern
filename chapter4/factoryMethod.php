<?php

class SimplePizzaFactory
{
    public function createPizza(string $type)
    {
    }
}

abstract class PizzaStore
{
    public function __construct(SimplePizzaFactory $Factory)
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
    private $__name = "";
    private $__dough = "";
    private $__sauce = "";
    private $__toppings = [];
}

class NYCheesePizza
{
    public function prepare()
    {
    }
    public function bake()
    {
    }
    public function cut()
    {
    }
    public function box()
    {
    }
}

class NYPepperoniPizza
{
    public function prepare()
    {
    }
    public function bake()
    {
    }
    public function cut()
    {
    }
    public function box()
    {
    }
}

class NYVeggiePizza
{
    public function prepare()
    {
    }
    public function bake()
    {
    }
    public function cut()
    {
    }
    public function box()
    {
    }
}
