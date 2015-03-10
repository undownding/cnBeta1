<?php

class ArticleList {

    public function syncFromServerToDB() {

        $newList = $this->newArticleList();

        if (!$newList) {
            mlog("Articles already up to date.");
            return;
        }

        # mark latest
        Cacher::set(LATEST_ARTICLE_ID_KEY, end($newList)['id']);

        # insert article entries
        foreach ($newList as $article) {
            $articleEntry = new ArticleEntry($article);
            $articleEntry->article_id = $article['id'];
            $articleEntry->topic = replaceImgURL($article['topicImage']);
            if (isset($article['sourceLink']))
                $articleEntry->source_link = $article['sourceLink'];
            $articleEntry->save();
        }

        $this->syncFromDBToCache();
    }

    private function newArticleList() {
        $latest = Cacher::get(LATEST_ARTICLE_ID_KEY);
        if (!$latest) {
            $article = ArticleEntry::orderBy('article_id', 'DESC')->first();
            if ($article) {
                $latest = $article->article_id;
                Cacher::set(LATEST_ARTICLE_ID_KEY, $latest);
            }
        }

        $newList = array();
        $check = $latest;
        $fail = 0;
        
        while (true) {
            $check += 2;
            $article = new Article($check);
            try {
                $article->fetch();
                
                $newList[] = $article->data;
                mlog('Found: ' . $article->data['id'] . ' ' . $article->data['title'] . ' ' . $article->data['date']);
            } catch (Exception $ex) {
                $fail++;
                mlog('NotFound: ' . $check . ' Exception: ' . $ex->getMessage());
                if ($fail >= 3) break;
            }
        }

        mlog('Found ' . count($newList) . ' new article(s)');
        return $newList;
    }

    public $data;

    public function load() {
        $this->loadFromCache();
        if (!$this->data) {
            $this->syncFromDBToCache();
        }
    }

    private function syncFromDBToCache() {
        $this->data = ArticleEntry::orderBy('article_id', 'DESC')->take(INDEX_ARTICLE_NUM)->get()->toArray();
        $this->saveToCache();
    }

    public function getMoreData($fromArticleId) {
        return DB::table('articles')->where('article_id', '<', $fromArticleId)->orderBy('article_id', 'DESC')->take(INDEX_ARTICLE_NUM)->get();
    }

    private function loadFromCache() {
        $this->data = Cacher::get(INDEX_CACHE_KEY);
    }

    private function saveToCache() {
        Cacher::set(INDEX_CACHE_KEY, $this->data, INDEX_EXPIRE_TIME);
    }

}
