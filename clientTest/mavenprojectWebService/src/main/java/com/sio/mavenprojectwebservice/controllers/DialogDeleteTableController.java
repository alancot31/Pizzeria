package com.sio.mavenprojectwebservice.controllers;

import com.sio.mavenprojectwebservice.tools.RequestServer;
import javafx.fxml.FXML;
import javafx.stage.Stage;

public class DialogDeleteTableController {

	private Stage dialogStage;
	private int idTable;
	private ListTableController ctrlList;
			
	@FXML
	private void confirmDeletion() {
            RequestServer.deleteTable(idTable);
            ctrlList.initController();
            dialogStage.close();
        }

	@FXML
	private void closeDialog() {
		dialogStage.close();
	}
	
	public void setDialogStage(Stage dialogStage) {
		this.dialogStage = dialogStage;
	}
	
	public void initController(Stage dialog, int idTable, ListTableController ctrlList) {
		this.dialogStage = dialog;
		this.idTable = idTable;
                System.out.println(idTable);
		this.ctrlList = ctrlList;
	}
}
