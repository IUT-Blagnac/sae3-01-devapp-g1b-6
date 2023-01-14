package app.appsae;

import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.*;
import javafx.stage.Stage;
import org.yaml.snakeyaml.Yaml;

import java.io.File;
import java.io.PrintWriter;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;
import java.util.Optional;
import java.util.ResourceBundle;

public class AppConfigController implements Initializable {

    private Stage fenetrePrincipale;
    final private Reader reader= new Reader();

    private Map<String, String> data = reader.chargerYaml();
    @FXML
    private Button boutonValider;
    @FXML
    private Spinner<Integer> maxCO2;
    @FXML
    private Spinner<Integer> minCO2;
    @FXML
    private Spinner<Integer> seuilCO2;
    @FXML
    private Spinner<Integer> freqCO2;
    @FXML
    private Spinner<Integer> maxTemp;
    @FXML
    private Spinner<Integer> minTemp;
    @FXML
    private Spinner<Integer> seuilTemp;
    @FXML
    private Spinner<Integer> freqTemp;
    @FXML
    private Spinner<Integer> maxHum;
    @FXML
    private Spinner<Integer> minHum;
    @FXML
    private Spinner<Integer> seuilHum;
    @FXML
    private Spinner<Integer> freqHum;
    @FXML
    private ChoiceBox<String> capteurCO2;
    @FXML
    private ChoiceBox<String> capteurTemp;
    @FXML
    private ChoiceBox<String> capteurHum;


    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {
        this.setConfig();
    }

    public void actionValider(){
        Map<String, String> map = new HashMap<>();
        map.put("server",data.get("server"));
        map.put("appId",data.get("appId"));
        map.put("deviceId",data.get("deviceId"));
        map.put("tauxMaxCO2",this.maxCO2.getValue().toString());
        map.put("tauxMinCO2",this.minCO2.getValue().toString());
        map.put("seuilCO2",this.seuilCO2.getValue().toString());
        map.put("frequenceCO2",this.freqCO2.getValue().toString());
        map.put("tauxMaxTemp",this.maxTemp.getValue().toString());
        map.put("tauxMinTemp",this.minTemp.getValue().toString());
        map.put("seuilTemp",this.seuilTemp.getValue().toString());
        map.put("frequenceTemp",this.freqTemp.getValue().toString());
        map.put("tauxMaxHum",this.maxHum.getValue().toString());
        map.put("tauxMinHum",this.minHum.getValue().toString());
        map.put("seuilHum",this.seuilHum.getValue().toString());
        map.put("frequenceHum",this.freqHum.getValue().toString());
        map.put("capteurCO2",this.capteurCO2.getValue());
        map.put("capteurTemp",this.capteurTemp.getValue());
        map.put("capteurHum",this.capteurHum.getValue());
        try {
            PrintWriter writer = new PrintWriter(new File("src/main/resources/app/appsae/config.yml"));
            Yaml yaml = new Yaml();
            yaml.dump(map, writer);
            this.setConfig();
            this.actionQuitter();
        }catch (Exception e){
            System.out.println("setConfig : "+e.getMessage());
            System.exit(1);
        }


    }

