<?php
	
	class TableRestaurantDTO implements JsonSerializable{
		private $idtablerestaurant;
		private $nomtablerestaurant;
		private $nbpersonne;
		private $isoccuper;


		public function __construct($nomtablerestaurant,$nbpersonne,$isoccuper) {
			$this->nomtablerestaurant = $nomtablerestaurant;
			$this->nbpersonne = $nbpersonne;
			$this->isoccuper = $isoccuper;
		}
		//IdTableRestaurant
		public function getIdTableRestaurant(){
			return $this->idtablerestaurant;
		}
		public function setidtablerestaurant($idtablerestaurant){
			$this->idtablerestaurant = $idtablerestaurant;
		}
		//nomtablerestaurant
		public function getnomtablerestaurant(){
			return $this->nomtablerestaurant;
		}
		public function setnomtablerestaurant($nomtablerestaurant){
			$this->nomtablerestaurant = $nomtablerestaurant;
		}
		//nbpersonne
		public function getnbpersonne(){
			return $this->nbpersonne;
		}
		public function setnbpersonne($nbpersonne){
			$this->nbpersonne = $nbpersonne;
		}
		//isoccuper
		public function getIsoccuper(){
			return $this->isoccuper;
		}
		public function setIsoccuper($isoccuper){
			$this->isoccuper = $isoccuper;
		}

		public function jsonSerialize()
		{
			return array(
				'idtablerestaurant' => $this->idtablerestaurant,
				'nomtablerestaurant' => $this->nomtablerestaurant,
				'nbpersonne' => $this->nbpersonne,
				'isoccuper'=>$this->isoccuper
			);
		}
	}