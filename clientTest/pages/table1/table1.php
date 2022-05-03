<?php
$t = $_GET['id'];
?>
<ul id="option">
    <?php
    include_once('tools/RequestSender.php');
    $result = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/TableRestaurant/'.$t);
    $table = json_decode($result);
    $nomTable = $table->nomtablerestaurant;
    echo "<label>"."Type Table : ".$nomTable."</label>"."<br>";
    ?>
    <li>
        <?php
        include_once('tools/RequestSender.php');
        $result = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/TableRestaurant/'.$t);
        $table = json_decode($result);
        $nomTable = $table->nomtablerestaurant;
        $occuper = $table->isoccuper;
        if($occuper==0)
        {
            ?>
            <input type="button" onclick="window.location.href = 'http://localhost/pizzeriaGroup4/clientTest/index.php?page=occuper';" value="occuper"/>
        <?php
        }
        ?>
    </li>
    <li>
        <?php
        if($occuper!=0)
        {
        ?>
        <input type="button" onclick="window.location.href = 'http://localhost/pizzeriaGroup4/clientTest/index.php?page=addCommande';" value="ajouter commande"/>
        <?php
        }
        ?>
    </li>
    <input class = "buttonparticulier" type="button" onclick="window.location.href = 'http://localhost/pizzeriaGroup4/clientTest/index.php';" value="Acceuil"/>
</ul>
