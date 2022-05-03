package com.sio.mavenprojectwebservice;

import com.sio.mavenprojectwebservice.tools.PageSwitcher;
import javafx.application.Application;
import javafx.stage.Stage;

import java.io.IOException;
import javafx.scene.image.Image;

public class App extends Application {

    @Override
    public void start(Stage stage) throws IOException {
        Image applicationIcon = new Image(getClass().getResourceAsStream("/images/icone.jpg"));
        stage.getIcons().add(applicationIcon);
            stage.setResizable(false);
            stage.setTitle("Articles");
            PageSwitcher.setCurrentStage(stage);
            PageSwitcher.loadFXMLIntoStage("listarticle");
            stage.show();        
    }
    public static void main(String[] args) {
        launch();
    }

}