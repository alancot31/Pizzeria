
package com.sio.mavenprojectwebservice.tools;

import com.sio.mavenprojectwebservice.App;
import java.io.IOException;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.stage.Stage;


public class PageSwitcher {
	
	private static Stage currentStage;
	
	public static void setCurrentStage(Stage stage) {
		currentStage = stage;
	}

	public static Stage getCurrentStage() {
		return currentStage;
	}
	
	public static FXMLLoader loadFXMLIntoStage(String fxml) throws IOException {
		
		FXMLLoader fxmlLoader = new FXMLLoader(App.class.getResource( fxml + ".fxml"));
                Parent fxmlParent = fxmlLoader.load();
		
		if (currentStage != null) {
			Scene currentScene = currentStage.getScene();
			
			if (currentScene == null) {
				currentScene = new Scene(fxmlParent);
				currentStage.setScene(currentScene);
			}
			else {
				currentScene.setRoot(fxmlParent);
			}
			
			currentStage.sizeToScene();
			currentStage.centerOnScreen();
		}
		
		return fxmlLoader;
    }
	
	public static Stage getStage() {
		return currentStage;
	}
}
