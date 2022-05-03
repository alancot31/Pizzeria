module com.sio.mavenprojectwebservice {
    requires javafx.controls;
    requires javafx.fxml;
    requires java.logging;

    opens com.sio.mavenprojectwebservice to javafx.fxml;
    opens com.sio.mavenprojectwebservice.controllers to javafx.fxml;
    exports com.sio.mavenprojectwebservice;
    requires jakarta.ws.rs;
   
    requires json.simple;
}
