<?php

class AppartientDTO implements JsonSerializable
{
private $idArticle;
private $idCommande;
private $quantiter;

    public function __construct($idArticle,$idCommande, $quantiter)
    {
        $this->idArticle = $idArticle;
        $this->idCommande =$idCommande;
        $this->quantiter = $quantiter;
        
    }


    public function getIdArticle()
    {
        return $this->idArticle;
    }

    public function setIdArticle($idArticle)
    {
        $this->idArticle = $idArticle;
    }

    public function getIdCommande()
    {
        return $this->idCommande;
    }

    public function setIdCommande($idCommande)
    {
        $this->idCommande = $idCommande;
    }

    public function getQuantiter()
    {
        return $this->quantiter;
    }

    public function setQuantiter($quantiter)
    {
        $this->quantiter = $quantiter;
    }

    public function jsonSerialize()
    {
        return array(
            'idarticle' => $this->idArticle,
            'idcommande' => $this->idCommande,
            'quantiter' => $this->quantiter,
        );
    }
}