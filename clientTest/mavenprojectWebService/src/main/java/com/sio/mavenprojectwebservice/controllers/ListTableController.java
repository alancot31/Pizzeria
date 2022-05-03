package com.sio.mavenprojectwebservice.controllers;

import com.sio.mavenprojectwebservice.App;
import com.sio.mavenprojectwebservice.tools.PageSwitcher;
import com.sio.mavenprojectwebservice.tools.RequestServer;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.geometry.Bounds;
import javafx.geometry.Pos;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.ScrollPane;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.Border;
import javafx.scene.layout.BorderPane;
import javafx.scene.layout.BorderStroke;
import javafx.scene.layout.BorderStrokeStyle;
import javafx.scene.layout.BorderWidths;
import javafx.scene.layout.CornerRadii;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.HBox;
import javafx.scene.layout.VBox;
import javafx.scene.paint.Color;
import javafx.stage.Modality;
import javafx.stage.Stage;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;

public class ListTableController implements Initializable{
    @FXML
    private ScrollPane tabledisponible;
    @FXML
    private ScrollPane tableencours;  
    private Stage dialog;
    private GridPane containerDisponnible;
    private GridPane containerEnCours;
    @FXML
    private void retour(){
        try {
            PageSwitcher.loadFXMLIntoStage("listarticle");

        } catch (IOException ex) {
            java.util.logging.Logger.getLogger(TableEditionControler.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }           
    }
    private void openDialogDelete(int idArticle) {
        try {
            dialog = new Stage();
            dialog.initModality(Modality.APPLICATION_MODAL);
            dialog.initOwner(PageSwitcher.getStage());
            dialog.setResizable(false);
            dialog.setTitle("Supprimer une table");



            FXMLLoader fxmlLoader = new FXMLLoader(App.class.getResource("dialog_delete_1.fxml"));
            Parent dialogFXML =  fxmlLoader.load();

            DialogDeleteTableController ctrl = fxmlLoader.getController();
            ctrl.initController(dialog, idArticle, this);

            Scene dialogScene = new Scene(dialogFXML);
            dialog.setScene(dialogScene);       
            dialog.show();
        } catch (IOException ex) {
            /*Logger.getLogger(ListArticleController.class.getName()).log(Level.SEVERE, null, ex);*/
        }
    }		
    private void switchToEdition(int idtable){
           
        try {
            FXMLLoader loader = PageSwitcher.loadFXMLIntoStage("commande_edition");
            CommandeEditionController ctrl = loader.getController();
            ctrl.initController(idtable);
        } catch (IOException ex) {
            java.util.logging.Logger.getLogger(TableEditionControler.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }          
    }
    @FXML
    private void switchToHistory(){
        try {
        FXMLLoader loader =  PageSwitcher.loadFXMLIntoStage("listhistorique");
         ListHistoriqueController  ctrl = loader.getController();
            ctrl.initController();  
        } catch (IOException ex) {
            java.util.logging.Logger.getLogger(ListArticleController.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }       
    }
    @FXML
    private void switchToCreation(){
        try {
            FXMLLoader loader = PageSwitcher.loadFXMLIntoStage("table_edition");
            TableEditionControler ctrl = loader.getController();
            ctrl.initController(0);
        } catch (IOException ex) {
            java.util.logging.Logger.getLogger(ListTableController.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
    }

    private void switchToCreationM(int idTable){
        try {
            FXMLLoader loader = PageSwitcher.loadFXMLIntoStage("table_edition");
            TableEditionControler ctrl = loader.getController();
            ctrl.initController(idTable);
        } catch (IOException ex) {
            java.util.logging.Logger.getLogger(ListTableController.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
    }
    private void switchToEditionF(int idTable, int idCommande){
           
            try {
                FXMLLoader loader = PageSwitcher.loadFXMLIntoStage("commande_edition");
                CommandeEditionController ctrl = loader.getController();
                ctrl.initControllerF(idTable,idCommande);
             
            } catch (IOException ex) {
                java.util.logging.Logger.getLogger(ListTableController.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
            }         
        }
    public void initController(){
        containerDisponnible = new GridPane();
        containerDisponnible.setPadding(new javafx.geometry.Insets(10));
        containerDisponnible.setHgap(15);
        containerDisponnible.setVgap(10);
        containerDisponnible.setStyle("-fx-background-color: #63D8FF;");
	
        
        tabledisponible.setContent(containerDisponnible);
       
        
        containerEnCours = new GridPane();
        containerEnCours.setPadding(new javafx.geometry.Insets(10));
        containerEnCours.setStyle("-fx-background-color: #63D8FF;");
        containerEnCours.setHgap(15);
        containerEnCours.setVgap(10);
	
        tableencours.setContent(containerEnCours);
    
        
        JSONArray tables = RequestServer.getListTable();
        for(int cpt = 0 ; cpt < tables.size(); cpt++){
            Object obj = tables.get(cpt);
            JSONObject table = (JSONObject)obj;
            if(table.get("isoccuper").equals("0")){
                VBox TableLibreContainer = new VBox(); 
                VBox tableBox = new VBox();
                TableLibreContainer.getChildren().add(tableBox);
                Label nomTable = new Label("Nom : "+ table.get("nomtablerestaurant"));
                Image tableVIDE = new Image(getClass().getResourceAsStream("/images/table_vide.png"));
                ImageView logo = new ImageView();
                logo.setPreserveRatio(true);
                logo.setFitWidth(50);
                logo.setImage(tableVIDE);
                Label ndplace = new Label("Place: "+ table.get("nbpersonne"));
                tableBox.getChildren().add(nomTable);
                tableBox.getChildren().add(logo);
                tableBox.getChildren().add(ndplace);
                TableLibreContainer.setBorder(new Border(new BorderStroke(Color.DARKGREY, BorderStrokeStyle.SOLID,
                                CornerRadii.EMPTY, new BorderWidths(5))));
                containerDisponnible.setAlignment(Pos.CENTER);
                containerDisponnible.add(TableLibreContainer, cpt % 8, cpt / 8); 
                containerDisponnible.setStyle("-fx-background-color: #63D8FF;");
                containerDisponnible.setBorder(new Border(new BorderStroke(Color.DARKGREY, BorderStrokeStyle.SOLID,
                        CornerRadii.EMPTY, new BorderWidths(5))));
                //containers buttons
                HBox containerButtons1 = new HBox();
                containerButtons1.setAlignment(Pos.CENTER);
                containerButtons1.setSpacing(1);
                 HBox containerButtons2 = new HBox();
                containerButtons2.setAlignment(Pos.CENTER);
                containerButtons2.setSpacing(10);
                 HBox containerButtons3 = new HBox();
                containerButtons3.setAlignment(Pos.CENTER);
                containerButtons3.setSpacing(10);
                TableLibreContainer.getChildren().add(containerButtons1);
                TableLibreContainer.getChildren().add(containerButtons2);
                TableLibreContainer.getChildren().add(containerButtons3);
                int idtable =Integer.parseInt(table.get("idtablerestaurant").toString());
                Button editButton = new Button("Commander");
                EventHandler<MouseEvent> eventEdit = new EventHandler<MouseEvent>() {
                    @Override 
                    public void handle(MouseEvent e) {
                        switchToEdition(idtable);
                    }
                };  

                Button modifButton = new Button("Modifier");
                EventHandler<MouseEvent> eventmodif = new EventHandler<MouseEvent>() {
                    @Override 
                    public void handle(MouseEvent e) {

                        switchToCreationM(idtable);

                    }
                };
                Button deleteButton = new Button("supprimer");
                EventHandler<MouseEvent> eventdelete = new EventHandler<MouseEvent>() {
                    @Override 
                    public void handle(MouseEvent e) {

                        openDialogDelete(idtable);

                    }
                }; 
                editButton.addEventHandler(MouseEvent.MOUSE_CLICKED, eventEdit);
                modifButton.addEventHandler(MouseEvent.MOUSE_CLICKED, eventmodif);
                deleteButton.addEventHandler(MouseEvent.MOUSE_CLICKED, eventdelete);
                containerButtons1.getChildren().add(deleteButton);
                containerButtons2.getChildren().add(editButton);
                containerButtons3.getChildren().add(modifButton);
            }else{
                VBox TableOccuperContainer = new VBox(); 
                VBox tableBox = new VBox();
                TableOccuperContainer.getChildren().add(tableBox);
                Label nomTable = new Label("Nom : "+ table.get("nomtablerestaurant"));
                Image tableOQP = new Image(getClass().getResourceAsStream("/images/table_oqp.png"));
                ImageView logooqp = new ImageView();
                logooqp.setPreserveRatio(true);
                logooqp.setFitWidth(50);
                logooqp.setImage(tableOQP);
                Label ndplace = new Label("Place: "+ table.get("nbpersonne"));
                Label idCommande = new Label("IdCommande: "+ table.get("isoccuper"));
                tableBox.getChildren().add(nomTable);
                tableBox.getChildren().add(ndplace);
                tableBox.getChildren().add(logooqp);
                tableBox.getChildren().add(idCommande);
                TableOccuperContainer.setBorder(new Border(new BorderStroke(Color.DARKGREY, BorderStrokeStyle.SOLID,
                                CornerRadii.EMPTY, new BorderWidths(5))));
                containerEnCours.add(TableOccuperContainer, cpt % 8, cpt / 8);
                containerEnCours.setStyle("-fx-background-color: #63D8FF; ");
                containerEnCours.setBorder(new Border(new BorderStroke(Color.DARKGREY, BorderStrokeStyle.SOLID,
                        CornerRadii.EMPTY, new BorderWidths(5))));
                containerEnCours.setAlignment(Pos.CENTER);
                //containers buttons
                HBox containerButtons = new HBox();
                containerButtons.setAlignment(Pos.CENTER);
                containerButtons.setSpacing(10);
                TableOccuperContainer.getChildren().add(containerButtons);
                int idtable =Integer.parseInt(table.get("idtablerestaurant").toString());
                int idCommande1 =Integer.parseInt(table.get("isoccuper").toString());

                Button editButton = new Button("Finaliser");
                EventHandler<MouseEvent> eventEdit = new EventHandler<MouseEvent>() {
                    @Override 
                    public void handle(MouseEvent e) {
                        switchToEditionF(idtable,idCommande1);
                    }
                };   
                editButton.addEventHandler(MouseEvent.MOUSE_CLICKED, eventEdit);
                containerButtons.getChildren().add(editButton);
            }      
        }                  

}

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        initController();
    }


}