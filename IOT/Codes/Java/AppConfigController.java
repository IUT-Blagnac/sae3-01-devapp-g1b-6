package app.appsae;

import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;

import java.net.URL;
import java.util.HashMap;
import java.util.ResourceBundle;

public class AppConfigController implements Initializable {

    @FXML
    private Button boutonValider;
    @FXML
    private TextField maxCO2;
    @FXML
    private TextField minCO2;
    @FXML
    private TextField seuilCO2;
    @FXML
    private TextField freqCO2;
    @FXML
    private TextField maxTemp;
    @FXML
    private TextField minTemp;
    @FXML
    private TextField seuilTemp;
    @FXML
    private TextField freqTemp;
    @FXML
    private TextField maxHum;
    @FXML
    private TextField minHum;
    @FXML
    private TextField seuilHum;
    @FXML
    private TextField freqHum;



    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {
        Reader reader = new Reader();
        HashMap<String, String> donneeConfig = reader.readerYML("config.yml");
        System.out.println(donneeConfig.get("tauxMaxCO2"));
        //this.maxCO2.textProperty().set(donneeConfig.get("tauxMaxCO2"));
    }

    public void actionValider(){

    }
}
