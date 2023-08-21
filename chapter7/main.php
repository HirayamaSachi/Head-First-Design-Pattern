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

class HomeTheaterFacade
{
    public Amplifier $amp;
    public Tuner $tuner;
    public DvdPlayer $dvd;
    public CdPlayer $cd;
    public Projector $projector;
    public TheaterLights $lights;
    public Screes $screen;
    public PopcornPopper $popper;

    public function HomeTheaterFacade(
        Amplifier $amp,
        Tuner $tuner,
        DvdPlayer $dvd,
        CdPlayer $cd,
        Projector $projector,
        TheaterLights $lights,
        Screes $screen,
        PopcornPopper $popper
    ) {
        $this->popper = $popper;
        $this->screen = $screen;
        $this->lights = $lights;
        $this->projector = $projector;
        $this->cd = $cd;
        $this->dvd = $dvd;
        $this->tuner = $tuner;
        $this->amp = $amp;
    }

    public function watchMovie(String $movie){
        echo "映画を見る準備をします";
        $this->popper->on();
        $this->popper->pop();
        $this->lights->dim(10);
        $this->screen->down();
        $this->projector->on();
        $this->projector->wideScreenMode();
        $this->amp->on();
        $this->amp->setDvd($this->dvd);
        $this->amp->setSurroundSound();
        $this->amp->setVolume(5);
        $this->dvd->on();
        $this->dvd->play($movie);
    }

    public function endMovie(){
        echo "ムービーシアターを停止します";
        $this->popper->off();
        $this->lights->on();
        $this->screen->up();
        $this->projector->off();
        $this->amp->off();
        $this->dvd->stop();
        $this->dvd->eject();
        $this->dvd->off();
    }
}

class PopcornPopper
{
    public function __construct()
    {
    }

    public function on(){
        echo "popをonする";
    }

    public function pop(){
        echo "popをpopする";
    }

    public function off(){
        echo "popをoffする";
    }
}
class Screes
{
    public function __construct()
    {
    }

    public function down(){
        echo "スクリーンをdownする";
    }

    public function up(){
        echo "スクリーンをupする";
    }
}
class TheaterLights
{
    public function __construct()
    {
    }

    public function dim(int $mode){
        echo "ライトの明るさを{$mode}にします";
    }

    public function on(){
        "ライトをつけます";
    }
}
class Projector
{
    public function __construct()
    {
    }
}
class CdPlayer
{
    public function __construct()
    {
    }
}
class DvdPlayer
{
    public function __construct()
    {
    }
}
class Tuner
{
    public function __construct()
    {
    }
}
class Amplifier
{
    public function __construct()
    {
    }
}