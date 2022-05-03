<?php

include_once('tools/DatabaseLinker.php');
include_once('DAO/ArticleDAO.php');
class ArticleController{
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
                    $response = $this->getArticleById($this->ArticleId);
                } else {
                    $response = $this->getAllArticle();
                };
                break;
 
                case 'POST':
                if ($this->ArticleId) {
                    $response = $this->notFoundResponse();
                }else{
                    $response = $this->createArticle();
                }
                break;
            case 'PUT':
                if ($this->ArticleId) {
                    $response = $this->notFoundResponse();

                }else{
                    $response = $this->updateArticle();
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

    public function getAllArticle(){
        $result = ArticleDAO::getAllArticle();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getArticleById($id) {
        $result = ArticleDAO::getArticleById($id);
        if ($result == null)
        {
            return $this->notFoundResponse();
        }

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createArticle(){
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input["nomarticle"])|| empty($input["prixarticle"]) ||empty($input["categoriearticle"])){
            return $this->unprocessableEntityResponse();
        }
        else{
            $Article =new ArticleDTO($input["nomarticle"],$input["prixarticle"],$input["categoriearticle"]);
            ArticleDAO::insertArticle($Article);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode($Article);
            return $response;}
    }

    private function updateArticle() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if(empty($input["idarticle"]) ||empty($input["nomarticle"])){
            return $this->unprocessableEntityResponse();
        } 
        else{
            $Article = new ArticleDTO($input["nomarticle"],$input["prixarticle"],$input["categoriearticle"]);
            $Article->setIdArticle($input["idarticle"]);
            ArticleDAO::updateArticle($Article);
            $response['status_code_header'] = 'HTTP/1.1 201 Modifier';
            $response['body'] = json_encode($Article);
            return $response;
        }
    }

    private function deleteArticle($id) {
        $result = ArticleDAO::getArticleById($id);
        if($result == null){
            return $this->notFoundResponse();
        }
            ArticleDAO::deleteArticle($id);
        $response['status_code_header'] = 'HTTP/1.1 200 Successful deletion';
        $response['body'] = null;
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
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found ';
        $response['body'] = null;
        return $response;
    }

    
}