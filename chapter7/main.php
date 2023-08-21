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
echo "\n--------------\n";

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

    public function __construct(
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

    public function watchMovie(String $movie)
    {
        echo "映画を見る準備をします\n";
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

    public function endMovie()
    {
        echo "ムービーシアターを停止します\n";
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

    public function on()
    {
        echo "popをonする\n";
    }

    public function pop()
    {
        echo "popをpopする\n";
    }

    public function off()
    {
        echo "popをoffする\n";
    }
}
class Screes
{
    public function __construct()
    {
    }

    public function down()
    {
        echo "スクリーンをdownする\n";
    }

    public function up()
    {
        echo "スクリーンをupする\n";
    }
}
class TheaterLights
{
    public function __construct()
    {
    }

    public function dim(int $mode)
    {
        echo "ライトの明るさを{$mode}にします\n";
    }

    public function on()
    {
        "ライトをつけます";
    }
}
class Projector
{
    public function __construct()
    {
    }
    public function on()
    {
        echo "プロジェクターをonにします\n";
    }
    public function wideScreenMode()
    {
        echo "プロジェクターをwideScreenModeにします\n";
    }
    public function off()
    {
        echo "プロジェクターをoffにします\n";
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
    public function on()
    {
        echo "DVDをonにします\n";
    }
    public function play()
    {
        echo "DVDをplayにします\n";
    }
    public function stop()
    {
        echo "DVDをstopにします\n";
    }
    public function eject()
    {
        echo "DVDをejectにします\n";
    }
    public function off()
    {
        echo "DVDをoffにします\n";
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
    public function on()
    {
        echo "アンプをonにします\n";
    }
    public function setDvd()
    {
        echo "アンプをsetDvdにします\n";
    }
    public function setSurroundSound()
    {
        echo "アンプをsetSurroundSoundにします\n";
    }
    public function setVolume()
    {
        echo "アンプをsetVolumeにします\n";
    }
    public function off()
    {
        echo "アンプをoffにします\n";
    }
}

class HomeTheaterTestDrive
{
    public static function main()
    {
        $popcornPopper = new PopcornPopper();
        $screes = new Screes();
        $theaterLights = new TheaterLights();
        $projector = new Projector();
        $cdPlayer = new CdPlayer();
        $dvdPlayer = new DvdPlayer();
        $tuner = new Tuner();
        $amplifier = new Amplifier();

        $homeTheater = new HomeTheaterFacade(
            $amplifier,
            $tuner,
            $dvdPlayer,
            $cdPlayer,
            $projector,
            $theaterLights,
            $screes,
            $popcornPopper
        );
        $homeTheater->watchMovie("のび太のひみつ道具博物館");
        $homeTheater->endMovie();
    }
}

HomeTheaterTestDrive::main();
