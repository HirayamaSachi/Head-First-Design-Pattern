<?php
interface Command
{
    public function execute();
    public function undo();
}

class LightOnCommand implements Command
{
    // コマンド
    public $light;
    public function __construct($light)
    {
        $this->light = $light;
    }
    public function execute()
    {
        // レシーバー
        $this->light->on();
    }
    public function undo()
    {
        $this->light->off();
    }
}

class LightOffCommand implements Command
{
    // コマンド
    public $light;
    public function __construct($light)
    {
        $this->light = $light;
    }
    public function execute()
    {
        // レシーバー
        $this->light->off();
    }
    public function undo()
    {
        $this->light->on();
    }
}

class StereoOnWithCDCommand implements Command
{
    public $stereo;
    public function __construct($stereo)
    {
        $this->stereo = $stereo;
    }
    public function execute()
    {
        $this->stereo->on();
        $this->stereo->setCD();
        $this->stereo->setVolume(11);
    }
    public function undo()
    {
        $this->stereo->off();
    }
}

class StereoOffWithCDCommand implements Command
{
    public $stereo;
    public function __construct($stereo)
    {
        $this->stereo = $stereo;
    }
    public function execute()
    {
        $this->stereo->off();
    }

    public function undo()
    {
        $this->stereo->on();
        $this->stereo->setCD();
        $this->stereo->setVolume(11);
    }
}

class Light
{
    public function __construct()
    {
    }
    public function on()
    {
        echo "ライトon\n";
    }

    public function off()
    {
        echo "ライトoff\n";
    }
}

class Stereo
{
    public int $volume = 1;
    public function __construct()
    {
    }

    public function on()
    {
        echo "ステレオon\n";
    }

    public function off()
    {
        echo "ステレオoff\n";
    }

    public function setCD()
    {
        echo "CDセットします\n";
    }

    public function setVolume(int $volume)
    {
        $this->volume = $volume;
        echo $this->volume . "に設定しました\n";
    }
}

class SimpleRemoteControl
{
    public $Slot;
    public function __construct()
    {
    }
    public function setCommand($Command)
    {
        $this->Slot = $Command;
    }
    public function buttonWasPressed()
    {
        // インボーカ
        $this->Slot->execute();
    }
}

class RemoteControlTest
{
    public static function main()
    {
        $remote = new SimpleRemoteControl();
        $light = new Light();
        $command = new LightOnCommand($light);
        $remote->setCommand($command);
        $remote->buttonWasPressed();
    }
}
RemoteControlTest::main();

// 何もしないコマンド
class NoCommand implements Command
{
    public function __construct()
    {
    }
    public function execute()
    {
    }
    public function undo()
    {
    }
}

class RemoteControl
{
    public array $onCommands;
    public array $offCommands;
    public Command $undoCommand;

    public function __construct()
    {
        $noCommand = new NoCommand();
        for ($i = 0; $i < 7; $i++) {
            // 何もしないコマンドを初期設定
            $this->onCommands[$i] = $noCommand;
            $this->offCommands[$i] = $noCommand;
        }
        $this->undoCommand = $noCommand;
    }

    public function setCommand(int $slot, $onCommand, $offCommand)
    {
        $this->onCommands[$slot] = $onCommand;
        $this->offCommands[$slot] = $offCommand;
    }

    public function onButtonWasPushed(int $slot)
    {
        $this->onCommands[$slot]->execute();
        $this->undoCommand = $this->onCommands[$slot];
    }

    public function offButtonWasPushed(int $slot)
    {
        $this->offCommands[$slot]->execute();
        $this->undoCommand = $this->offCommands[$slot];
    }

    public function undoButtonWasPushed()
    {
        $this->undoCommand->undo();
    }
}

