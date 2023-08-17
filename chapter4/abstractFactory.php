<?php
interface PizzaIngredientFactory
{
    public function createDough();
    public function createSauce();
    public function createCheese();
    public function createVeggies();
    public function createPepperoni();
    public function createClam();
}

class NYPizzaIngredientFactory implements PizzaIngredientFactory
{
    public function createDough()
    {
        return new ThinCrustDough();
    }

    public function createSauce()
    {
        return new MarinaraSauce();
    }

    public function createCheese()
    {
        return new ReggianoCheese();
    }
    public function createVeggies()
    {
        return [new Garlic(), new Onion(), new Mushroom(), new RedPepper()];
    }
    public function createPepperoni()
    {
        return new SlicedPepperoni();
    }
    public function createClam()
    {
        return new FreshClams();
    }
}

class ThinCrustDough
{
    public function __construct()
    {
        echo "ThinCrustDough";
    }
}
class MarinaraSauce
{
    public function __construct()
    {
        echo "MarinaraSauce";
    }
}
class ReggianoCheese
{
    public function __construct()
    {
        echo "ReggianoCheese";
    }
}
class Garlic
{
    public function __construct()
    {
        echo "Garlic";
    }
}
class Onion
{
    public function __construct()
    {
        echo "Onion";
    }
}
class Mushroom
{
    public function __construct()
    {
        echo "Mushroom";
    }
}
class RedPepper
{
    public function __construct()
    {
        echo "RedPepper";
    }
}
class SlicedPepperoni
{
    public function __construct()
    {
        echo "SlicedPepperoni";
    }
}
class FreshClams
{
    public function __construct()
    {
        echo "FreshClams";
    }
}
abstract class Pizza
{
    public $name;
    public $dough;
    public $sauce;
    public $veggies;
    public $cheese;
    public $pepperoni;
    public $clam;

    abstract function prepare();

    function bake()
    {
        echo "350度で25分焼く";
    }

    function cut()
    {
        echo "ピザを扇状に切り分ける";
    }

    function box()
    {
        echo "PizzaStoreの正式な箱にピザをいれる";
    }

    function setName(string $name)
    {
        $this->name = $name;
    }
    function getName()
    {
        return $this->name;
    }

    function toString()
    {
    }
}

class CheesePizza extends Pizza
{
    private PizzaIngredientFactory $ingredientFactory;

    public function __construct(PizzaIngredientFactory $ingredientFactory)
    {
        $this->ingredientFactory = $ingredientFactory;
    }

    function prepare()
    {
        echo $this->name . "を下処理";
        $this->dough = $this->ingredientFactory->createDough();
        $this->dough = $this->ingredientFactory->createSauce();
        $this->dough = $this->ingredientFactory->createCheese();
    }
}

class NYPizzaStore extends PizzaStore{
    function createPizza(string $item){
        $pizza = null;

        $ingredientFactory = new NYPizzaIngredientFactory();
        if($item == "チーズ"){
            $pizza = new CheesePizza($ingredientFactory);
        }
        return $pizza;
    }

}