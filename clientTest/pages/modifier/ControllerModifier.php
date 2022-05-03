<?php
class ControllerModifier
{
    public function includeView()
    {
        include_once "pages/modifier/modifier.php";
    }

    public function modifie()
    {
        $result5 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/Article/'.$_SESSION['idA']);
        $result4 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/Commande/'.$_SESSION['idC']);
        $result4= json_decode($result4);
        $result5= json_decode($result5);
        $result5=$result5->prixarticle;
        $somme=$result4->sommecommande;
        $result4=$result4->listarticle;
        $cpt=$_SESSION['cpt']-1;
        $a=$result4[$cpt]->quantiter;
        date_default_timezone_set('Europe/Paris');
        $date = date("Y-m-d H:i:s",time());
        //calcule si la quantiter avant < a la nouvelle quantiter
        $resu=$result4[$cpt]->quantiter;
        if($resu <$_POST['Quantiter'])
        {
            $t=$_POST['Quantiter']-$a;
            $cal=$t*$result5;
            $prix=$somme+$cal;
        }
        //calcule si la quantiter avant > a la nouvelle quantiter
        elseif($resu >$_POST['Quantiter'])
        {
            $t=$a-$_POST['Quantiter'];
            $cal=$t*$result5;
            $prix=$somme-$cal;
        }
        //insert nouvelle valeur
        $result4[$cpt]=array
        (
            'quantiter'=>$_POST['Quantiter'],
            'idarticle'=>$_SESSION['idA']
        );
        $result2 = array
        (
            "idcommande" =>$_SESSION['idC'],
            "sommecommande" => $prix,
            "idtablerestaurants" => $_SESSION["id"],
            "listarticle" => $result4,
            "date"  => $date
        );
        $url = "localhost/pizzeriaGroup4/server/Commande";
        $result = RequestSender::sendPutRequest($url,$result2);
        header('Location: index.php?page=table1&id='.$_SESSION["id"]);
    }
}