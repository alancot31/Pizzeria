<?php
ini_set('display_errors', 'off');
class ControllerAddCommande
{
    public function includeView()
    {
        require_once "pages/addCommande/AddCommande.php";
    }
    public function insertCommande()
    {
        $nop=2;
        //envoie la commande aux server
        $result1 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/Article/'.$_POST['article']);
        $result2 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/TableRestaurant/'.$_SESSION["id"]);
        $result2= json_decode($result2);
        $idcommande=$result2->isoccuper;
        //cherhche la commande part l'id
        $result4 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/Commande/'.$idcommande);
        $result4= json_decode($result4);
        $result1 = json_decode($result1);
        $prix_article = $result1->prixarticle;
        $prix = $prix_article*$_POST['Quantiter'];
        //somme commande + le prix de l'article* sa quantiter
        $prix+=$result4->sommecommande;
        date_default_timezone_set('Europe/Paris');
        $date = date("Y-m-d H:i:s",time());
        $idarticle=$_POST['article'];
        $quantiter=$_POST['Quantiter'];
        $tabArticle[]=array();
        for($i=0;$i<=count($result4->listarticle);$i++)
        {
            $result=$result4->listarticle[$i]->idarticle;
            if($idarticle ==$result )
            {
                $tabArticle=$result4->listarticle;
                $nop=1;
            }
            else
            {
                $tabArticle[]=array
                (
                    "idarticle"=>$idarticle,
                    "quantiter"=>$quantiter,
                );
                $idarticle1 = $result4->listarticle[$i]->idarticle;
                $quantiter = $result4->listarticle[$i]->quantiter;
                $tabArticle[] = array
                (
                    "idarticle" => $idarticle1,
                    "quantiter" => $quantiter,
                );
            }
        }
        if($nop==2)
        {
            $data = array
            (
                "idcommande" => $idcommande,
                "sommecommande" => $prix,
                "idtablerestaurants" => $_SESSION["id"],
                "listarticle" => $tabArticle,
                "date" => $date
            );
            $url = 'localhost/pizzeriaGroup4/server/Commande';
            $response = RequestSender::sendPutRequest($url, $data);
            header('Location: index.php?page=addCommande');
        }
        else
        {
            ?>
            <script>alert("impossible d'ajouter deux fois le meme article veuillez modifer sa valeur");</script>
            <?php
        }
    }
}
