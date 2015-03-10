<?php

class MemcacheCacher implements CacherProvider {

    private $mem;

    public function __construct() {
        $this->mem = new Memcache;
        $this->mem->connect("127.0.0.1", 11211);
    }

    public function set($k, $v, $expire) {
        if ($expire ===  null) {
            $this->mem->set($k, $v);
        }
        $this->mem->set($k, $v, 0, $expire);
    }

    public function get($k) {
        return $this->mem->get($k);
    }

    public function close() {
        $this->mem->close();
    }   
}
