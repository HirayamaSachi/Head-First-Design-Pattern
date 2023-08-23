<?php
abstract class CaffeineBeverage
{
    final function prepareRecipe()
    {
        $this->boilWater();
        $this->brew();
        $this->pourInCup();
        // フック
        // デフォルト実装
        if ($this->customerWantsCondiments()) {
            $this->addCondiments();
        }
    }

    abstract protected function brew();
    abstract protected function addCondiments();

    public function boilWater()
    {
        echo "お湯を沸かします\n";
    }

    public function pourInCup()
    {
        echo "カップに注ぎます\n";
    }

    public function customerWantsCondiments()
    {
        return true;
    }
}

class Tea extends CaffeineBeverage
{
    protected function brew()
    {
        echo "紅茶を浸します\n";
    }

    protected function addCondiments()
    {
        echo "砂糖とミルクを追加します\n";
    }

    // 必要な場合のみオーバーライドできる
    public function customerWantsCondiments()
    {
        $answer = $this->getUserInput();

        if ($answer == "y") {
            return true;
        } else {
            return false;
        }
    }

    private function getUserInput()
    {
        $answer = readline("コーヒーにミルクを入れますか?(y/n)");
        return $answer;
    }
}

$tea = new Tea();
$tea->prepareRecipe();
