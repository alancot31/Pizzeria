<?php
$result1 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/Article/'. $_SESSION['idA']);
$result1=json_decode($result1);
?>
<div id="modifier">
    <form  method="post" action="index.php?page=ModifierCommande">
        <div>
            <label for="name">article : <?php echo $result1->nomarticle;?></label>
            <div>
                <label for="msg">Nouvelle quantiter :</label>
                <input id="msg" name="Quantiter"></input>
            </div>
            <div class="button">
                <button type="submit" name="b1" value="b1">modifier</button>
            </div>
        </div>
    </form>
</div>