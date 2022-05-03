
package com.sio.mavenprojectwebservice.controllers;

import com.sio.mavenprojectwebservice.tools.PageSwitcher;
import com.sio.mavenprojectwebservice.tools.RequestServer;
import java.io.IOException;
import java.net.URL;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.ResourceBundle;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.geometry.Pos;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.ScrollPane;
import javafx.scene.control.Spinner;
import javafx.scene.control.SpinnerValueFactory;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.HBox;
import javafx.scene.layout.VBox;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;

public class CommandeEditionController implements Initializable {
    @FXML
    private ScrollPane boissons;
    @FXML
    private ScrollPane pizzas;
    @FXML
    private ScrollPane desserts;
     @FXML
    private ScrollPane commande;
     @FXML
    private Label somme;
     @FXML
    private Label erreur;
    private GridPane containerBoissons;
    private GridPane containerDesserts;
    private GridPane containerPizza;
    private GridPane containerCommande;
    public  ArrayList<JSONObject> ol = new ArrayList<JSONObject>();
    public  int idTable ;
    public  int idCommande ;
    public float  sommep ;
    
    
     public void sommeprix(float idarticle, String op){
         JSONObject article = RequestServer.getArticlebyid((int) idarticle);
         String prixarticle = (String) article.get("prixarticle");
         float prix= Float.parseFloat(prixarticle); 
         switch(op){
            case "+":
                sommep+=prix;
                somme.setText("somme :"+sommep+" Euro.");   
                break; 
            case"-":
                sommep-=prix;
                somme.setText("somme :"+sommep+" Euro.");   
                break;
         }            
     } 
     private Integer parseToNumber(String receivedParam)
    {
        if (receivedParam != null && !receivedParam.trim().isEmpty())
        {
            try
            {
                return Integer.parseInt(receivedParam.trim());
            }
            catch (NumberFormatException nfe)
            {
                System.out.println("received param is not a number");
                return null;
            }
        }
        else
        {
            System.out.println("received param is null or empty");
            return null;
        }
    }
     
     
    @FXML  
    public void inserthistory(){
        implemente();
        JSONObject commande = RequestServer.getCommandebyid(idCommande);
        JSONArray list = (JSONArray) commande.get("listarticle");
        StringBuilder elementcommander =new StringBuilder();
        for(int i =0 ;i< list.size();i++){       
            JSONObject article = (JSONObject) list.get(i);
            int id =parseToNumber(article.get("idarticle").toString());
            JSONObject art = RequestServer.getArticlebyid(id);
            String qte = (String) article.get("quantiter");
            elementcommander.append(art.get("nomarticle")).append("-").append(qte).append("/");
        }
        commande.remove("listarticle");
        commande.remove("idtablerestaurants");
        commande.put("elementcommande", elementcommander.toString());
        commande.put("prix", commande.get("sommecommande").toString());
        commande.remove("sommecommande");
        RequestServer.postHistory(commande);
        JSONObject tableRestaurant = RequestServer.getTablebyid(idTable);
        tableRestaurant.put("isoccuper", "0");
        RequestServer.updateTable(tableRestaurant);
        try {
             PageSwitcher.loadFXMLIntoStage("listetable");

         } catch (IOException ex) {
             java.util.logging.Logger.getLogger(ListArticleController.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
         }    
    }    
    @FXML  
    public void inserthistoryimpayer(){
        implemente();
        JSONObject commande = RequestServer.getCommandebyid(idCommande);
        JSONArray list = (JSONArray) commande.get("listarticle");
        StringBuilder elementcommander =new StringBuilder();
        for(int i =0 ;i< list.size();i++){
            
            JSONObject article = (JSONObject) list.get(i);
            int id =parseToNumber(article.get("idarticle").toString());
            JSONObject art = RequestServer.getArticlebyid(id);
            String qte = (String) article.get("quantiter");
            elementcommander.append(art.get("nomarticle")).append("-").append(qte).append("/");
        }
        commande.remove("listarticle");
        commande.remove("idtablerestaurants");
        commande.put("elementcommande", elementcommander.toString());
        commande.put("prix", "0");
        commande.remove("sommecommande");
        RequestServer.postHistory(commande);
        JSONObject tableRestaurant = RequestServer.getTablebyid(idTable);
        tableRestaurant.put("isoccuper", "0");
        RequestServer.updateTable(tableRestaurant);
        try {
             PageSwitcher.loadFXMLIntoStage("listetable");

         } catch (IOException ex) {
             java.util.logging.Logger.getLogger(ListArticleController.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
         }
    }
    
    
    @FXML
    public void implemente(){
        if (!ol.isEmpty()){
            System.out.println(ol);
            List<JSONObject> listdeselements = new ArrayList<JSONObject>() ;
            for(int i = 0 ; i<ol.size();i++ ){
                JSONObject art = ol.get(i);
                JSONObject res = new JSONObject();
                res.put("idarticle", art.get("idarticle"));
                res.put("quantiter", art.get("quantiter"));              
                listdeselements.add(res);
            }         
            Date date = Calendar.getInstance().getTime();
            DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd hh-mm-ss");
            String strDate = dateFormat.format(date);  
            String dater = strDate;
            JSONObject obj = new JSONObject();
            String somme = Float.toString(sommep);
            String idt=String.valueOf(idTable);
            obj.put("sommecommande", somme);
            obj.put("idtablerestaurants",idt);            
            obj.put("listarticle", listdeselements);           
            obj.put("date", dater);        
            JSONObject table = RequestServer.getTablebyid(idTable);
            if (table.get("isoccuper").equals("0")){               
                RequestServer.postCommande(obj);
                JSONArray listcommande = RequestServer.getListCommande();
                JSONObject commande = (JSONObject) listcommande.get(listcommande.size()-1);
                int id = parseToNumber(commande.get("idcommande").toString());
                String idc =String.valueOf(id);
                table.put("isoccuper",idc);
                RequestServer.updateTable(table);
            }else{
                String idca =String.valueOf(idCommande);           
                obj.put("idcommande", idca);
                RequestServer.updateCommande(obj);
            }          
            try {
                PageSwitcher.loadFXMLIntoStage("listetable");            
            } catch (IOException ex) {
                java.util.logging.Logger.getLogger(ListArticleController.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
            }
        }else{
            erreur.setText("Ajouter un produit a la commande.");
        }          
    }   
    @FXML
    public void retour(){
       try {
                PageSwitcher.loadFXMLIntoStage("listetable");
            
            } catch (IOException ex) {
                java.util.logging.Logger.getLogger(ListArticleController.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
            }
    }   
    int posX = 0 ;
    int posY = 0 ; 
    public void commander(JSONObject article  ){  
            article.put("quantiter", 1 );
            ol.add(article);  
            containerCommande = new GridPane();
            containerCommande.setPadding(new javafx.geometry.Insets(10));
            containerCommande.setHgap(15);
            containerCommande.setVgap(10);
            commande.setContent(containerCommande);
            sommeprix( Float.parseFloat(article.get("idarticle").toString()),"+");           
            for (int i = 0 ; i<ol.size();i++){              
                JSONObject art = ol.get(i);            
                VBox articleContainer =new VBox();
                articleContainer.setId(art.get("idarticle").toString());
                VBox articlebox =new VBox();
                articleContainer.getChildren().add(articlebox);
                Label nomArticle = new Label(" Nom : "+art.get("nomarticle").toString());
                Label prixArticle = new Label(" Prix : "+art.get("prixarticle").toString());
                Spinner<Integer>  quantiter = new Spinner<Integer>();
                SpinnerValueFactory value = new SpinnerValueFactory.IntegerSpinnerValueFactory(0, 1000);
		quantiter.setValueFactory(value);
                int qtee = Integer.parseInt(art.get("quantiter").toString());
                if (qtee ==1){
                    quantiter.getValueFactory().setValue(1);
                } else {     
                    quantiter.getValueFactory().setValue(qtee);
                }          
                EventHandler<MouseEvent> eh = new EventHandler<MouseEvent>() {
                @Override 
                public void handle(MouseEvent eh) {
                    if (quantiter.getValueFactory().getValue() > parseToNumber(art.get("quantiter").toString()) ){
                    sommeprix(Float.parseFloat(art.get("idarticle").toString()),"+");
                     ol.remove(art);
                    art.put("quantiter", quantiter.getValueFactory().getValue());
                    ol.add(art);
                    }
                    else if (quantiter.getValueFactory().getValue() == 0){ 
                        ol.remove(art);
                        sommeprix(Float.parseFloat(art.get("idarticle").toString()),"-");         
                        articleinit();
                    }
                    else{
                        ol.remove(art);
                        sommeprix(Float.parseFloat(art.get("idarticle").toString()),"-");
                        art.put("quantiter", quantiter.getValueFactory().getValue());
                        ol.add(art);                     
                    }
                    }
                };
                quantiter.addEventHandler(MouseEvent.MOUSE_CLICKED, eh);
                articlebox.getChildren().add(quantiter);
                articlebox.getChildren().add(nomArticle);
                articlebox.getChildren().add(prixArticle);
                containerCommande.add(articleContainer,i % 7,i/7 ,1,1);
                containerCommande.setStyle("-fx-background-color: #63D8FF;");
            }      
    }  
     public void initControllerF(int idTabled,int idcommande) {
        idTable = idTabled;
        idCommande = idcommande;
        containerCommande = new GridPane();
        containerCommande.setPadding(new javafx.geometry.Insets(10));
        containerCommande.setHgap(15);
        containerCommande.setVgap(10);
        commande.setContent(containerCommande);  
        JSONObject list = RequestServer.getCommandebyid(idcommande);
        JSONArray table = (JSONArray) list.get("listarticle");        
        for(int i =0; i < table.size();i++){          
            JSONObject art = (JSONObject) table.get(i);
            int id = Integer.parseInt((String) art.get("idarticle"));
            JSONObject article = RequestServer.getArticlebyid(id);
            article.put("quantiter", art.get("quantiter"));
            ol.add(article);
            VBox articleContainer =new VBox();
            articleContainer.setId(art.get("idarticle").toString());
            VBox articlebox =new VBox();
            articleContainer.getChildren().add(articlebox);
            Spinner<Integer>  quantiter = new Spinner<Integer>();
            SpinnerValueFactory value = new SpinnerValueFactory.IntegerSpinnerValueFactory(0, 1000);
            quantiter.setValueFactory(value);
              EventHandler<MouseEvent> eh = new EventHandler<MouseEvent>() {
                @Override 
                 public void handle(MouseEvent eh) {
                    if (quantiter.getValueFactory().getValue() > parseToNumber(article.get("quantiter").toString()) ){
                    sommeprix(Float.parseFloat(article.get("idarticle").toString()),"+");              
                    ol.remove(article);
                    article.put("quantiter", quantiter.getValueFactory().getValue());  
                    ol.add(article);
                    }
                    else if (quantiter.getValueFactory().getValue() == 0){
                        ol.remove(article);                        
                        sommeprix(Float.parseFloat(article.get("idarticle").toString()),"-"); 
                        articleinit();                       
                    }
                    else{
                        sommeprix(Float.parseFloat(article.get("idarticle").toString()),"-");
                        ol.remove(article);
                        article.put("quantiter", quantiter.getValueFactory().getValue());
                        ol.add(article);
                    }
                    }                
                };  
            quantiter.addEventHandler(MouseEvent.MOUSE_CLICKED, eh);
            int qtee = parseToNumber(art.get("quantiter").toString());
            if (qtee ==1){
                quantiter.getValueFactory().setValue(1);
                sommeprix(Float.parseFloat(article.get("idarticle").toString()),"+");
            } else {     
                quantiter.getValueFactory().setValue(qtee);
                for(int a = 0  ;a <qtee;a++){
                    sommeprix(Float.parseFloat(article.get("idarticle").toString()),"+");
                }
            }
            Label nomArticle = new Label(" Nom : "+article.get("nomarticle").toString());
            Label prixArticle = new Label(" Prix : "+article.get("prixarticle").toString());
            articlebox.getChildren().add(quantiter);
            articlebox.getChildren().add(nomArticle);
            articlebox.getChildren().add(prixArticle);           
            containerCommande.add(articleContainer,i % 7,i/7 ,1,1);
            containerCommande.setStyle("-fx-background-color: #63D8FF;");
            articleinit();    
        }
    }
    public void initController(int idTabled) {
     idTable = idTabled;   
    }
    public void articleinit(){
        containerBoissons = new GridPane();
        containerBoissons.setPadding(new javafx.geometry.Insets(10));
        containerBoissons.setHgap(15);
        containerBoissons.setVgap(10);
        boissons.setContent(containerBoissons);
        containerDesserts = new GridPane();
        containerDesserts.setPadding(new javafx.geometry.Insets(10));
        containerDesserts.setHgap(15);
        containerDesserts.setVgap(10);
        desserts.setContent(containerDesserts);
        containerPizza = new GridPane();
        containerPizza.setPadding(new javafx.geometry.Insets(10));
        containerPizza.setHgap(15);
        containerPizza.setVgap(10);
        pizzas.setContent(containerPizza);            
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
            //container buttons
            HBox containerButtons = new HBox();
            containerButtons.setAlignment(Pos.CENTER);
            containerButtons.setSpacing(10);
            articleContainer.getChildren().add(containerButtons);
            Button ajoutButton = new Button("ajouter");
            EventHandler<MouseEvent> eventajout = new EventHandler<MouseEvent>() {
                @Override 
                public void handle(MouseEvent e) {
                    if(ol.isEmpty()){
                        commander(article);
                    }else{        
                        System.out.println(ol);
                        int idart =parseToNumber(article.get("idarticle").toString());
                        boolean deja = false;
                        for(int i = 0 ; i < ol.size() ;i++){
                            JSONObject art = ol.get(i);
                            int id = parseToNumber(art.get("idarticle").toString());
                            if (id == idart){
                                   erreur.setText("article deja dans commande.");
                                   deja = true;
                            }                          
                        }if (deja != true){                          
                                erreur.setText("");
                                commander(article);                        
                        }
                    }                   
                }
            };  
            ajoutButton.addEventHandler(MouseEvent.MOUSE_CLICKED, eventajout);       
            containerButtons.getChildren().add(ajoutButton);
            if( null != article.get("categoriearticle").toString())switch (article.get("categoriearticle").toString()) {
                    case "boissons":{
                        int posX = cptb % 3;
                        int posY = cptb / 3;
                        Image boisson = new Image(getClass().getResourceAsStream("/images/boisson.jpg"));
                        ImageView logo = new ImageView();
                        logo.setPreserveRatio(true);
                        logo.setFitWidth(50);
                        logo.setImage(boisson);
                        articlebox.getChildren().add(logo);
                        articlebox.setStyle("-fx-background-color: #63D8FF;");
                        containerBoissons.add(articleContainer, posX, posY,1,1);
                        cptb++;
                        break;
                        }
                    case "pizzas":{
                        int posX = cptp % 3;
                        int posY = cptp / 3;
                        Image pizza = new Image(getClass().getResourceAsStream("/images/pizza.jpg"));
                        ImageView logo = new ImageView();
                        logo.setPreserveRatio(true);
                        logo.setFitWidth(50);
                        logo.setImage(pizza);
                        articlebox.getChildren().add(logo);
                        articlebox.setStyle("-fx-background-color: #63D8FF;");
                        containerPizza.add(articleContainer, posX, posY,1,1);
                        cptp++;
                        break;
                        }
                    case "desserts":{                   
                        int posX = cptd % 3;
                        int posY = cptd / 3;
                        Image dessert = new Image(getClass().getResourceAsStream("/images/dessert.png"));
                        ImageView logo = new ImageView();
                        logo.setPreserveRatio(true);
                        logo.setFitWidth(50);
                        logo.setImage(dessert);
                        articlebox.getChildren().add(logo);
                        articlebox.setStyle("-fx-background-color: #63D8FF;");
                        containerDesserts.add(articleContainer, posX, posY,1,1);
                        cptd++;
                        break;
                        }
                    default:
                        break;
                }  
        }
        if (ol.isEmpty()){
            for (int i = 0 ; i<ol.size();i++){              
                JSONObject art = ol.get(i);            
                VBox articleContainer =new VBox();
                articleContainer.setId(art.get("idarticle").toString());
                VBox articlebox =new VBox();
                articleContainer.getChildren().add(articlebox);
                Label nomArticle = new Label(" Nom : "+art.get("nomarticle").toString());
                Label prixArticle = new Label(" Prix : "+art.get("prixarticle").toString());
                Spinner<Integer>  quantiter = new Spinner<Integer>();
                SpinnerValueFactory value = new SpinnerValueFactory.IntegerSpinnerValueFactory(0, 1000);
		quantiter.setValueFactory(value);
                int qtee = Integer.parseInt(art.get("quantiter").toString());
                if (qtee ==1){
                    quantiter.getValueFactory().setValue(1);
                } else {     
                    quantiter.getValueFactory().setValue(qtee);
                }          
              EventHandler<MouseEvent> eh = new EventHandler<MouseEvent>() {
                @Override 
                 public void handle(MouseEvent eh) {
                    if (quantiter.getValueFactory().getValue() > parseToNumber(art.get("quantiter").toString()) ){
                        sommeprix(Float.parseFloat(art.get("idarticle").toString()),"+");  
                        ol.remove(art);                    
                        art.put("quantiter", quantiter.getValueFactory().getValue());
                    }
                    else if (quantiter.getValueFactory().getValue() == 0){
                        ol.remove(art); 
                        sommeprix(Float.parseFloat(art.get("idarticle").toString()),"-");    
                        articleinit();
                    }
                    else{
                        sommeprix(Float.parseFloat(art.get("idarticle").toString()),"-");
                        ol.remove(art);
                        art.put("quantiter", quantiter.getValueFactory().getValue());                       
                    }
                    }
                };  
                quantiter.addEventHandler(MouseEvent.MOUSE_CLICKED, eh);
                articlebox.getChildren().add(quantiter);
                articlebox.getChildren().add(nomArticle);
                articlebox.getChildren().add(prixArticle);
                containerCommande.add(articleContainer,i % 7,i/7 ,1,1);                                
            }    
        }
    }
    @Override
    public void initialize(URL url, ResourceBundle rb) {
       articleinit();
    }


}
