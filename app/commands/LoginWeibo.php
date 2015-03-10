<?php

use Illuminate\Console\Command;

class LoginWeibo extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'weibo:login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Login Weibo and save cookie.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        (new Weibo())->login();
    }

}
