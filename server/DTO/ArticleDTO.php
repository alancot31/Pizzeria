<?php
	class ArticleDTO implements JsonSerializable
	{
        private $idArticle;
        private $prixArticle;
        private $nomArticle;
        private $CategorieArticle;

        public function __construct($nomArticle,$prixArticle,$CategorieArticle)
        {
            $this->prixArticle = $prixArticle;
            $this->nomArticle = $nomArticle;
            $this->CategorieArticle = $CategorieArticle;
        }

        public function getIdArticle()
        {
            return $this->idArticle;
        }
        public function setIdArticle($idArticle)
        {
            $this->idArticle = $idArticle;
        }
        public function getPrixArticle()
        {
            return $this->prixArticle;
        }

        public function setPrixArticle($prixArticle)
        {
            $this->prixArticle = $prixArticle;
        }

        public function getNomArticle()
        {
            return $this->nomArticle;
        }

        public function setNomArticle($nomArticle)
        {
            $this->nomArticle = $nomArticle;
        }

        public function getCategorieArticle()
        {
            return $this->CategorieArticle;
        }

        public function setCategorieArticle($CategorieArticle)
        {
            $this->CategorieArticle = $CategorieArticle;
        }

        public function jsonSerialize()
        {
            return array(
                'idarticle' => $this->idArticle,
                'prixarticle' => $this->prixArticle,
                'nomarticle' => $this->nomArticle,
                'categoriearticle' => $this->CategorieArticle,
            );
        }
	}
