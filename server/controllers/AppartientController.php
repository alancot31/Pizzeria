<?php
include_once('tools/DatabaseLinker.php');
include_once('DAO/AppartientDAO.php');
class AppartientController
{
    private $requestMethod;
    private $ArticleId = null;

    public function __construct($requestMethod, $id) {
        $this->requestMethod = $requestMethod;
        $this->ArticleId = $id;
    }

    public function processRequest() {
        $response = $this->notFoundResponse();
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->ArticleId) {
                    $response = $this->getAppartientById($this->ArticleId);
                } else {
                    $response = $this->getAllAppartient();
                };
                break;

            case 'POST':
                if ($this->ArticleId) {
                    $response = $this->notFoundResponse();
                }else{
                    $response = $this->createAppartient();
                }
                break;
            case 'PUT':
                if ($this->ArticleId) {
                    $response = $this->notFoundResponse();

                }else{
                    $response = $this->updateAppartient();
                }
                break;
            case 'DELETE':
                if($this->ArticleId){
                    $this->deleteArticle($this->ArticleId);
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
    public function getAllAppartient()
    {
        $result = AppartientDAO::getAllAppartient();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getAppartientById($id)
    {
        $result = AppartientDAO::getAppartientById($id);
        if ($result == null)
        {
            return $this->notFoundResponse();
        }

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found ';
        $response['body'] = null;
        return $response;
    }


    private function deleteArticle($id)
    {
        $result = AppartientDAO::getAppartientById($id);
        if($result == null)
        {
            return $this->notFoundResponse();
        }
        AppartientDAO::deleteAppartient($id);
        $response['status_code_header'] = 'HTTP/1.1 200 Successful deletion';
        $response['body'] = null;
        return $response;
    }

    private function updateAppartient()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if(empty($input["quantiter"]) ||empty($input["idarticle"] ||empty($input["idcommande"])))
        {
            return $this->unprocessableEntityResponse();
        }
        else{
            $Article = new AppartientDTO($input["idarticle"],$result["idcommande"],$input["quantiter"]);
           
            AppartientDAO::updateAppartient($Article);
            $response['status_code_header'] = 'HTTP/1.1 201 Modifier';
            $response['body'] = json_encode($Article);
            return $response;
        }
    }
    private function unprocessableEntityResponse() {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function createAppartient(){
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input["quantiter"]) ||empty($input["idarticle"])){
            return $this->unprocessableEntityResponse();
        }
        else{
            $Article =new AppartientDTO($input["idarticle"],$input["idcommande"],$input["quantiter"]);
            AppartientDAO::insertAppartient($Article);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode($Article);
            return $response;}
    }
}