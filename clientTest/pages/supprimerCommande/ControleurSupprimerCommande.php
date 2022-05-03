<?php

class ControleurSupprimerCommande
{
    public function includeView()
    {
        include_once "pages/supprimerCommande/SupprimerCommande.php";
    }
    public function supprimer($idC, $idA, $cpt)
    {
        // supprimer la l'article de la commande en question
        $result1 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/Commande/' . $idC);
        $result2 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/Article/' .$idA);
        $result1 = json_decode($result1);
        $result2= json_decode($result2);
        //recupere la somme de la commande
        $prix=$result1->sommecommande;
        //recupere la liste de la commmande
        $result = $result1->listarticle;
        //recupere l'emplacement de l'article a supprimer dans la commande
        $id=$result[$cpt - 1];
        //recupere la quantiter de l'articel a supprimer
        $idQ=$id->quantiter;
        //recupere le prix de l'article
        $prixA=$result2->prixarticle;
        //calcul le prix de l'article * sa quantiter dans la liste
        $prix2=$idQ*$prixA;
        //retire le prix ancien - le prix de l'article* sa quantiter
        $prix=$prix-$prix2;
        //range le array
        unset($result[$cpt - 1]);
        date_default_timezone_set('Europe/Paris');
        $date = date("Y-m-d H:i:s",time());
        $resulta = array
        (
            "idcommande" =>$idC,
            "sommecommande" => $prix,
            "idtablerestaurants" => $_SESSION["id"],
            "listarticle" => $result,
            "date"  => $date
        );
        $url = "localhost/pizzeriaGroup4/server/Commande";
        $result = RequestSender::sendPutRequest($url,$resulta);
        if($result=='HTTP/1.1 422 Unprocessable Entity{"error":"Invalid input"}')
        {
            //si il reste 1 seule element dans la commande allor affiche ce msg car commande ne peux pas avoir rien
           ?>
            <script>alert("impossible de supprimer tout les elements d'une commande");</script>
            <?php
        }
        else
        {
            header('Location: index.php?page=addCommande');
        }
    }
}