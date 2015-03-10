<?php

class Article {

    private $id;
    private $cacheKey;
    private $upToDateKey;
    public $data;

    public function __construct($id) {
        $this->id = $id;
        $this->cacheKey = ARTICLE_CACHE_KEY_PREFIX . $id;
        $this->upToDateKey = UPTODATE_KEY_PREFIX . $id;
    }

    public function load() {
        $this->loadFromCache();
        if (!$this->data) {
            $this->fetch();
        }
    }

    public function sync() {
        $this->loadFromCache();
        if (!$this->data) {
            $this->fetch();
        } else if($this->needRefresh()) {
            $this->updateFromServer();
        }
    }

    public function fetch() {
        $this->fetchFromServer();
        $this->saveToCache();
    }

    private function fetchFromServer() {
        try {
            $fetcher = new CnbetaArticleFetcher($this->id);
            $this->data = $fetcher->article;
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            if ($message === 'Trying to get property of non-object')
                throw new Exception('解析文章错误...');
            if (strpos($message, 'file_get_contents', 0) !== false)
                throw new Exception('获取文章出错...');
            throw $ex;
        }
    }

    private function updateFromServer() {
        try {
            $fetcher = new CnbetaArticleFetcher($this->id);
            $newArticle = $fetcher->article;
            Log::info('updating data for article: ' . $this->id);
            if ($newArticle['hotlist']) {
                $this->data = $newArticle;
            } else if (isset($newArticle['view_num']) && isset($newArticle['comment_num'])) {
                $this->data['view_num'] = $newArticle['view_num'];
                $this->data['comment_num'] = $newArticle['comment_num'];
            } else {
                throw new Exception('nothing to save');
            }
            $this->saveToCache();
            $article_entry = ArticleEntry::where('article_id', $this->id)->first();
            $article_entry->view_num = $newArticle['view_num'];
            $article_entry->comment_num = $newArticle['comment_num'];
            $article_entry->save();
            Log::info('updated article: ' . $this->id);
            $this->markUpToDate();
        } catch (Exception $ex) {
            Log::warning('fetching article failed: ' . $ex->getMessage());
        }
    }

    private function loadFromCache() {
        $this->data = Cacher::get($this->cacheKey);
    }

    private function saveToCache() {
        Cacher::set($this->cacheKey, $this->data, ARTICLE_CACHE_TIME);
        $this->markUpToDate();
    }

    private function markUpToDate() {
        if ($this->isRecentArticle())
            Cacher::set($this->upToDateKey, '1', ARTICLE_REFRESH_TIME);
    }

    public function needRefresh() {
        return ($this->isRecentArticle() && !Cacher::get($this->upToDateKey));
    }

    public function isRecentArticle() {
        $date = new Carbon($this->data['date']);
        $date->addDays(ARTICLE_RECENT_DAY);
        return $date->gt(Carbon::now());
    }

}
