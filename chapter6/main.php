<?php
interface Command{
    public function execute();
}

class LightOnCommand implements Command{
    // コマンド
    public $light;
    public function __construct($light)
    {
        $this->light = $light;
    }
    public function execute(){
        // レシーバー
        $this->light->on();
    }
}

class LightOffCommand implements Command{
    // コマンド
    public $light;
    public function __construct($light)
    {
        $this->light = $light;
    }
    public function execute(){
        // レシーバー
        $this->light->off();
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
}

class Light{
    public function __construct()
    {
    }
    public function on(){
        echo "ライトon\n";
    }

    public function off(){
        echo "ライトoff\n";
    }
}

class Stereo{
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

class SimpleRemoteControl{
    public $Slot;
    public function __construct()
    {
    }
    public function setCommand($Command){
        $this->Slot = $Command;
    }
    public function buttonWasPressed(){
        // インボーカ
        $this->Slot->execute();
    }
}

class RemoteControlTest{
    public static function main(){
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
}

class RemoteControl
{
    public array $onCommands;
    public array $offCommands;

    public function __construct()
    {
        $noCommand = new NoCommand();
        for ($i = 0; $i < 7; $i++) {
            // 何もしないコマンドを初期設定
            $this->onCommands[$i] = $noCommand;
            $this->offCommands[$i] = $noCommand;
        }
    }

    public function setCommand(int $slot, $onCommand, $offCommand)
    {
        $this->onCommands[$slot] = $onCommand;
        $this->offCommands[$slot] = $offCommand;
    }

    public function onButtonWasPushed(int $slot){
        $this->onCommands[$slot]->execute();
    }

    public function offButtonWasPushed(int $slot){
        $this->offCommands[$slot]->execute();
    }
}

class RemoteLoader{
    public static function main(array $args){
        $remoteControl = new RemoteControl();
        $light = new Light();
        $lightOnCommand = new LightOnCommand($light);
        $lightOffCommand = new LightOffCommand($light);
        $remoteControl->setCommand(1, $lightOnCommand, $lightOffCommand);

        $stereo = new Stereo();
        $stereoOnWithCDCommand = new StereoOnWithCDCommand($stereo);
        $stereoOffWithCDCommand = new StereoOffWithCDCommand($stereo);
        $remoteControl->setCommand(2, $stereoOnWithCDCommand, $stereoOffWithCDCommand);

        $remoteControl->onButtonWasPushed(1);
        $remoteControl->onButtonWasPushed(2);
        $remoteControl->onButtonWasPushed(3);

        $remoteControl->offButtonWasPushed(1);
        $remoteControl->offButtonWasPushed(2);
    }
}

RemoteLoader::main([]);