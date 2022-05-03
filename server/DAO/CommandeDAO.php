<?php
	include_once('DTO/CommandeDTO.php');
	class CommandeDAO{

		public static function getCommandeByid($idcommande){
			$connex = DatabaseLinker::getConnexion();
			$state = $connex->prepare('SELECT * FROM `commande` WHERE idcommande = :idcommande');
			$state->bindValue(":idcommande", $idcommande);
			$state->execute();
			$stateArt = $connex->prepare('SELECT * FROM `appartient` WHERE idcommande = :idcommande');
			$stateArt->bindValue(":idcommande",$idcommande);
			$stateArt->execute();
			$resArt = $stateArt->fetchAll();
			$resultats = $state->fetchAll();
			$listeArticle = array();
			if (sizeof($resultats) > 0){
				foreach($resArt as $article){
					$liste =array('idarticle'=>$article["idarticle"], 'quantiter'=>$article["quantiter"]); ;
					$listeArticle[] = $liste;
					
				}
					$result = $resultats[0];
					$commande = new CommandeDTO($result["sommecommande"],$result['idtablerestaurant'],$listeArticle, $result["date"]);
					$commande->setidCommande($result["idcommande"]);
					return $commande;
			}else{return null;}
			
		}

		public static function getAllCommande(){
			$commandes = array();
			$connex = DatabaseLinker::getConnexion();
			$state = $connex->prepare('SELECT * FROM commande');
			$state->execute();
			$resultats = $state->fetchAll();			
			foreach ($resultats	as $result){
				$listeArticle = array();
				$stateArt = $connex->prepare('SELECT * FROM `appartient` WHERE idcommande = :idcommande');
				$stateArt->bindValue(":idcommande",$result["idcommande"]);
				$stateArt->execute();
				$resArt = $stateArt->fetchAll();
				foreach($resArt as $article){
					$liste =array('idarticle'=>$article["idarticle"], 'quantiter'=>$article["quantiter"]); ;
					$listeArticle[] = $liste;
					
				}
				$commande = new CommandeDTO($result["sommecommande"],$result['idtablerestaurant'],$listeArticle, $result["date"]);
				$commande->setidCommande($result["idcommande"]);
				$commandes[] = $commande;
			}
			return $commandes;
		}

		public static function deleteCommande($idcommande){

			$connex = DatabaseLinker::getConnexion();
			$stateArt = $connex->prepare('DELETE  FROM `appartient` WHERE idcommande = :idcommande');
			$stateArt->bindValue(":idcommande",$idcommande);
			$stateArt->execute();
			$state = $connex->prepare('DELETE  FROM `commande` WHERE idcommande = :idcommande');
			$state->bindValue(":idcommande", $idcommande);
			$state->execute();		
		}
		public  function getnbcom(){
			$connex = DatabaseLinker::getConnexion();
			$state = $connex->prepare("SELECT COUNT(*) FROM commande");
			$state->execute();
			$resultats = $state->fetch();
			return $resultats;
	
		}
		public static function insertCommande($commande){
			$connex = DatabaseLinker::getConnexion();
			$state = $connex->prepare('INSERT INTO commande  (`sommecommande`, `idtablerestaurant`, `date`) VALUES(:sommecommande,  :idtablerestaurants,:date)');
			$state->bindValue(":sommecommande", $commande->getSommeCommande());
			$state->bindValue(":date", $commande->getDate());
			$state->bindValue(":idtablerestaurants", $commande->getIdtablerestaurants());
			$state->execute();

			$commande->setIdCommande($connex->lastInsertId());
			$list =  $commande->getListarticle();
			
			foreach($list as $art){
				$idart = $art["idarticle"];
				$qte = $art["quantiter"];
				echo $art["quantiter"];
				$stateArt = $connex->prepare('INSERT INTO `appartient` (`idarticle`, `idcommande`, `quantiter`) VALUES (:idarticle,:idcommande,:quantiter)');		
				$stateArt->bindValue(":idarticle", $idart);
				$stateArt->bindValue(":idcommande", $commande->getIdCommande());
				$stateArt->bindValue(":quantiter", $qte);
				$stateArt->execute();
			}			
		}

		public static function updateCommande($commande){
			$connex = DatabaseLinker::getConnexion();
			$state = $connex->prepare('UPDATE `commande` SET `sommecommande`=:sommecommande, `date`= :date, `idtablerestaurant`= :idtablerestaurants WHERE `idcommande` = :idcommande');
			$state->bindValue(":sommecommande", $commande->getSommeCommande());
			$state->bindValue(":date", $commande->getDate());
			$state->bindValue(":idtablerestaurants", $commande->getIdtablerestaurants());
			$state->bindValue(":idcommande", $commande->getIdCommande());
			$state->execute();


			$stateArt = $connex->prepare('DELETE FROM `appartient` WHERE idcommande = :idcommande');
			$stateArt->bindValue(":idcommande",$commande->getIdCommande());
			$stateArt->execute();
			$list =  $commande->getListarticle();
			foreach($list as $art){
				$idarti = $art["idarticle"];
				$qte = $art["quantiter"];
				$stateArt = $connex->prepare('INSERT INTO `appartient` (`idarticle`, `idcommande`, `quantiter`) VALUES (:idarticle,:idcommande,:quantiter)');		
				$stateArt->bindValue(":idarticle", $idarti);
				$stateArt->bindValue(":idcommande", $commande->getIdCommande());
				$stateArt->bindValue(":quantiter", $qte);
				$stateArt->execute();
			}	
		}
	}
?>