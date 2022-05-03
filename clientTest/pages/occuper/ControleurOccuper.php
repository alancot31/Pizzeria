<?php

class ControleurOccuper
{
    //redirige vers la page vue avec formulaire Ocuper
    public function includeView()
    {
        include_once "pages/occuper/Occuper.php";
    }
    //met la table en occuper avec les valeur et l'id de la commande
    public function insert($nbPersonne)
    {
        // crée une commande
        date_default_timezone_set('Europe/Paris');
        $date = date("Y-m-d H:i:s",time());
        $tabArticle[]=array(
            "idarticle"=>null,
            "quantiter"=>null);
        $data1=array
        (
            "sommecommande" => 0,
            "idtablerestaurants" =>  $_SESSION["id"],
            "listarticle"=> $tabArticle,
            "date"  => $date
        );
        $url ='localhost/pizzeriaGroup4/server/Commande';
        $response = RequestSender::sendPostRequest($url,$data1);
        $url ='localhost/pizzeriaGroup4/server/Commande';
        $response = RequestSender::sendGetRequest($url);
        $a=json_decode($response);
        //recupere l'id de la commande crée
        foreach ($a as $b)
        {
            $_SESSION[$_SESSION["id"]]=$b->idcommande;
        }
        $data = array(
            "idtablerestaurant" => $_SESSION["id"],
            "nomtablerestaurant" =>  $_SESSION["nomtable"],
            "nbpersonne"  => json_decode($nbPersonne),
            //insert l'id de la commande qui a etait cree dans ISOCCUPER
            "isoccuper" =>$_SESSION[$_SESSION["id"]]
        );
        $url ='localhost/pizzeriaGroup4/server/TableRestaurant';
        $response = RequestSender::sendPutRequest($url,$data);
        header('Location: index.php');
    }
}