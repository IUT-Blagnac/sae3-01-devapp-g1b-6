package app.appsae;

import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.chart.*;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.ButtonType;
import javafx.stage.Stage;
import java.net.URL;
import java.util.Map;
import java.util.Optional;
import java.util.ResourceBundle;

public class AppSAEController implements Initializable {

    private Stage fenetrePrincipale;
    final private Reader reader = new Reader();
    final private Map<String, String> data = reader.chargerYaml();
    final private Map<String,String> donneeco2 = reader.readerTXT("src/main/resources/app/appsae/co2.txt");
    final private Map<String,String> donneetemp = reader.readerTXT("src/main/resources/app/appsae/temp.txt");
    final private Map<String,String> donneehum = reader.readerTXT("src/main/resources/app/appsae/hum.txt");
    private XYChart.Series<String,Number> srco2;
    private XYChart.Series<String,Number> srco2alert;
    @FXML
    private Button boutonQuitter;
    @FXML
    private Button boutonConfig;
    @FXML
    private BarChart<String,Number> graphCO2;
    @FXML
    private BarChart<String,Number> graphTEMP;
    @FXML
    private BarChart<String,Number> graphHUM;
    @FXML
    private NumberAxis yaxisco2;
    @FXML
    private NumberAxis yaxistemp;
    @FXML
    private NumberAxis yaxishum;

    public void infoChartCO2(){
        try{
            this.yaxisco2.setLabel("Niveau CO2");
            this.yaxisco2.setAutoRanging(false);
            this.yaxisco2.setUpperBound(Integer.parseInt(data.get("tauxMaxCO2")));
            this.yaxisco2.setLowerBound(Integer.parseInt(data.get("tauxMinCO2")));
            this.yaxisco2.setTickUnit(Integer.parseInt(data.get("frequenceCO2")));
            this.graphCO2.setLegendVisible(false);

            srco2 = new XYChart.Series<>();
            srco2.getData().add(new XYChart.Data<String, Number>("Actuel",Integer.parseInt(donneeco2.get(data.get("capteurCO2")))));

            srco2alert = new XYChart.Series<>();
            srco2alert.getData().add(new XYChart.Data<String, Number>("Danger",Integer.parseInt(data.get("seuilCO2"))));

            this.graphCO2.getData().add(srco2);
            this.graphCO2.getData().add(srco2alert);
        }catch(Exception e){
            System.out.println("infoChartCO2(): "+e.getMessage());
            System.exit(1);
        }
    }
    public void infoChartTEMP(){
        try{
            this.yaxistemp.setLabel("Niveau Température");
            this.yaxistemp.setAutoRanging(false);
            this.yaxistemp.setUpperBound(Integer.parseInt(data.get("tauxMaxTemp")));
            this.yaxistemp.setLowerBound(Integer.parseInt(data.get("tauxMinTemp")));
            this.yaxistemp.setTickUnit(Integer.parseInt(data.get("frequenceTemp")));

            this.graphTEMP.setLegendVisible(false);

            XYChart.Series<String,Number> srtemp;
            XYChart.Series<String,Number> srtempalert;

            srtemp = new XYChart.Series<>();
            srtemp.getData().add(new XYChart.Data<String, Number>("Actuel",Integer.parseInt(donneetemp.get(data.get("capteurTemp")))));

            srtempalert = new XYChart.Series<>();
            srtempalert.getData().add(new XYChart.Data<String, Number>("Danger",Integer.parseInt(data.get("seuilTemp"))));

            this.graphTEMP.getData().add(srtemp);
            this.graphTEMP.getData().add(srtempalert);
        }catch(Exception e){
            System.out.println("infoChartTemp(): "+e.getMessage());
            System.exit(1);
        }
    }
    public void infoChartHUM(){
        try{
            this.yaxishum.setLabel("Niveau humidité");
            this.yaxishum.setAutoRanging(false);
            this.yaxishum.setUpperBound(Integer.parseInt(data.get("tauxMaxHum")));
            this.yaxishum.setLowerBound(Integer.parseInt(data.get("tauxMinHum")));
            this.yaxishum.setTickUnit(Integer.parseInt(data.get("frequenceHum")));

            this.graphHUM.setLegendVisible(false);

            XYChart.Series<String,Number> srhum;
            XYChart.Series<String,Number> srhumalert;

            srhum = new XYChart.Series<>();
            srhum.getData().add(new XYChart.Data<String, Number>("Actuel",Integer.parseInt(donneehum.get(data.get("capteurHum")))));

            srhumalert = new XYChart.Series<>();
            srhumalert.getData().add(new XYChart.Data<String, Number>("Danger",Integer.parseInt(data.get("seuilHum"))));

            this.graphHUM.getData().add(srhum);
            this.graphHUM.getData().add(srhumalert);
        }catch(Exception e){
            System.out.println("infoChartHum(): "+e.getMessage());
            System.exit(1);
        }
    }
    public void setFenetrePrincipale(Stage st) {
        this.fenetrePrincipale = st;
        this.fenetrePrincipale.setOnCloseRequest(e -> {e.consume();this.actionQuitter();});
    }


    // méthode pour quitter la fenetre
    public void actionQuitter() {
        Alert alert = new Alert(Alert.AlertType.CONFIRMATION);
        alert.setTitle("Fermeture de l'application");
        alert.setHeaderText("Voulez vous vraiment quitter ?");
        alert.initOwner(fenetrePrincipale);
        alert.getButtonTypes().setAll(ButtonType.YES,ButtonType.NO);
        Optional<ButtonType> response = alert.showAndWait();


        if (response.orElse(null)== ButtonType.YES) {
            this.fenetrePrincipale.close();
        }
    }

    public void actionConfig(){
        AppConfig appConfig = new AppConfig();
        appConfig.start();
    }


    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {

    }
}
