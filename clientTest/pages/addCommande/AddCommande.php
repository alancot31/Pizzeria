<!--  formulaire pour ajouter une commande  -->
    <form  method="post" action="index.php?page=insertCommande">
        <div>
            <label for="name">ARTICLE :</label>
            <select name="article">
                <?php
                    $result2 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/Article');
                    $result3 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/TableRestaurant/'.$_SESSION["id"]);
                    $result3=json_decode($result3);
                    $table2 = json_decode($result2);
                    for ($i = 1; $i <= count($table2); $i++)
                    {
                        $result1 = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/Article/'.$i);
                        $table1 = json_decode($result1);
                        $t1 = $table1->nomarticle;
                ?>
                <option value="<?php echo $i ?>"><?php echo $t1;}?></option>
            </select>
            <div>
                <label for="msg">QUANTITÉ  :</label>
                <input id="msg" name="Quantiter"></input>
            </div>
            <div class="button">
                <button class = "buttonparticulier" type="submit" name="b2" value="b2">Ajouter un autre article dans la commande</button>
            </div>
        </div>
    </form>
