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

public class ListArticleController implements Initializable{
        @FXML
        private ScrollPane scrollb;
        @FXML
        private ScrollPane scrollp;
        @FXML
        private ScrollPane scrolld;
        
	private Stage dialog;
	
	private GridPane containerBoissons;
        private GridPane containerDesserts;
        private GridPane containerPizza;
        
            @FXML
            private void switchToCreation(){         
                try {
                    FXMLLoader loader = PageSwitcher.loadFXMLIntoStage("article_edition");
                    ArticleEditionController ctrl = loader.getController();
                    ctrl.initController(0);
                } catch (IOException ex) {
                    java.util.logging.Logger.getLogger(ListArticleController.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
                }         
            }
            @FXML
            private void switchToHistory(){
                try {
                    PageSwitcher.loadFXMLIntoStage("listhistorique");

                } catch (IOException ex) {
                    java.util.logging.Logger.getLogger(ListArticleController.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
                }       
            }
            @FXML
            private void switchToTable(){         
                try {
                    PageSwitcher.loadFXMLIntoStage("listetable");

                } catch (IOException ex) {
                    java.util.logging.Logger.getLogger(ListArticleController.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
                }         
            }
            private void switchToEdition(int idArticle){          
                try {
                    FXMLLoader loader = PageSwitcher.loadFXMLIntoStage("article_edition");
                    ArticleEditionController ctrl = loader.getController();
                    ctrl.initController(idArticle);
                    System.out.println(idArticle);
                } catch (IOException ex) {
                    java.util.logging.Logger.getLogger(ListArticleController.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
                }         
            }
            private void openDialogDelete(int idArticle) {
                 try {
                     dialog = new Stage();
                     dialog.initModality(Modality.APPLICATION_MODAL);
                     dialog.initOwner(PageSwitcher.getStage());
                     dialog.setResizable(false);
                     dialog.setTitle("Supprimer un article");
                     FXMLLoader fxmlLoader = new FXMLLoader(App.class.getResource("dialog_delete.fxml"));
                     Parent dialogFXML =  fxmlLoader.load();
                     DialogDeleteController ctrl = fxmlLoader.getController();
                     ctrl.initController(dialog, idArticle, this);
                     Scene dialogScene = new Scene(dialogFXML);
                     dialog.setScene(dialogScene);       
                     dialog.show();
                 } catch (IOException ex) {
                     /*Logger.getLogger(ListArticleController.class.getName()).log(Level.SEVERE, null, ex);*/
                 }
             }		
        public void initController(){
            	containerBoissons = new GridPane();
		containerBoissons.setPadding(new javafx.geometry.Insets(10));
		containerBoissons.setHgap(15);
		containerBoissons.setVgap(10);			
		scrollb.setContent(containerBoissons);          
                containerDesserts = new GridPane();
		containerDesserts.setPadding(new javafx.geometry.Insets(10));
		containerDesserts.setHgap(15);
		containerDesserts.setVgap(10);		
                scrolld.setContent(containerDesserts);
                containerPizza = new GridPane();
		containerPizza.setPadding(new javafx.geometry.Insets(10));
		containerPizza.setHgap(15);
		containerPizza.setVgap(10);             
                scrollp.setContent(containerPizza);
                JSONArray list = RequestServer.getListArticle();
                int cptp=0;
                int cptb=0;
                int cptd=0;
                for(int cpt = 0 ; cpt < list.size() ; cpt++){                   
                    Object obj = list.get(cpt);
                    JSONObject article = (JSONObject) obj;                  
                    VBox articleContainer =new VBox();
                    articleContainer.setId(article.get("idarticle").toString());                   
                    VBox articlebox =new VBox();
                    articleContainer.getChildren().add(articlebox);                   
                    Label nomArticle = new Label(" Nom : "+article.get("nomarticle").toString());
                    Label prixArticle = new Label(" Prix : "+article.get("prixarticle").toString());
                    articlebox.getChildren().add(nomArticle);
                    articlebox.getChildren().add(prixArticle);                                      
                    // container boutons
                    HBox containerButtons = new HBox();
                    containerButtons.setAlignment(Pos.CENTER);
                    containerButtons.setSpacing(10);
                    articleContainer.getChildren().add(containerButtons);
                    int idArticle =Integer.parseInt(article.get("idarticle").toString());
                    Button editButton = new Button("modifier");
                    EventHandler<MouseEvent> eventEdit = new EventHandler<MouseEvent>() {
                        @Override 
                        public void handle(MouseEvent e) {
                            switchToEdition(idArticle);
                        }
                    };  
                    editButton.addEventHandler(MouseEvent.MOUSE_CLICKED, eventEdit);
                    containerButtons.getChildren().add(editButton);
                    Button deleteButton = new Button("supprimer");
                    EventHandler<MouseEvent> eventDelete = new EventHandler<MouseEvent>() {
                        @Override 
                        public void handle(MouseEvent e) {
                            openDialogDelete(idArticle);
                        }
                    };  
                    deleteButton.addEventHandler(MouseEvent.MOUSE_CLICKED, eventDelete);
                    containerButtons.getChildren().add(deleteButton);                  
                    if( null != article.get("categoriearticle").toString())switch (article.get("categoriearticle").toString()) {
                            case "boissons":{
                                Image boisson = new Image(getClass().getResourceAsStream("/images/boisson.jpg"));
                                ImageView logo = new ImageView();
                                logo.setPreserveRatio(true);
                                logo.setFitWidth(50);
                                logo.setImage(boisson);
                                articlebox.setBorder(new Border(new BorderStroke(Color.DARKGREY, BorderStrokeStyle.SOLID,
                                CornerRadii.EMPTY, new BorderWidths(5))));
                                articlebox.getChildren().add(logo);
                                int posX = cptb % 7;
                                int posY = cptb / 7;
                                containerBoissons.add(articleContainer, posX, posY,1,1);
                                containerBoissons.setStyle("-fx-background-color: #63D8FF;");
                                containerBoissons.setBorder(new Border(new BorderStroke(Color.DARKGREY, BorderStrokeStyle.SOLID,
                                CornerRadii.EMPTY, new BorderWidths(5))));
                                cptb++;
                                    break;
                                }
                            case "pizzas":{
                                Image pizza = new Image(getClass().getResourceAsStream("/images/pizza.jpg"));
                                ImageView logo = new ImageView();
                                logo.setPreserveRatio(true);
                                logo.setFitWidth(50);
                                logo.setImage(pizza);
                                articlebox.setBorder(new Border(new BorderStroke(Color.DARKGREY, BorderStrokeStyle.SOLID,
                                CornerRadii.EMPTY, new BorderWidths(5))));
                                articlebox.getChildren().add(logo);                   
                                int posX = cptp % 7;
                                int posY = cptp / 7;
                                containerPizza.add(articleContainer, posX, posY,1,1);
                                containerPizza.setStyle("-fx-background-color: #63D8FF;");
                                containerPizza.setBorder(new Border(new BorderStroke(Color.DARKGREY, BorderStrokeStyle.SOLID,
                                CornerRadii.EMPTY, new BorderWidths(5))));
                                cptp++;
                                    break;
                                }
                            case "desserts":{    
                                Image dessert = new Image(getClass().getResourceAsStream("/images/dessert.png"));
                                ImageView logo = new ImageView();
                                logo.setPreserveRatio(true);
                                logo.setFitWidth(50);
                                logo.setImage(dessert);
                                articlebox.setBorder(new Border(new BorderStroke(Color.DARKGREY, BorderStrokeStyle.SOLID,
                                CornerRadii.EMPTY, new BorderWidths(5))));
                                articlebox.getChildren().add(logo);
                                int posX = cptd % 7;
                                int posY = cptd / 7;
                                containerDesserts.add(articleContainer, posX, posY,1,1);
                                containerDesserts.setStyle("-fx-background-color: #63D8FF;");
                                containerDesserts.setBorder(new Border(new BorderStroke(Color.DARKGREY, BorderStrokeStyle.SOLID,
                                CornerRadii.EMPTY, new BorderWidths(5))));
                                cptd++;
                                    break;
                                }
                            default:
                                break;
                        }                   
                }
        }
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        initController();
    }	
}
