<?php

class ArticleFeed {

    public $data;

    public function load() {
        $this->loadFromCache();
        if (!$this->data) {
            $this->generateFeed();
        }
    }

    public function generateFeed() {
        $articles = $this->getArticles();

        $feed = Feed::make();

        // set your feed's title, description, link, pubdate and language
        $feed->title = 'cnBeta1';
        $feed->description = '一个干净、现代、开放的cnBeta';
        $feed->logo = 'http://cnbeta1.com/assets/img/cnbeta1.png';
        $feed->link = URL::to('feed');
        $feed->pubdate = $articles[0]['date'];
        $feed->lang = 'zh-cn';

        foreach ($articles as $article) {
            $articleModel = new Article($article['article_id']);
            try {
                $articleModel->load();
            } catch (Exception $ex) {
                Log::error('feed: fail to fetch article: ' . $article['article_id'] . ', error: '. $ex->getMessage());
            }
            $content = $article['intro'];
            $content .= ($articleModel->data['content']) ? $articleModel->data['content'] : '';
            // set item's title, author, url, pubdate, description and content
            $feed->add($article['title'], 'cnBeta1', URL::to($article['article_id']), $article['date'], $content, $content);
        }
        $this->data = $feed->render('atom', -1);
        $this->saveToCache();
    }

    private function getArticles() {
        $articleList = new ArticleList();
        $articleList->load();
        return $articleList->data;
    }

    private function loadFromCache() {
        $this->data = Cacher::get(FEED_CACHE_KEY);
    }

    private function saveToCache() {
        Cacher::set(FEED_CACHE_KEY, $this->data, FEED_EXPIRE_TIME);
    }

}
