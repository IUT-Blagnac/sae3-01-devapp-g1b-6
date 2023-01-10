package app.appsae;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Scene;
import javafx.scene.chart.*;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.ButtonType;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

import java.io.IOException;
import java.net.URL;
import java.util.Optional;
import java.util.ResourceBundle;

public class AppSAEController implements Initializable {

    private Stage fenetrePrincipale;
    private Stage secondStage;
    private BorderPane secondPane;
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


    public AppSAEController(){}

    public void infoChartCO2(){
        try{
            this.yaxisco2.setLabel("Niveau CO2");
            this.yaxisco2.setAutoRanging(false);
            this.yaxisco2.setUpperBound(1000);
            this.yaxisco2.setLowerBound(0);
            this.yaxisco2.setTickUnit(100);

            this.graphCO2.setLegendVisible(false);

            XYChart.Series<String,Number> srco2;
            XYChart.Series<String,Number> srco2alert;

            srco2 = new XYChart.Series<>();
            srco2.getData().add(new XYChart.Data<String, Number>("Niveau actuel",640));

            srco2alert = new XYChart.Series<>();
            srco2alert.getData().add(new XYChart.Data<String, Number>("Niveau Danger",800));

            this.graphCO2.getData().add(srco2);
            this.graphCO2.getData().add(srco2alert);
        }catch(Exception e){
            System.out.println(e.getMessage());
            System.exit(1);
        }
    }
    public void infoChartTEMP(){
        try{
            this.yaxistemp.setLabel("Niveau Température");
            this.yaxistemp.setAutoRanging(false);
            this.yaxistemp.setUpperBound(60);
            this.yaxistemp.setLowerBound(0);
            this.yaxistemp.setTickUnit(2);

            this.graphTEMP.setLegendVisible(false);

            XYChart.Series<String,Number> srtemp;
            XYChart.Series<String,Number> srtempalert;

            srtemp = new XYChart.Series<>();
            srtemp.getData().add(new XYChart.Data<String, Number>("Niveau actuel",30));

            srtempalert = new XYChart.Series<>();
            srtempalert.getData().add(new XYChart.Data<String, Number>("Niveau Danger",50));

            this.graphTEMP.getData().add(srtemp);
            this.graphTEMP.getData().add(srtempalert);
        }catch(Exception e){
            System.out.println(e.getMessage());
            System.exit(1);
        }
    }
    public void infoChartHUM(){
        try{
            this.yaxishum.setLabel("Niveau humidité");
            this.yaxishum.setAutoRanging(false);
            this.yaxishum.setUpperBound(100);
            this.yaxishum.setLowerBound(0);
            this.yaxishum.setTickUnit(1);

            this.graphHUM.setLegendVisible(false);

            XYChart.Series<String,Number> srhum;
            XYChart.Series<String,Number> srhumalert;

            srhum = new XYChart.Series<>();
            srhum.getData().add(new XYChart.Data<String, Number>("Niveau actuel",45));

            srhumalert = new XYChart.Series<>();
            srhumalert.getData().add(new XYChart.Data<String, Number>("Niveau Danger",80));

            this.graphHUM.getData().add(srhum);
            this.graphHUM.getData().add(srhumalert);
        }catch(Exception e){
            System.out.println(e.getMessage());
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
        this.secondPane = new BorderPane();
        Scene secondScene = new Scene(secondPane);
        this. secondStage = new Stage();

        secondStage.setTitle("AppSAE Configuration");
        secondStage.setScene(secondScene);
        secondStage.setResizable(false);

        Config();

        secondStage.show();
    }

    public void Config(){
        try {
            FXMLLoader loader = new FXMLLoader();
            loader.setLocation(AppSAE.class.getResource("AppConfig.fxml"));

            BorderPane app = loader.load();

            AppSAEController ctrl = loader.getController();

            ctrl.setFenetrePrincipale(secondStage);

            secondPane.setCenter(app);

        }catch (IOException e) {
            System.out.println("Ressource FXML non disponible : AppConfig");
            System.exit(1);
        }
    }



    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {

    }
}
