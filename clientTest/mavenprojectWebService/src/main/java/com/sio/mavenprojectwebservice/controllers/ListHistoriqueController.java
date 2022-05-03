package com.sio.mavenprojectwebservice.controllers;


import com.sio.mavenprojectwebservice.tools.PageSwitcher;
import com.sio.mavenprojectwebservice.tools.RequestToHistory;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Label;
import javafx.scene.control.ScrollPane;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.VBox;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;

public class ListHistoriqueController implements Initializable{

    @FXML
    private ScrollPane historyscroller;
    @FXML
    private Label historysolde;
    
    public float prixtotal;


    
    @FXML
    private void retour(){
        try {
            PageSwitcher.loadFXMLIntoStage("listarticle");
        }
        catch (IOException ex) {
            java.util.logging.Logger.getLogger(ListArticleController.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }

    }
    @FXML
    private void listetable(){
        try {
            PageSwitcher.loadFXMLIntoStage("listetable");
        }
        catch (IOException ex) {
            java.util.logging.Logger.getLogger(ListArticleController.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }

    }

    public void initController(){

        GridPane containerhisto= new GridPane();
        containerhisto.setPadding(new javafx.geometry.Insets(10));
        containerhisto.setHgap(15);
        containerhisto.setVgap(10);

        JSONArray listcommande = RequestToHistory.getListHistorique();
        
        for(int i = 0;i<listcommande.size();i++){
            
            JSONObject commande = (JSONObject) listcommande.get(i);
            VBox conteneurcommande = new VBox();
            Label idcommande=new Label("id commande n°: "+String.valueOf(commande.get("idcommande")));
            conteneurcommande.getChildren().add(idcommande);
            Label labeldate=new Label("date de: "+commande.get("date"));
            conteneurcommande.getChildren().add(labeldate);
            Label elements=new Label("articles: "+commande.get("elementcommande"));
            conteneurcommande.getChildren().add(elements);
            Label prix=new Label("somme commande: "+String.valueOf(commande.get("prix")));
            float prixt = Float.parseFloat(commande.get("prix").toString());
            prixtotal= (float) (prixt +  prixtotal);
            conteneurcommande.getChildren().add(prix);
            Label vide=new Label();
            conteneurcommande.getChildren().add(vide);
            containerhisto.add(conteneurcommande, i % 4,i / 4);
        }

        historyscroller.setContent(containerhisto);  
        
        historysolde.setText(String.valueOf(prixtotal));
    }
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        initController();

    }
}