    public void setConfig(){
        SpinnerValueFactory<Integer> spinnermaxco2= new SpinnerValueFactory.IntegerSpinnerValueFactory(Integer.parseInt(data.get("tauxMinCO2")),5000,Integer.parseInt(data.get("tauxMaxCO2")));
        this.maxCO2.setValueFactory(spinnermaxco2);
        SpinnerValueFactory<Integer> spinnerminco2= new SpinnerValueFactory.IntegerSpinnerValueFactory(0,Integer.parseInt(data.get("tauxMaxCO2")),Integer.parseInt(data.get("tauxMinCO2")));
        this.minCO2.setValueFactory(spinnerminco2);
        SpinnerValueFactory<Integer> spinnerseuilco2= new SpinnerValueFactory.IntegerSpinnerValueFactory(Integer.parseInt(data.get("tauxMinCO2")),Integer.parseInt(data.get("tauxMaxCO2")),Integer.parseInt(data.get("seuilCO2")));
        this.seuilCO2.setValueFactory(spinnerseuilco2);
        SpinnerValueFactory<Integer> spinnerfreqco2= new SpinnerValueFactory.IntegerSpinnerValueFactory(0,Integer.parseInt(data.get("tauxMaxCO2")),Integer.parseInt(data.get("frequenceCO2")));
        this.freqCO2.setValueFactory(spinnerfreqco2);
        this.capteurCO2.getItems().clear();
        this.capteurCO2.getItems().addAll("AM107-7","AM107-3","AM107-9","AM107-4","AM107-2");
        this.capteurCO2.setValue(String.valueOf(data.get("capteurCO2")));

        SpinnerValueFactory<Integer> spinnermaxtemp= new SpinnerValueFactory.IntegerSpinnerValueFactory(Integer.parseInt(data.get("tauxMinTemp")),200,Integer.parseInt(data.get("tauxMaxTemp")));
        this.maxTemp.setValueFactory(spinnermaxtemp);
        SpinnerValueFactory<Integer> spinnermintemp= new SpinnerValueFactory.IntegerSpinnerValueFactory(-50,Integer.parseInt(data.get("tauxMaxTemp")),Integer.parseInt(data.get("tauxMinTemp")));
        this.minTemp.setValueFactory(spinnermintemp);
        SpinnerValueFactory<Integer> spinnerseuiltemp= new SpinnerValueFactory.IntegerSpinnerValueFactory(Integer.parseInt(data.get("tauxMinTemp")),Integer.parseInt(data.get("tauxMaxTemp")),Integer.parseInt(data.get("seuilTemp")));
        this.seuilTemp.setValueFactory(spinnerseuiltemp);
        SpinnerValueFactory<Integer> spinnerfreqtemp= new SpinnerValueFactory.IntegerSpinnerValueFactory(0,Integer.parseInt(data.get("tauxMaxTemp")),Integer.parseInt(data.get("frequenceTemp")));
        this.freqTemp.setValueFactory(spinnerfreqtemp);
        this.capteurTemp.getItems().clear();
        this.capteurTemp.getItems().addAll("AM107-7","AM107-3","AM107-9","AM107-4","AM107-2");
        this.capteurTemp.setValue(String.valueOf(data.get("capteurTemp")));

        SpinnerValueFactory<Integer> spinnermaxhum= new SpinnerValueFactory.IntegerSpinnerValueFactory(Integer.parseInt(data.get("tauxMinHum")),200,Integer.parseInt(data.get("tauxMaxHum")));
        this.maxHum.setValueFactory(spinnermaxhum);
        SpinnerValueFactory<Integer> spinnerminhum= new SpinnerValueFactory.IntegerSpinnerValueFactory(-50,Integer.parseInt(data.get("tauxMaxHum")),Integer.parseInt(data.get("tauxMinHum")));
        this.minHum.setValueFactory(spinnerminhum);
        SpinnerValueFactory<Integer> spinnerseuilhum= new SpinnerValueFactory.IntegerSpinnerValueFactory(Integer.parseInt(data.get("tauxMinHum")),Integer.parseInt(data.get("tauxMaxHum")),Integer.parseInt(data.get("seuilHum")));
        this.seuilHum.setValueFactory(spinnerseuilhum);
        SpinnerValueFactory<Integer> spinnerfreqhum= new SpinnerValueFactory.IntegerSpinnerValueFactory(0,Integer.parseInt(data.get("tauxMaxHum")),Integer.parseInt(data.get("frequenceHum")));
        this.freqHum.setValueFactory(spinnerfreqhum);
        this.capteurHum.getItems().clear();
        this.capteurHum.getItems().addAll("AM107-7","AM107-3","AM107-9","AM107-4","AM107-2");
        this.capteurHum.setValue(String.valueOf(data.get("capteurTemp")));
    }

    public void setFenetrePrincipale(Stage st) {
        this.fenetrePrincipale = st;
        this.fenetrePrincipale.setOnCloseRequest(e -> {e.consume();this.actionQuitter();});
    }

    public void actionQuitter() {
        Alert alert = new Alert(Alert.AlertType.CONFIRMATION);
        alert.setTitle("Fermeture du panneau de configuration");
        alert.setHeaderText("Voulez vous vraiment quitter ?");
        alert.initOwner(fenetrePrincipale);
        alert.getButtonTypes().setAll(ButtonType.YES,ButtonType.NO);
        Optional<ButtonType> response = alert.showAndWait();


        if (response.orElse(null)== ButtonType.YES) {
            this.fenetrePrincipale.close();
        }
    }

    public void actionValidation(){
        Alert alert = new Alert(Alert.AlertType.CONFIRMATION);
        alert.setTitle("Validation des informations");
        alert.setHeaderText("Voulez vous vraiment valider (les informations ce mettront à jour) ?");
        alert.initOwner(fenetrePrincipale);
        alert.getButtonTypes().setAll(ButtonType.YES,ButtonType.NO);
        Optional<ButtonType> response = alert.showAndWait();

        if (response.orElse(null)== ButtonType.YES) {
            this.fenetrePrincipale.close();
        }
    }
}
