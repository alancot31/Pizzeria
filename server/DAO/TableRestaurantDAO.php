<?php

	include_once('DTO/TableRestaurantDTO.php');
	class TableRestaurantDAO{

		public static function getTableRestaurantById($idtablerestaurant ){
			$connex = DatabaseLinker::getConnexion();
			$state = $connex->prepare('SELECT * FROM tablerestaurant WHERE idtablerestaurant = :idtablerestaurant');
			$state->bindValue(":idtablerestaurant", $idtablerestaurant);
			$state->execute();
			$resultats = $state->fetchAll();
			if (sizeof($resultats) > 0){
				$result = $resultats[0];
				$TableRestaurant = new TableRestaurantDTO($result["nomtablerestaurant"], $result["nbpersonne"],$result["isoccuper"]);
				$TableRestaurant->setidtablerestaurant($result["idtablerestaurant"]);
			}
			return $TableRestaurant;
		}

		public static function getAllTableRestaurant(){
			$lestablerestaurant = array();
			$connex = DatabaseLinker::getConnexion();
			$state = $connex->prepare("SELECT * FROM tablerestaurant");
			$state->execute();
			$resultats = $state->fetchAll();
			foreach ($resultats	as $result){
				$TableRestaurant = new TableRestaurantDTO($result["nomtablerestaurant"], $result["nbpersonne"],$result["isoccuper"]);
				$TableRestaurant->setidtablerestaurant($result["idtablerestaurant"]);
				$lestablerestaurant[] = $TableRestaurant;
			}
			return $lestablerestaurant;
		}

		public static function deleteTableRestaurant($idtablerestaurant){
			$connex = DatabaseLinker::getConnexion();
			$state = $connex->prepare('DELETE FROM `tablerestaurant` WHERE idtablerestaurant = :idtablerestaurant');
			$state->bindValue(":idtablerestaurant", $idtablerestaurant);
			$state->execute();
		}

		public static function insertTableRestaurant($tablerestaurant){
			$connex = DatabaseLinker::getConnexion();
			$state = $connex->prepare('INSERT INTO `tablerestaurant`(`nomtablerestaurant`, `nbpersonne`,`isoccuper`) VALUES(:nomtablerestaurant , :nbpersonne, :isoccuper)');
			$state->bindValue(":nomtablerestaurant", $tablerestaurant->getnomtablerestaurant());
			$state->bindValue(":nbpersonne", $tablerestaurant->getNbPersonne());
			$state->bindValue(":isoccuper", $tablerestaurant->getIsoccuper());
			$state->execute();
			$tablerestaurant->setidtablerestaurant($connex->lastInsertId());
		}

		public static function updateTableRestaurant($tablerestaurant){
			$connex = DatabaseLinker::getConnexion();
			$state = $connex->prepare('UPDATE tablerestaurant SET nomtablerestaurant= :nomtablerestaurant, nbpersonne = :nbpersonne, isoccuper= :isoccuper where idtablerestaurant = :idtablerestaurant');
			$state->bindValue(":nomtablerestaurant", $tablerestaurant->getnomtablerestaurant());
			$state->bindValue(":nbpersonne", $tablerestaurant->getnbpersonne());
			$state->bindValue(":idtablerestaurant", $tablerestaurant->getIdTableRestaurant());
			$state->bindValue(":isoccuper", $tablerestaurant->getIsoccuper());
			$state->execute();
		}

	}
?>