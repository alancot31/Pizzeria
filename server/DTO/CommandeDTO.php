<?php
	
	class CommandeDTO implements JsonSerializable{
		private $idCommande; 
		private $SommeCommande; 
		private $idtablerestaurants;
		private $listarticle = array();
		private $date;

		public function __construct($SommeCommande,$idtablerestaurants,$listarticle,$date) {
			$this->SommeCommande = $SommeCommande;
			$this->idtablerestaurants = $idtablerestaurants;
			$this->listarticle =$listarticle;
			$this->date = $date;
		}
//id
		public function getIdCommande(){
			return $this->idCommande;
		}
		public function setidCommande($idCommande){
			$this->idCommande = $idCommande;
		}
//somme
		public function getSommeCommande(){
			return $this->SommeCommande;
		}
		public function setSommeCommande($SommeCommande){
			$this->SommeCommande = $SommeCommande;
		}
//date
		public function getDate(){
			return $this->date;
		}
		public function setDate($date){
			$this->date = $date;
		}
//idrestaurants
		public function getIdtablerestaurants(){
			return $this->idtablerestaurants;
		}
		public function setIdtablerestaurants($idtablerestaurants){
			$this->idtablerestaurants = $idtablerestaurants;
		}
//listarticle
		public function getListarticle(){
			return $this->listarticle;
		}
		public function setListarticle($listarticle){
			$this->listarticle = $listarticle;
		}
		public function jsonSerialize()
		{
			return array(
				'idcommande' => $this->idCommande,
				'sommecommande' => $this->SommeCommande,
				'idtablerestaurants' => $this->idtablerestaurants,
				'listarticle' => $this->listarticle,
				'date' => $this->date
			);
		}
	}