<?php
// 変更があればObserverに通知する
interface Subject
{
    public function registerObserver(Observer $o);
    public function removeObserver(Observer $o);
    public function notifyObservers();
}

// 通知を受け取る側
interface Observer
{
    public function update(float $temp, float $humidity, float $pressure);
}

interface DisplayElement
{
    public function display();
}

class WeatherData implements Subject
{
    private array $__observers = [];
    private float $__temp;
    private float $__humidity;
    private float $__pressure;

    public function registerObserver(Observer $o)
    {
        array_push($this->__observers, $o);
    }

    public function removeObserver(Observer $o)
    {
        if ($del_index = array_search($o, $this->__observers)) {
            unset($this->__observers[$del_index]);
        }
    }

    public function notifyObservers()
    {
        foreach ($this->__observers as $o) {
            $observer = $o;
            $observer->update($this->__temp, $this->__humidity, $this->__pressure);
        }
    }

    // 変更されたら通知
    public function measurementsChanged()
    {
        $this->notifyObservers();
    }

    // 変更された値のセット
    public function setMeasurements(float $temp, float $humidity, float $pressure)
    {
        $this->__temp = $temp;
        $this->__humidity = $humidity;
        $this->__pressure = $pressure;
        $this->measurementsChanged();
    }
}

// 具象サブクラス
// 複数のインターフェースを指定できる
class CurrentConditionsDisplay implements Observer, DisplayElement
{
    private float $__temp;
    private float $__humidity;
    private Subject $__WeatherData;

    public function __construct(Subject $WeatherData)
    {
        $this->__WeatherData = $WeatherData;
        $this->__WeatherData->registerObserver($this);
    }

    public function update(float $temp, float $humidity, float $pressure)
    {
        $this->__temp = $temp;
        $this->__humidity = $humidity;
        $this->display();
    }

    public function display()
    {
        echo "現在の気象状況: \n湿度: " . $this->__temp . "度\n";
        echo "湿度: " . $this->__humidity . "%\n";
    }
}

$WeatherData = new WeatherData();

$CurrentConditionDisolay = new CurrentConditionsDisplay($WeatherData);
$WeatherData->setMeasurements(27, 65, 30.4);
$WeatherData->setMeasurements(28, 70, 29.2);
