<?php

class APIController extends BaseController {

    public function __construct() {
        parent::__construct();

        \Debugbar::disable();
    }

    public function getArticles() {
        if (Input::has('firstArticleID')) {
            $latest = Cacher::get(LATEST_ARTICLE_ID_KEY);
            if (Input::get('firstArticleID') >= $latest) {
                return $this->jsonResponse(array());
            }
        }
        $articleList = new ArticleList();
        $articleList->load();
        return $this->jsonResponse($articleList->data);
    }

    public function getMoreArticles($fromArticleId) {
        $articleList = new ArticleList();
        return $this->jsonResponse($articleList->getMoreData($fromArticleId));
    }

    public function getFeed() {
        $feed = new ArticleFeed();
        $feed->load();
        return $feed->data;
    }

    public function sync() {
        #$list = new ArticleList();
        #$list->syncFromServerToDB();
        #$feed = new ArticleFeed();
        #$feed->generateFeed();
    }

    public function getArticleDetail($id) {
        $article = new Article($id);
        $article->load();
        return $this->jsonResponse($article->data);
    }

    public function syncArticleDetail($id) {
        $article = new Article($id);
        $article->sync();
        return $this->jsonResponse($article->data);
    }

    private function jsonResponse($data) {
        $json = json_encode($data);
        $response = Response::make($json, 200);
        $response->header('Content-Type', 'application/json');
        return $response;
    }

}
