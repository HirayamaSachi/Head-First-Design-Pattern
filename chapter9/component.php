<?php
abstract class MenuComponent
{
    public function add(MenuComponent $menuComponent): void
    {
        throw new ErrorException('unsupported operation error');
    }

    public function remove(MenuComponent $menuComponent): void
    {
        throw new ErrorException('unsupported operation error');
    }

    public function getChild(int $i): MenuComponent
    {
        throw new ErrorException('unsupported operation error');
    }

    public function getName(): String
    {
        throw new ErrorException('unsupported operation error');
    }

    public function getDescription(): String
    {
        throw new ErrorException('unsupported operation error');
    }

    public function getPrice(): int
    {
        throw new ErrorException('unsupported operation error');
    }

    public function isVegetarian(): bool
    {
        throw new ErrorException('unsupported operation error');
    }

    public function print(): void
    {
        throw new ErrorException('unsupported operation error');
    }
}

class MenuItem extends MenuComponent
{
    public String $name;
    public String $description;
    public bool $vegetarian;
    public int $price;

    public function __construct(
        String $name,
        String $description,
        bool $vegetarian,
        int $price
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->vegetarian = $vegetarian;
        $this->price = $price;
    }
    public function getName(): String
    {
        return $this->name;
    }
    public function getDescription(): String
    {
        return $this->description;
    }
    public function isVegetarian(): bool
    {
        return $this->vegetarian;
    }
    public function getPrice(): int
    {
        return $this->price;
    }

    public function print(): void
    {
        echo " " . $this->getName();
        if ($this->isVegetarian()) {
            echo "(v)";
        }
        echo "," . $this->getPrice();
        echo " -- " . $this->getDescription();
    }
}

class Menu extends MenuComponent
{
    public array $menuComponents = [];
    public String $name;
    public String $description;

    public function __construct(String $name, String $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function add(MenuComponent $menuComponent): void
    {
        $this->menuComponents[] = $menuComponent;
    }

    public function remove(MenuComponent $menuComponent): void
    {
        array_filter($this->menuComponents, function ($menuItem) use ($menuComponent) {
            return $menuItem !== $menuComponent;
        });
    }


    public function getChild(int $i): MenuComponent
    {
        return $this->menuComponents[$i];
    }

    public function getNAme(): String
    {
        return $this->name;
    }

    public function getDescription(): String
    {
        return $this->description;
    }

    public function print(): void
    {
        echo "\n" . $this->getName();
        echo "," . $this->getDescription();
        echo "\n--------------\n";

        foreach ($this->menuComponents as $menuComponent) {
            echo $menuComponent->print();
        }
    }
}

class Waitress
{
    public MenuComponent $allMenus;
    public function __construct(MenuComponent $allMenus)
    {
        $this->allMenus = $allMenus;
    }

    public function printMenu(): void
    {
        $this->allMenus->print();
    }
}

$pancakeHouseMenu = new Menu("パンケーキハウスメニュー", "朝食");
$dinerMenu = new Menu("食堂メニュー", "昼食");
$cafeMenu = new Menu("カフェメニュー", "夕食");
$desertMenu = new Menu("デザートメニュー", "もちろんデザート!");

$allMenus = new Menu("全てのメニュー", "全てを統合したメニュー");

$allMenus->add($pancakeHouseMenu);
$allMenus->add($dinerMenu);
$allMenus->add($cafeMenu);

$dinerMenu->add(new MenuItem("パスタ", "マリナラソースのかかったパスタとパン", true, 380));
$allMenus->add($desertMenu);

$dinerMenu->add($desertMenu);

$desertMenu->add(new MenuItem("アップルパイ", "バニラアイスを乗せたフレーク上生地のアップルパイ", true, 160));

$waitress = new Waitress($allMenus);

$waitress->printMenu();
