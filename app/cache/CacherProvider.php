<?php

interface CacherProvider {

    public function set($k, $v, $expire = null); // if $expire not set, then never expires

    public function get($k);

    public function close();
}