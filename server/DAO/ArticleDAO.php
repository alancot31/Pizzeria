<?php

	include_once('DTO/ArticleDTO.php');

	class ArticleDAO
	{

	    public static  function insertArticle($article){
            $connex = DatabaseLinker::getConnexion();
            $state = $connex->prepare('INSERT INTO article(nomarticle, prixarticle, categoriearticle) VALUES(:nomarticle, :prixarticle, :categoriearticle)');
            $state->bindValue(":nomarticle", $article->getNomArticle());
            $state->bindValue(":prixarticle", $article->getPrixArticle());
            $state->bindValue(":categoriearticle", $article->getCategorieArticle());
            $state->execute();
            $article->setIdArticle($connex->lastInsertId());
        }


        public  static function getArticleById($id){
            $Article = null;

            $connex = DatabaseLinker::getConnexion();

            $state = $connex->prepare('SELECT * FROM article WHERE idarticle = :idarticle');
            $state->bindValue(":idarticle", $id);
            $state->execute();
            $resultats = $state->fetchAll();

            if (sizeof($resultats) > 0)
            {
                $result = $resultats[0];
                $Article = new ArticleDTO($result["nomarticle"], $result["prixarticle"], $result["categoriearticle"]);
                $Article->setIdArticle($result["idarticle"]);
            }
            return $Article;
        }

        public static  function  getAllArticle()
        {
            $Articles = array();
            $connex = DatabaseLinker::getConnexion();

            $state = $connex->prepare('SELECT * FROM article ');
            $state->execute();
            $resultats = $state->fetchAll();

            foreach ($resultats as $result)
            {
                $Article = new ArticleDTO($result["nomarticle"], $result["prixarticle"], $result["categoriearticle"]);
                $Article->setIdArticle($result["idarticle"]);

                $Articles[] = $Article;
            }
            return $Articles;
        }

        public static function updateArticle($article){
            $connex = DatabaseLinker::getConnexion();
            $state = $connex->prepare('UPDATE article SET nomarticle=:nomarticle, prixarticle=:prixarticle, categoriearticle=:categoriearticle WHERE idarticle = :idarticle');
            $state->bindValue(":nomarticle", $article->getNomArticle());
            $state->bindValue(":prixarticle", $article->getPrixArticle());
            $state->bindValue(":categoriearticle", $article->getCategorieArticle());
            $state->bindValue(":idarticle", $article->getIdArticle());
            $state->execute();

        }

        public static function deleteArticle($id)
        {
            $connex = DatabaseLinker::getConnexion();
            $state = $connex->prepare('DELETE FROM article WHERE idarticle = :idarticle');
            $state->bindValue(":idarticle", $id);
            $state->execute();
        }
    }