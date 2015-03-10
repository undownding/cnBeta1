<?php

class RedisCacher implements CacherProvider {

    private $redis;

    public function __construct() {
        $this->redis = Redis::connection();
    }

    public function set($k, $v, $expire = null) {
        if (is_array($v))
            $v = json_encode($v);
        $this->redis->set($k, $v);
        if($expire !== null) $this->redis->expire($k, $expire);
    }

    public function get($k) {
        $v = $this->redis->get($k);
        $array = json_decode($v, true);
        return (json_last_error() == JSON_ERROR_NONE) ? $array : $v;
    }

    public function close() {
        $this->redis->quit();
    }
}
