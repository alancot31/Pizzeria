<?php
include_once('tools/DatabaseLinker.php');
include_once('DAO/TableRestaurantDAO.php');
class TableRestaurantController {
    private $requestMethod;
    private $idtablerestaurant = null;

    public function __construct($requestMethod, $id) {
        $this->requestMethod = $requestMethod;
		$this->idtablerestaurant = $id;
        }

    public function processRequest() {
		$response = $this->notFoundResponse();
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->idtablerestaurant) {
                    $response = $this->getIdTableRestaurantById($this->idtablerestaurant);
                }
                else {
                    $response = $this->getAllTableRestaurant();
                };
                break;
            case 'POST':
				if ($this->idtablerestaurant) {
					$response = $this->notFoundResponse();
				}
                else{
                    $response = $this->CreatTableRestaurant();
                }
                break;
           case 'PUT':
				if ($this->marqueId) {
                    $response = $this->notFoundResponse();
                   
                }else{
                    $response = $this->updateTableRestaurant();
                }
                break;

            case 'DELETE':
                if($this->idtablerestaurant){
                    $this->deletTableRestaurant($this->idtablerestaurant);
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

    public function getAllTableRestaurant() {		
        $result = TableRestaurantDAO::getAllTableRestaurant();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getIdTableRestaurantById($id) {	
		$result = TableRestaurantDAO::getTableRestaurantById($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function CreatTableRestaurant(){
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input["nomtablerestaurant"]) and (empty($input["nbpersonne"])) and (empty($input["isoccuper"]))) {
            return $this->unprocessableEntityResponse();
        }
		$TableRestaurant = new TableRestaurantDTO($input["nomtablerestaurant"],$input["nbpersonne"],$input["isoccuper"]);
        TableRestaurantDAO::insertTableRestaurant($TableRestaurant);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($TableRestaurant);
        return $response;
    }

    private function updateTableRestaurant() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input["nomtablerestaurant"]) and (empty($input["nbpersonne"])) and (empty($input["isoccuper"]))){
            return $this->unprocessableEntityResponse();
        }

        else{
            $TableRestaurant = new TableRestaurantDTO($input["nomtablerestaurant"],$input["nbpersonne"],$input["isoccuper"]);
            $TableRestaurant->setidtablerestaurant($input["idtablerestaurant"]);

            TableRestaurantDAO::updateTableRestaurant($TableRestaurant);
            $response['status_code_header'] = 'HTTP/1.1 201 Modifier';
            $response['body'] = json_encode($TableRestaurant);
            return $response;
        }
        
      
    }
    private function deletTableRestaurant($id) {
        $result = TableRestaurantDAO::getTableRestaurantById($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }
        TableRestaurantDAO::deleteTableRestaurant($id);
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