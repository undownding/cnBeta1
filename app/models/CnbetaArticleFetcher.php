<?php

use Sunra\PhpSimple\HtmlDomParser;
use Andrew13\Helpers\String;

class CnbetaArticleFetcher {

    private $id;
    public $html;
    public $article = array();

    public function __construct($id) {
        $this->id = $id;
        $this->loadArticle();
        $this->loadComment();
    }

    public function loadArticle() {
        $this->html = file_get_contents(cbURL($this->id));
        $dom = HtmlDomParser::str_get_html($this->html);
        $this->article['id'] = $this->id;
        $titleNode = $dom->find('h2#news_title', 0);
        if (!$titleNode)
            throw new ErrorException('文章找不到了...');
        $this->article['title'] = $titleNode->plaintext;
        $this->article['date'] = $dom->find('div.title_bar span.date', 0)->plaintext;
        $this->article['source'] = trim($dom->find('div.title_bar span.where', 0)->plaintext);
        $this->article['source'] = str_replace('稿源：', '', $this->article['source']);
        $sourceLinkNode = $dom->find('div.title_bar span.where a', 0);
        if ($sourceLinkNode)
            $this->article['sourceLink'] = $dom->find('div.title_bar span.where a', 0)->href;

        $this->article['intro'] = trim($dom->find('div.introduction', 0)->plaintext);
        $topicURL = $dom->find('div.introduction div a', 0)->href;
        preg_match('/topics\/(\d+)\.htm/', $topicURL, $matches);
        $this->article['topicId'] = (int) $matches[1];
        $this->article['topicTitle'] = $dom->find('div.introduction div a img', 0)->title;
        $this->article['topicImage'] = $dom->find('div.introduction div a img', 0)->src;
        $content = $dom->find('section.article_content div.content', 0)->innertext;
        $content = String::tidy($content);
        $this->article['content'] = str_replace(' class="f_center"', '', $content);
        $this->article['author'] = trim($dom->find('span.author', 0)->plaintext, "[] ");
    }

    public function loadComment() {
        try {
            $commentData = $this->getCommentsData(1);
            if (isset($commentData->comment_num))
                $this->article['comment_num'] = (int) $commentData->comment_num;
            if (isset($commentData->view_num))
                $this->article['view_num'] = (int) $commentData->view_num;
            $commentParser = new CnbetaCommentParser($commentData);
            $this->article['hotlist'] = $commentParser->getHotComments();
            //$this->article['list'] = $commentParser->getComments();
            //d($this->article);
        } catch (Exception $ex) {
            mlog('error loading comment for article: ' . $this->id . ', reason: '. $ex->getMessage());
            $this->article['hotlist'] = array();
        }
    }

/*    public $page;
    public function getComments($page) {
        $commentData = $this->getCommentsData($page);
        $commentParser = new CnbetaCommentParser($commentData);
        $comment['page'] = $this->page;
        $comment['list'] = $commentParser->getComments();
        return $comment;
    }*/

    public function getCommentsData($page) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.cnbeta.com/cmt');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'op=' . $this->getOp($page));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "X-Requested-With: XMLHttpRequest"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output);
        return $output->result;
    }

    public function getOp($page) {
        preg_match('/SN:"(.+)"/', $this->html, $matches);
        $sn = $matches[1];
        return urlencode($page . ',' . $this->id . ',' . $sn);
    }

}
