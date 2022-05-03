<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>PizzeriaG4</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css" media="all"/>
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="css/js.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
</head>
<body>
    <div id="titlePizzeria">
    </div>
    <?php
    session_name("Pizzeria");
    session_start();
    $page = "Accueil";
    include_once("tools/superController.php");
    if (!empty($_GET['page']))
    {
        $page = $_GET['page'];
    }
    include_once('tools/RequestSender.php');
    $results = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/TableRestaurant');
    $tables = json_decode($results);
    for ($i = 1; $i <= count($tables); $i++)
    {
        $result = RequestSender::sendGetRequest('localhost/pizzeriaGroup4/server/TableRestaurant/'.$i);
        $table = json_decode($result);
        $nomTable = $table->nomtablerestaurant;
        $nbpersonne = $table->nbpersonne;
        $occuper = $table->isoccuper;
        ?>
        <ul>
            <li>
                <!-- boutton html avec url personnaliser-->
                <button style="width:400px"
                    onclick="window.location.href = 'index.php?page=table1&id=<?php echo $i;?>&nomtable=<?php  $nomTable = $table->nomtablerestaurant; echo $nomTable ?>';"><?php echo $nomTable.' -> ';
                        if ($occuper==0){
                            echo 'libre';
                        }
                        else
                        {
                            echo 'occuper';
                            echo ' / ';
                            echo $nbpersonne , ' personnes';
                        };?>
                </button>
                </a>
            </li>
        </ul>
    <?php
    }
    ?>
    <?php
        SuperControleur::callPage($page);
    ?>
</body>
</html>