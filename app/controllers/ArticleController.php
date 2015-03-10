<?php

class ArticleController extends BaseController {

    public function getIndex() {
        Debugbar::startMeasure('load data','载入文章数据');
        $articleList = new ArticleList();
        $articleList->load();
        Debugbar::stopMeasure('load data');
        Debugbar::startMeasure('render index','渲染');
        $view = View::make('site/article/index', array('articleList' => $articleList->data));
        Debugbar::stopMeasure('render index');
        return $view;
    }

    public function showArticle($id) {
        Debugbar::startMeasure('load data','载入文章数据');
        $article = new Article($id);
        try {
            $article->load();
        } catch (Exception $ex) {
            return View::make('error/custom', array('error' => $ex->getMessage()));
        }
        Debugbar::stopMeasure('load data');
        Debugbar::startMeasure('render article','渲染');
        $view = View::make('site/article/view', array('article' => $article->data, 'needRefresh' => $article->needRefresh()));
        Debugbar::stopMeasure('render article');
        return $view;
    }

}
