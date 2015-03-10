<?php

class CnbetaCommentParser {
    
    public $commentDict;
    public $hotList;
    public $commentList;
    public $commentStore;
    
    public function __construct($commentData) {
        $this->commentDict = $commentData->cmntdict;
        $this->hotList = $commentData->hotlist;
        $this->commentList = $commentData->cmntlist;
        if (isset($commentData->cmntstore)) $this->commentStore = $commentData->cmntstore;
    }
    
    public function getHotComments() {
        if (!$this->hotList) return false;
        $comments = array();
        foreach ($this->hotList as $hotComment) {
            $commentId = $hotComment->tid;
            $comment['author'] = $this->commentStore->$commentId->name;
            $comment['from'] = $this->commentStore->$commentId->host_name;
            $comment['date'] = $this->commentStore->$commentId->date;
            $comment['content'] = $this->commentStore->$commentId->comment;
            $comment['up'] = (int) $this->commentStore->$commentId->score;
            $comment['down'] = (int) $this->commentStore->$commentId->reason;
            $comments[] = $comment;
        }
        return $comments;
    }
    
    public function getComments() {
        $comments = array();
        foreach ($this->commentList as $commentItem) {
            $commentId = $commentItem->tid;
            $comment['id'] = $commentId;
            $comment['author'] = $this->commentStore->$commentId->name;
            $comment['from'] = $this->commentStore->$commentId->host_name;
            $comment['date'] = $this->commentStore->$commentId->date;
            $comment['content'] = $this->commentStore->$commentId->comment;
            $comment['up'] = $this->commentStore->$commentId->score;
            $comment['down'] = $this->commentStore->$commentId->reason;
            $comment['parent'] = $this->commentStore->$commentId->pid;
            $comments[] = $comment;
        }
        return $comments;
    }
    
}