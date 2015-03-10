<?php

class Cacher {

    private static $cacher;

    public static function setCacher($cacher) {
        Cacher::$cacher = $cacher;
    }

    public static function set($k, $v, $expire = null) {
        Cacher::$cacher->set($k, $v, $expire);
    }

    public static function get($k) {
        return Cacher::$cacher->get($k);
    }

    public static function close() {
        if (Cacher::$cacher !== null)
            Cacher::$cacher->close();
    }

}
