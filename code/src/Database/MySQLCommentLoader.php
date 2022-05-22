<?php

namespace Returnnull;

class MySQLCommentLoader
{
    public function __construct(
        private MySQLConnector $mySQLConnector
    ){}

    public function get($articleID)
    {
        if ($articleID == LAST_ARTICLE_ID){
            $articleID = $this->getLastArticleID();
        }
        return $this->fetchComment($articleID);
    }

    private function fetchComment($articleID){
        $sql = $this->mySQLConnector->prepare('SELECT *
                                                     FROM Comments
                                                     WHERE articleID = :articleID;');
        $sql->bindValue(':articleID', $articleID);
        $sql->execute();
        return $sql->fetchAll();
    }

    private function getLastArticleID(){
        $sql = $this->mySQLConnector->prepare('select MAX(id) from Articles');
        $sql->execute();
        return $sql->fetchAll()[0][0];
    }
}