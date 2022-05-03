<?php
include_once('DTO/AppartientDTO.php');
class AppartientDAO
{
    public static  function  getAllAppartient()
    {
        $Articles = array();
        $connex = DatabaseLinker::getConnexion();

        $state = $connex->prepare('SELECT * FROM appartient ');
        $state->execute();
        $resultats = $state->fetchAll();

        foreach ($resultats as $result)
        {
            $Article = new AppartientDTO($result["idarticle"],$result["idcommande"],$result["quantiter"]);
            $Article->setIdCommande($result["idcommande"]);

            $Articles[] = $Article;
        }
        return $Articles;
    }

    public  static function getAppartientById($id)
    {
        $Article = null;

        $connex = DatabaseLinker::getConnexion();

        $state = $connex->prepare('SELECT * FROM appartient WHERE idcommande = :idcommande by');
        $state->bindValue(":idcommande", $id);
        $state->execute();
        $resultats = $state->fetchAll();

        foreach ($resultats as $result)
        {
            $Article = new AppartientDTO($result["idarticle"],$result["idcommande"],$result["quantiter"]);
            

            $Articles[] = $Article;
        }
        return $Articles;
    }
    public static function deleteAppartient($idcommande)
    {
        $connex = DatabaseLinker::getConnexion();
        $state = $connex->prepare('DELETE FROM appartient WHERE idcommande = :idcommande');
        $state->bindValue(":idcommande", $idcommande);
        $state->execute();
    }

    public static function updateAppartient($article)
    {
        $connex = DatabaseLinker::getConnexion();
        $state = $connex->prepare('UPDATE appartient SET quantiter=:quantiter,idarticle =:idarticle WHERE idcommande = :idcommande');
        $state->bindValue(":quantiter", $article->getQuantiter());
        $state->bindValue(":idarticle", $article->getIdArticle());
        $state->bindValue(":idcommande", $article->getIdCommande());
        $state->execute();

    }

    public static  function insertAppartient($article){
        $connex = DatabaseLinker::getConnexion();
        $state = $connex->prepare('INSERT INTO appartient(idarticle, quantiter) VALUES(:idarticle, :quantiter)');
        $state->bindValue(":idarticle", $article->getIdArticle());
        $state->bindValue(":quantiter", $article->getQuantiter());
        $state->execute();
        $article->setIdCommande($article->getIdCommande());
    }
}