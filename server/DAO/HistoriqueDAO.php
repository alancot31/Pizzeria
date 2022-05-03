<?php
	include_once('DTO/HistoriqueDTO.php');
	class HistoriqueDAO{
		public static function getHistoriqueById($id){
			$connex = DatabaseLinker::getConnexion();
			$state = $connex->prepare('SELECT * FROM historique WHERE idhistorique = :idhistorique');
			$state->bindValue(":idhistorique", $id);
			$state->execute();
			$resultats = $state->fetchAll();
			if (sizeof($resultats) > 0){
				$result = $resultats[0];
				$elem = new HistoriqueDTO($result["date"],$result["elementcommande"],$result['prix'],$result['idcommande']);
				$elem->setIdHistorique($result["idhistorique"]);
			}
			return $elem;
		}
		public static function getAllElementbyidcommande($id){
			$elemes = array();
			$connex = DatabaseLinker::getConnexion();
			$state = $connex->prepare('SELECT * FROM `historique` WHERE idcommande = :idcommande' );
			$state->bindValue(":idcommande", $id);
			$state->execute();
			$resultats = $state->fetchAll();
			foreach ($resultats	as $result){
				$elem = new HistoriqueDTO($result["date"],$result["elementcommande"],$result['prix'],$result['idcommande']);
				$elem->setIdHistorique($result["idhistorique"]);
				$elemes[] = $elem;
			}
			return $elemes;
		}
				
		public static function getAllHistorique(){
			$elemes = array();
			$connex = DatabaseLinker::getConnexion();
			$state = $connex->prepare('SELECT * FROM historique');
			$state->execute();
			$resultats = $state->fetchAll();
			foreach ($resultats	as $result){
				$elem = new HistoriqueDTO($result["date"],$result["elementcommande"],$result['prix'],$result['idcommande']);
				$elem->setIdHistorique($result["idhistorique"]);
				
				$elemes[] = $elem;
			}
			return $elemes;
		}

		public static function insertHistorique($elem){
			$connex = DatabaseLinker::getConnexion();
			$state = $connex->prepare('INSERT INTO historique(date,elementcommande,prix,idcommande) VALUES(:date,:elementcommande,:prix,:idcommande)');
			$state->bindValue(":date", $elem->getDate());
			$state->bindValue(":elementcommande", $elem->getElementCommande());
			$state->bindValue(":prix", $elem->getPrix());
			$state->bindValue(":idcommande", $elem->getIdCommande());
			$state->execute();
			$elem->setIdHistorique($connex->lastInsertId());
		}
	}
?>