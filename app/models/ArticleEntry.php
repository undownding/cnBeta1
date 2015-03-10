<?php

class ArticleEntry extends Eloquent {
    
    protected $table = 'articles';
    protected $fillable = array('article_id', 'title', 'date', 'intro', 'topic', 'view_num', 'comment_num', 'source', 'source_link');
    public $timestamps = false;

    public function toTimeline() {
        $article = new Article($this->article_id);
        $article->load();
        $hot_comment = (isset($article->data['hotlist']) && !empty($article->data['hotlist'])) ? ' ——“' . $article->data['hotlist'][0]['content'] . '”': '';
        return '【' . $this->title . '】' . $hot_comment . ' http://cnbeta1.com/' . $this->article_id;
    }
    
}
