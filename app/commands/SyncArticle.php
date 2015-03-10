<?php

use Illuminate\Console\Command;

class SyncArticle extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'article:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync articles from cnBeta.';

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
        try {
            $list = new ArticleList();
            $list->syncFromServerToDB();
            $feed = new ArticleFeed();
            $feed->generateFeed();
        } catch (Exception $ex) {
            Log::error('unable to sync articles: ' . $ex->getMessage());
            throw $ex;
        }
    }

}
