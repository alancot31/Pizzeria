<?php
//super controleur permet de rediriger vers les page
class SuperControleur
{

    public static function callPage($page)
    {
        ini_set('display_errors', 'off');
        switch ($page)
        {
            case "table1" :
                include_once("pages/table1/ControllerTable1.php");
                $_SESSION["id"]= $_GET["id"];
                $_SESSION["nomtable"]= $_GET["nomtable"];
                $instance = new ControllerTable1();
                $instance->includeView();
                include_once("pages/supprimerCommande/ControleurSupprimerCommande.php");
                $instance = new ControleurSupprimerCommande();
                $instance->includeView();
                break;
            case "addCommande" :
                include_once("pages/supprimerCommande/ControleurSupprimerCommande.php");
                $instance = new ControleurSupprimerCommande();
                $instance->includeView();
                include_once("pages/addCommande/ControleurAddCommande.php");
                $instance = new ControllerAddCommande();
                $instance->includeView();
                break;
            case "insertCommande" :
                if(isset($_POST['b1']))
                {
                    include_once("pages/addCommande/ControleurAddCommande.php");
                    $instance = new ControllerAddCommande();
                    $instance->insertCommande();
                    include_once("pages/supprimerCommande/ControleurSupprimerCommande.php");
                    $instance = new ControllerAddCommande();
                    $instance->includeView();
                    break;
                }
                elseif(isset($_POST['b2']))
                {
                    include_once("pages/addCommande/ControleurAddCommande.php");
                    $instance = new ControllerAddCommande();
                    $instance->insertCommande();
                    break;
                }
            case "SupprimerCommande" :
                if(isset($_GET['idC']))
                {
                    include_once("pages/supprimerCommande/ControleurSupprimerCommande.php");
                    $instance = new ControleurSupprimerCommande();
                    $instance->supprimer($_GET['idC'],$_GET['idA'],$_GET['cpt']);
                    break;
                }
                else
                {
                    include_once("pages/supprimerCommande/ControleurSupprimerCommande.php");
                    $instance = new ControleurSupprimerCommande();
                    $instance->includeView();
                    break;
                }
            case "occuper" :
                if(isset($_GET['traitement']))
                {
                    include_once ("pages/occuper/ControleurOccuper.php");
                    $instance = new ControleurOccuper;
                    $instance->insert($_POST['Quantiter']);
                    include_once("pages/supprimerCommande/ControleurSupprimerCommande.php");
                    $instance = new ControleurSupprimerCommande();
                    $instance->includeView();
                }
                else
                {
                    include_once("pages/occuper/ControleurOccuper.php");
                    $instance = new ControleurOccuper;
                    $instance->includeView();
                    include_once("pages/supprimerCommande/ControleurSupprimerCommande.php");
                    $instance = new ControleurSupprimerCommande();
                    $instance->includeView();
                }
                break;
            case "ModifierCommande" :
                if(isset($_POST['b1']))
                {
                    include_once("pages/modifier/ControllerModifier.php");
                    $instance = new ControllerModifier;
                    $instance->Modifie();
                }
                else
                {
                    $_SESSION['idC'] = $_GET['idC'];
                    $_SESSION['idA'] = $_GET['idA'];
                    $_SESSION['cpt'] = $_GET['cpt'];
                    include_once("pages/modifier/ControllerModifier.php");
                    $instance = new ControllerModifier;
                    $instance->includeView();
                    break;
                }

        }
    }
}
