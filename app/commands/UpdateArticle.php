<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class UpdateArticle extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'article:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update articles in time range and discover hot articles from cnBeta.';

    /**
     * Create a new command instance.
     *
     */
    public function __construct() {
        parent::__construct();
    }


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('type', InputArgument::REQUIRED, 'Updating article type[1-3].'),
        );
    }

    /**
     * Execute the console command.
     *
     */
    public function fire() {
        # update articles
        # discover hot articles
        try {
            $hot_profile = [
                '1' => [
                    'min_age' => 0,
                    'max_age' => 1, // in hour
                    'min_view_num' => 2000,
                    'min_hotlist_top_up_num' => 40
                ],
                '2' => [
                    'min_age' => 1,
                    'max_age' => 2,
                    'min_view_num' => 3000,
                    'min_hotlist_top_up_num' => 60
                ],
                '3' => [
                    'min_age' => 2,
                    'max_age' => 5,
                    'min_view_num' => 5000,
                    'min_hotlist_top_up_num' => 100
                ],
                '4' => [
                    'min_age' => 5,
                    'max_age' => 10,
                    'min_view_num' => 9000,
                    'min_hotlist_top_up_num' => 200
                ],
            ];
            $profile = $hot_profile[$this->argument('type')];
            $articles_to_update = ArticleEntry::whereRaw('hot = FALSE AND date <= now() - INTERVAL ? HOUR AND date >= now() - INTERVAL ? HOUR', array($profile['min_age'], $profile['max_age']))->get();
            foreach($articles_to_update as $article_to_update) {
                $article = new Article($article_to_update->article_id);
                $article->sync();
                if ($article->data['view_num'] > $profile['min_view_num'] or (isset($article->data['hotlist']) && $article->data['hotlist'][0]['up'] > $profile['min_hotlist_top_up_num'])) {
                    $article_to_update->hot = true;
                    $article_to_update->save();
                    $hotlist_top = isset($article->data['hotlist']) ? ' HotlistTopUps: ' . $article->data['hotlist'][0]['up'] : '';
                    mlog('found hot article: ' . $article->data['id'] . ' ' . $article->data['title'] . ' ' . $article->data['date'] . ' Views: ' . $article->data['view_num'] . $hotlist_top);
                }
            }
        } catch (Exception $ex) {
            Log::error('unable to update articles: ' . $ex->getMessage());
            throw $ex;
        }

        # push articles
        $article_to_push = ArticleEntry::whereRaw('hot = TRUE AND pushed = FALSE')->orderBy('date', 'desc')->first();
        if ($article_to_push) {
            $article_to_push->pushed = true;
            $article_to_push->save();
            mlog('pushing article id: ' . $article_to_push->article_id . ' content: ' . $article_to_push->toTimeline());
            try {
                Twitter::postTweet(array('status' => $article_to_push->toTimeline(), 'format' => 'json'));
            } catch (Exception $ex) {
                Log::error('unable to push article to twitter: ' . $ex->getMessage());
            }
/*            try {
                # (new Weibo())->postWeibo($article_to_push->toTimeline());
                $ret = postWeiboBySAE($article_to_push->toTimeline());
                if ($ret != '发送成功') throw new Exception($ret);
            } catch (Exception $ex) {
                Log::error('unable to push article to weibo: ' . $ex->getMessage());
            }*/
        }
    }

}
