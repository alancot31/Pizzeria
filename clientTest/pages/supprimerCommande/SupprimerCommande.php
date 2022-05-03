<div id = "contenucommande">
<?php
ini_set('display_errors', 'off');
$cpt=0;
$cpt1=0;
// recherche la liste de toute les commandes
$result1 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/Commande');
$result1=json_decode($result1,true);

$result2 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/TableRestaurant/'.$_SESSION["id"]);
$result2=json_decode($result2);
$a=$result2->isoccuper;

$result3 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/Appartient');
$result3=json_decode($result3);
    for ($i=0; $i<=count($result1);$i++)
    {
        $t=$result1[$i];
        //recherche uniquement les commande de la table
        if($t["idcommande"] == $a)
        {
            $result=$t["listarticle"];
            if(isset($result[0]))
            {
                foreach ($result3 as $b)
                {
                    $cpt1++;
                    $idC=$t["idcommande"];
                    $r = $result[$cpt];
                    $result2 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/Article/' . $r["idarticle"]);
                    $r1 = json_decode($result2);
                    if($r['quantiter'] >0)
                    {
                        //affiche la commande avec quantiter de la table
                        ?>
                        <div id="contenucommande"class="nomarge">
                            <?php
                            // affiche les image des commandes
                                switch ($r1->categoriearticle)
                                {
                                    case "boissons":
                                        echo "<div class='img'> <img src='images/boisson.jpg' alt='' height='100px' width='100px'/></div>";
                                        break;
                                    case "pizzas":
                                        echo "<div class='img'> <img src='images/pizza.jpg'alt=''height='100px' width='100px'/></div>";
                                        break;
                                    case "desserts":
                                        echo "<div class='img'> <img src='images/dessert.png'alt=''height='100px' width='100px'/></div>";
                                        break;
                                }
                                echo "Article: ",$r1->nomarticle, "  / Quantiter : ", $r["quantiter"];
                            ?>
                            <!--  lien mofifier/supprimer avec info url-->
                            <p>
                            <a href="index.php?page=SupprimerCommande&idC=<?php echo $idC; ?>&idA=<?php echo $r["idarticle"]; ?>&cpt=<?php echo $cpt1?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
                            
</a>

                                -
                                    <a href="index.php?page=ModifierCommande&idC=<?php echo $idC; ?>&idA=<?php echo $r["idarticle"]; ?>&cpt=<?php echo $cpt1?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
                                    
                                    </a>
                                </p>
                        </div>
                        <?php
                        $cpt++;
                    }
                }
            }
                //permet d'afficher la somme total de la commande
                $result1 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/Article/'.$_POST['article']);
                $result2 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/TableRestaurant/'.$_SESSION["id"]);
                $result3= json_decode($result2);
                $idcommande=$result3->isoccuper;
                $result4 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/Commande/'.$idcommande);
                $result4= json_decode($result4);
                $prix=0;
                $prix+=$result4->sommecommande;
                    ?>
            <p>
                <?php
                    echo "Prix total : ".$prix."€";
                ?>
            </p>
        <?php
        }
    }
?>
</div>

