package com.sio.mavenprojectwebservice.controllers;

import com.sio.mavenprojectwebservice.tools.RequestServer;
import javafx.fxml.FXML;
import javafx.stage.Stage;

public class DialogDeleteController {

	private Stage dialogStage;
	private int idArticle;
	private ListArticleController ctrlList;
			
	@FXML
	private void confirmDeletion() {
            RequestServer.deleteArticle(idArticle);
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
	
	public void initController(Stage dialog, int idArticle, ListArticleController ctrlList) {
		this.dialogStage = dialog;
		this.idArticle = idArticle;
		this.ctrlList = ctrlList;
	}
}
