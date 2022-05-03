<?php
include_once('tools/DatabaseLinker.php');
include_once('DAO/CommandeDAO.php');
class CommandeController {
    private $requestMethod;
    private $idcommande = null;

    public function __construct($requestMethod, $id) {
        $this->requestMethod = $requestMethod;
		$this->idcommande = $id;
        }

    public function processRequest() {
		$response = $this->notFoundResponse();
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->idcommande) {
                    $response = $this->getIdCommandeById($this->idcommande);
                }
                else {
                    $response = $this->getAllCommande();
                };
                break;
            case 'POST':
				if ($this->idcommande) {
					$response = $this->notFoundResponse();
				}
                else{
                    $response = $this->CreatCommande();
                }
                break;
            case 'PUT':
				if ($this->idcommande) {
                    $response = $this->notFoundResponse();
                   
                }else{
                    $response = $this->updateCommande();
                }
                break;
            case 'DELETE':
                if($this->idcommande){
                    $response =  $this->deletCommande($this->idcommande);
                }
                break;

            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        if ($response['body'] != null && $response['status_code_header'] === "HTTP/1.1 200 OK") {
            echo $response['body'];
        }
		else {
			echo $response['status_code_header'];
			echo $response['body'];
		}
    }

    public function getAllCommande() {		
        $result = CommandeDAO::getAllCommande();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getIdCommandeById($id) {	
		$result = CommandeDAO::getCommandeByid($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function CreatCommande(){
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input["sommecommande"]) and (empty($input["date"]))) {
            return $this->unprocessableEntityResponse();
        }
		$Commande = new CommandeDTO($input["sommecommande"],$input['idtablerestaurants'],$input['listarticle'],$input["date"]);
        CommandeDAO::insertCommande($Commande);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($Commande);
        return $response;
    }
    
    private function updateCommande() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input["sommecommande"]) || (empty($input["date"]))) {
            return $this->unprocessableEntityResponse();
        }
        else{
            $Commande = new CommandeDTO($input["sommecommande"],$input['idtablerestaurants'],$input['listarticle'],$input["date"]);
            $Commande->setidCommande($input["idcommande"]);
            CommandeDAO::updateCommande($Commande);
            $response['status_code_header'] = 'HTTP/1.1 201 Modifier';
            $response['body'] = json_encode($Commande);
            return $response;
        }
    }


    private function deletCommande($id) {
        $result = CommandeDAO::getCommandeByid($id);
        if ($result == null) {
            
            return $this->notFoundResponse();
        }
        CommandeDAO::deleteCommande($id);
        $response['status_code_header'] = 'HTTP/1.1 202 Successful deletion';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function unprocessableEntityResponse() {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse() {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}