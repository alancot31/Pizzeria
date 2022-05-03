package com.sio.mavenprojectwebservice.controllers;

import com.sio.mavenprojectwebservice.tools.PageSwitcher;
import com.sio.mavenprojectwebservice.tools.RequestServer;
import java.io.IOException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.control.Button;
import javafx.scene.control.ChoiceBox;
import javafx.scene.control.TextField;
import org.json.simple.JSONObject;

public class ArticleEditionController {
    @FXML
    private TextField nomarticle;
    @FXML
    private TextField prixarticle;
    @FXML
    private ChoiceBox<String> choic;
    @FXML
    private Button ok;
      
    private int idArticleToEdit =0;
    @FXML
    private void switchToList() {
        try {
            FXMLLoader loader = PageSwitcher.loadFXMLIntoStage("listarticle");
            ListArticleController ctrl =loader.getController();
            ctrl.initController();
            PageSwitcher.loadFXMLIntoStage("listarticle");
        } catch (IOException ex) {
            Logger.getLogger(ArticleEditionController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }   
    @FXML
    private void saveChanges(){
        if(idArticleToEdit == 0){
            JSONObject obj = new JSONObject();
            obj.put("nomarticle", nomarticle.getText());
            obj.put("prixarticle", prixarticle.getText());
            obj.put("categoriearticle",choic.getValue());
            RequestServer.postArticle(obj); 
        }else{
            JSONObject obj = new JSONObject();
            obj.put("idarticle", idArticleToEdit);         
            obj.put("nomarticle", nomarticle.getText());
            obj.put("prixarticle", prixarticle.getText());           
            obj.put("categoriearticle", choic.getValue());
            RequestServer.updateArticle(obj);  
        }        
        switchToList();
    }

    public void initController(int idArticle) {   
        choic.getItems().addAll("desserts", "boissons", "pizzas");           
        idArticleToEdit = idArticle;  
        if (idArticle != 0) {           
            JSONObject article = RequestServer.getArticlebyid(idArticle);
            nomarticle.setText(article.get("nomarticle").toString());
            prixarticle.setText(article.get("prixarticle").toString());
            if( null != article.get("categoriearticle").toString())switch (article.get("categoriearticle").toString()) {
                    case "boissons":{
                        choic.getSelectionModel().select(1);
                            break;
                        }
                    case "pizzas":{
                        choic.getSelectionModel().select(2);
                            break;
                        }
                    case "desserts":{                   
                        choic.getSelectionModel().select(0);
                            break;
                        }
                    default:
                        break;
                }         
            ok.setText("modifier");
        }
        else {
           ok.setText("ajouter");
        }
    }



    
}