class RemoteLoader
{
    public static function main(array $args)
    {
        $remoteControl = new RemoteControl();
        $light = new Light();
        $lightOnCommand = new LightOnCommand($light);
        $lightOffCommand = new LightOffCommand($light);
        $remoteControl->setCommand(1, $lightOnCommand, $lightOffCommand);

        $stereo = new Stereo();
        $stereoOnWithCDCommand = new StereoOnWithCDCommand($stereo);
        $stereoOffWithCDCommand = new StereoOffWithCDCommand($stereo);
        $remoteControl->setCommand(2, $stereoOnWithCDCommand, $stereoOffWithCDCommand);

        $ceilingFan = new CeilingFan("リビング");
        $ceilingFanHighCommand = new CeilingFanHighCommand($ceilingFan);
        $ceilingFanOffCommand = new CeilingFanOffCommand($ceilingFan);
        $remoteControl->setCommand(3, $ceilingFanHighCommand, $ceilingFanOffCommand);

        $partyOn = [$lightOnCommand, $stereoOnWithCDCommand, $ceilingFanHighCommand];
        $partyOff = [$lightOffCommand, $stereoOffWithCDCommand, $ceilingFanOffCommand];

        $partyOnMacro = new MacroCommand($partyOn);
        $partyOffMacro = new MacroCommand($partyOff);
        $remoteControl->setCommand(4, $partyOnMacro, $partyOffMacro);

        $remoteControl->onButtonWasPushed(4);
    }
}


class CeilingFan
{
    public static $HIGH = 3;
    public static $MEDIUM = 2;
    public static $LOW = 1;
    public static $OFF = 0;

    public string $location;
    public int $speed;

    public function __construct(String $location)
    {
        $this->location = $location;
        $this->speed = self::$OFF;
    }

    public function high()
    {
        $this->speed = self::$HIGH;
        echo $this->speed;
    }

    public function medium()
    {
        $this->speed = self::$MEDIUM;
        echo $this->speed;
    }

    public function low()
    {
        $this->speed = self::$LOW;
        echo $this->speed;
    }

    public function off()
    {
        $this->speed = self::$OFF;
        echo $this->speed;
    }

    public function getSpeed()
    {
        return $this->speed;
    }
}

class CeilingFanHighCommand implements Command
{
    public CeilingFan $ceilingFan;
    public int $prevSpeed;
    public function __construct(CeilingFan $ceilingFan)
    {
        $this->ceilingFan = $ceilingFan;
    }
    public function execute()
    {
        $this->prevSpeed = $this->ceilingFan->getSpeed();
        $this->ceilingFan->high();
    }

    public function undo()
    {
        $prevSpeed = $this->prevSpeed;
        $ceilingFan = $this->ceilingFan;
        if ($prevSpeed == $ceilingFan::$HIGH) {
            $ceilingFan->high();
        } elseif ($prevSpeed == $ceilingFan::$MEDIUM) {
            $ceilingFan->medium();
        } elseif ($prevSpeed == $ceilingFan::$LOW) {
            $ceilingFan->low();
        } elseif ($prevSpeed == $ceilingFan::$OFF) {
            $ceilingFan->off();
        }
    }
}

class CeilingFanOffCommand implements Command
{
    public CeilingFan $ceilingFan;
    // undoに状態を保存する
    public int $prevSpeed;
    public function __construct(CeilingFan $ceilingFan)
    {
        $this->ceilingFan = $ceilingFan;
    }
    public function execute()
    {
        // 以前の状態を保存する
        $this->prevSpeed = $this->ceilingFan->getSpeed();
        $this->ceilingFan->off();
    }

    public function undo()
    {
        $prevSpeed = $this->prevSpeed;
        $ceilingFan = $this->ceilingFan;
        // undoの状態をもとにspeedを決める
        if ($prevSpeed == $ceilingFan->HIGH) {
            $ceilingFan->high();
        } elseif ($prevSpeed == $ceilingFan->MEDIUM) {
            $ceilingFan->medium();
        } elseif ($prevSpeed == $ceilingFan->LOW) {
            $ceilingFan->low();
        } elseif ($prevSpeed == $ceilingFan->OFF) {
            $ceilingFan->off();
        }
    }
}

class MacroCommand implements Command
{
    public array $commands;
    public function __construct(array $commands)
    {
        $this->commands = $commands;
    }
    public function execute()
    {
        foreach ($this->commands as $command) {
            $command->execute();
        }
    }

    public function undo()
    {
    }
}

RemoteLoader::main([]);