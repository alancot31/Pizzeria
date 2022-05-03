<?php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	//à modifier
	$pathWs = "pizzeriaGroup4/";
	$fullUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$url = str_replace($pathWs . "server/", "", $fullUrl);
	$urlParts = explode( '/', $url );

	$requestMethod = $_SERVER["REQUEST_METHOD"];

	function includeFileWithClassName($class_name){
        $directorys = array(
            'controllers/',
            'DAO/',
            'DTO/',
            'tools/'
        );
        foreach($directorys as $directory){
            if(file_exists($directory.$class_name . '.php')){
                require_once($directory.$class_name . '.php');
                return;
            }           
        }
    }
	
	// enregistrement de la fonction de chargement automatique des fichiers
	spl_autoload_register('includeFileWithClassName');
	
	
	// en fonction de l'URL appelée, on charge différents controllers
	switch ($urlParts[1]) {
		case "Historique" :
			$historiqueId = null;
			if (isset($urlParts[2])) {
				$historiqueId = (int) $urlParts[2];
			}
			$controller = new HistoriqueController($requestMethod, $historiqueId);
			$controller->processRequest();
			break;
		case "Article" :
            $ArticleId = null;
			if (isset($urlParts[2])) {
                $ArticleId = (int) $urlParts[2];
			}
	
			$controller = new ArticleController($requestMethod, $ArticleId);
			$controller->processRequest();
			break;
       
		case "TableRestaurant" :
			$TableRestaurantid = null;
			if (isset($urlParts[2])) {
				$TableRestaurantid = (int) $urlParts[2];
			}
			$controller = new TableRestaurantController($requestMethod, $TableRestaurantid);
			$controller->processRequest();
			break;
		
		case "Commande" :
			$Commandeid = null;
			if (isset($urlParts[2])) {
				$Commandeid = (int) $urlParts[2];
			}
			$controller = new CommandeController($requestMethod, $Commandeid);
			$controller->processRequest();
			break;
        case "Appartient" :
            $Commandeid = null;
            if (isset($urlParts[2])) {
                $Commandeid = (int) $urlParts[2];
            }
            $controller = new AppartientController($requestMethod, $Commandeid);
            $controller->processRequest();
            break;

		default :
			header("HTTP/1.1 404 Not Found");
			exit();
			break;
	}	
	