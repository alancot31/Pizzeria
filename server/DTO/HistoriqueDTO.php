<?php

	class HistoriqueDTO implements JsonSerializable{
		private $idHistorique;
		private $date;
		private $elementCommande;
		private $prix;
		private $idCommande;
	
		public function __construct($date,$elementCommande,$prix,$idCommande){	
			$this->date = $date;
			$this->elementCommande = $elementCommande;
			$this->prix = $prix;
			$this->idCommande = $idCommande;
		}
//id
		public function getIdHistorique(){
			return $this->idHistorique;
		}
		public function setIdHistorique($idHistorique){
			$this->idHistorique = $idHistorique;
		}
//date
		public function getdate(){
			return $this->date;
		}
		public function setdate($date){
			$this->date = $date;
		}
//emlement
		public function getElementCommande(){
			return $this->elementCommande;
		}
		public function setElementCommande($elementCommande){
			$this->elementCommande = $elementCommande;
		}
//prix
		public function getPrix(){
			return $this->prix;
		}

		public function setPrix($prix){
			$this->prix = $prix;
		}
//idcommande
		public function getIdCommande(){
			return $this->idCommande;
		}
		public function setIdCommande($idCommande){
			$this->idCommande = $idCommande;
		}

		public function jsonSerialize()
		{
			return array(
				'idhistorique' => $this->idHistorique,
				'date' => $this->date,
				'elementcommande' => $this->elementCommande,				
				'prix' => $this->prix,
				'idcommande' => $this->idCommande
			);
		}
	}
