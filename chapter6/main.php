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

class Light{
    public function __construct()
    {
    }
    public function on(){
        echo "on";
    }

    public function off(){
        echo "off";
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