package com.sio.mavenprojectwebservice.controllers;

import com.sio.mavenprojectwebservice.tools.PageSwitcher;
import com.sio.mavenprojectwebservice.tools.RequestServer;
import java.io.IOException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;
import org.json.simple.JSONObject;

public class TableEditionControler {
    
    @FXML
    private TextField nomTable;
    @FXML
    private TextField nombrePersonnes;
    @FXML
    private Button ok;
    @FXML
    private Button deletetable;
    
    private int idTableToEdit =0;
    
    @FXML
    private void retour(){
    try {
            FXMLLoader loader = PageSwitcher.loadFXMLIntoStage("listetable");
            ListTableController ctrl =loader.getController();
            ctrl.initController();
            PageSwitcher.loadFXMLIntoStage("listetable");
        } catch (IOException ex) {
            Logger.getLogger(TableEditionControler.class.getName()).log(Level.SEVERE, null, ex);
        }
        }
    @FXML
    private void switchToList() {
        try {
            FXMLLoader loader = PageSwitcher.loadFXMLIntoStage("listetable");
            ListTableController ctrl =loader.getController();
            ctrl.initController();
            PageSwitcher.loadFXMLIntoStage("listetable");
        } catch (IOException ex) {
            Logger.getLogger(TableEditionControler.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    @FXML
    private void saveChanges(){
        if(idTableToEdit == 0){
            System.out.println("hello");
            JSONObject obj = new JSONObject();
            obj.put("nomtablerestaurant", nomTable.getText());
            obj.put("nbpersonne", nombrePersonnes.getText());
            obj.put("isoccuper", "0");
            System.out.println(obj);
            RequestServer.postTable(obj); 
        }
        else{
            System.out.println("hello");
            JSONObject obj = new JSONObject();
            obj.put("idtablerestaurant", idTableToEdit);         
            obj.put("nomtablerestaurant", nomTable.getText());
            obj.put("nbpersonne", nombrePersonnes.getText());
            obj.put("isoccuper", "0");
            
            
            RequestServer.updateTable(obj);  
        }
        switchToList();
    }

    public void initController(int idTable) {
        idTableToEdit = idTable;  
        if (idTable != 0) {
            JSONObject table = RequestServer.getTablebyid(idTable);
            nomTable.setText(table.get("nomtablerestaurant").toString());
            nombrePersonnes.setText(table.get("nbpersonne").toString());
            ok.setText("modifier");
        }
        else {
           ok.setText("ajouter");
        }
    }
}
