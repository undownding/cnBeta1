<?php

use Illuminate\Console\Command;

class WeiboTest extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'weibo:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weibo posting test.';

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
        # (new Weibo())->postWeibo('Weibo Test');
        postWeiboBySAE('Weibo Test');
    }

}
