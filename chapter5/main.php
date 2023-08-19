<?php
class Singleton
{
    private static $uniqueInstance;
    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (empty(self::$uniqueInstance)) {
            // マルチスレッドの場合は初期化の際に同期処理が必要になる
            self::$uniqueInstance = new Singleton();
        }
        return self::$uniqueInstance;
    }
}
