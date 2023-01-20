package app.appsae;

import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.chart.*;
import javafx.scene.control.Alert;
import javafx.scene.control.ButtonType;
import javafx.stage.Stage;
import java.net.URL;
import java.util.Map;
import java.util.Optional;
import java.util.ResourceBundle;

/**
 * Controller de la première scene
 * */
public class AppSAEController implements Initializable {

    private Stage fenetrePrincipale;
    private ThreadMajGraph tmg;
    final private Reader reader = new Reader();
    private Map<String, String> data = reader.chargerYaml();

    /**
     * on donne à la variable fenetreprincipale la valeur du stage de la page
     * */
    public void initContext(Stage primarystage){
        this.fenetrePrincipale = primarystage;
    }

    /**
     * Méthode qui affiche la fenêtre et lance le thread de mise à jour des graphiques
     * */
    public void displayDialog() {
        //on affiche la fenêtre actuelle
        this.fenetrePrincipale.show();

        // Création du "code" à exécuter en thread (un Runnable)
        this.tmg = new ThreadMajGraph(this);

        // Création d'un thread pour exécuter notre code de rb (rb.run())
        Thread t = new Thread(this.tmg);
        // Démarrage du thread
        t.start();
    }

    @FXML
    private StackedBarChart<String,Number> graphCO2;
    @FXML
    private StackedBarChart<String,Number> graphTEMP;
    @FXML
    private StackedBarChart<String,Number> graphHUM;

    @FXML
    public NumberAxis yaxisco2;
    @FXML
    private NumberAxis yaxistemp;
    @FXML
    private NumberAxis yaxishum;

    /**
     * Méthode de mise à jour du graphique de CO2
     * */
    public void majChartCO2(){
        try {
            //on récupère les donnees du fichier txt (CO2) et les donnees de config
            Map<String, String> donneeco2 = reader.readerTXT("src/main/resources/app/appsae/co2.txt");
            data = reader.chargerYaml();

            //on créait une nouvelle series
            XYChart.Series<String, Number> srco2 = new StackedBarChart.Series<String, Number>();
            //on clear son contenu
            srco2.getData().clear();
            //on créait une nouvelle series (pour le seuil de danger)
            XYChart.Series<String, Number> srco2alert = new StackedBarChart.Series<String, Number>();
            //on clear son contenu
            srco2alert.getData().clear();

            //on ajoute des data dans les series en récupérant la donnée dans les Map (donneeco2 et data)
            srco2.getData().add(new XYChart.Data<>("Actuel", Integer.parseInt(donneeco2.get(data.get("capteurCO2")))));
            srco2alert.getData().add(new XYChart.Data<String, Number>("Danger", Integer.parseInt(data.get("seuilCO2"))));

            //on clear le contenu du graph
            graphCO2.getData().clear();
            //on y ajoute les deux nouvelles series
            graphCO2.getData().add(srco2);
            graphCO2.getData().add(srco2alert);
        }catch (Exception e){
            System.out.println("majChartCO2(): "+e.getMessage());
            System.exit(1);
        }
    }

    /**
     * Méthode qui configure le graphique de CO2
     * */
    public void initialisationParamGraphCO2(){
        //on choisit le titre du Yaxis
        yaxisco2.setLabel("Niveau CO2");
        yaxisco2.setAutoRanging(false);
        //on récupère le max et min du yaxis et on paramètre le graph avec elle
        yaxisco2.setUpperBound(Integer.parseInt(data.get("tauxMaxCO2")));
        yaxisco2.setLowerBound(Integer.parseInt(data.get("tauxMinCO2")));
        // pareil avec le pas du graphique
        yaxisco2.setTickUnit(Integer.parseInt(data.get("frequenceCO2")));
        //on retire la légende du graphique
        graphCO2.setLegendVisible(false);
        //on change la largeur des barres en mettant un espace entre elles
        graphCO2.setCategoryGap(40);
    }

    /**
     * Méthode de mise à jour du graphique de température
     * */
    public void majChartTEMP(){
        try {
            //on récupère les donnees du fichier txt (TEMP) et les donnees de config
            Map<String, String> donneetemp = reader.readerTXT("src/main/resources/app/appsae/temp.txt");
            data = reader.chargerYaml();

            //on créait une nouvelle series
            XYChart.Series<String, Number> srtemp = new StackedBarChart.Series<String, Number>();
            //on clear son contenu
            srtemp.getData().clear();
            //on créait une nouvelle series (pour le seuil de danger)
            XYChart.Series<String, Number> srtempalert = new StackedBarChart.Series<String, Number>();
            //on clear son contenu
            srtempalert.getData().clear();

            //on ajoute des data dans les series en récupérant la donnée dans les Map (donneeco2 et data)
            srtemp.getData().add(new XYChart.Data<>("Actuel", Integer.parseInt(donneetemp.get(data.get("capteurTemp")))));
            srtempalert.getData().add(new XYChart.Data<String, Number>("Danger", Integer.parseInt(data.get("seuilTemp"))));

            //on clear le contenu du graph
            graphTEMP.getData().clear();
            //on y ajoute les deux nouvelles series
            graphTEMP.getData().add(srtemp);
            graphTEMP.getData().add(srtempalert);
        }catch (Exception e){
            System.out.println("majChartTEMP(): "+e.getMessage());
            System.exit(1);
        }
    }
    /**
     * Méthode qui configure le graphique de température
     * */
    public void initialisationParamGraphTEMP(){
        //on choisit le titre du Yaxis
        this.yaxistemp.setLabel("Niveau Température");
        this.yaxistemp.setAutoRanging(false);
        //on récupère le max et min du yaxis et on paramètre le graph avec elle
        this.yaxistemp.setUpperBound(Integer.parseInt(data.get("tauxMaxTemp")));
        this.yaxistemp.setLowerBound(Integer.parseInt(data.get("tauxMinTemp")));
        // pareil avec le pas du graphique
        this.yaxistemp.setTickUnit(Integer.parseInt(data.get("frequenceTemp")));
        //on retire la légende du graphique
        this.graphTEMP.setLegendVisible(false);
        //on change la largeur des barres en mettant un espace entre elles
        this.graphTEMP.setCategoryGap(40);
    }

    /**
     * Méthode de mise à jour du graphique d'humidité
     * */
    public void majChartHUM(){
        try {
            //on récupère les donnees du fichier txt (HUM) et les donnees de config
            Map<String, String> donneehum = reader.readerTXT("src/main/resources/app/appsae/hum.txt");
            data = reader.chargerYaml();

            //on créait une nouvelle series
            XYChart.Series<String, Number> srhum = new StackedBarChart.Series<String, Number>();
            //on clear son contenu
            srhum.getData().clear();
            //on créait une nouvelle series (pour le seuil de danger)
            XYChart.Series<String, Number> srhumalert = new StackedBarChart.Series<String, Number>();
            //on clear son contenu
            srhumalert.getData().clear();

            //on ajoute des data dans les series en récupérant la donnée dans les Map (donneeco2 et data)
            srhum.getData().add(new XYChart.Data<>("Actuel", Integer.parseInt(donneehum.get(data.get("capteurHum")))));
            srhumalert.getData().add(new XYChart.Data<String, Number>("Danger", Integer.parseInt(data.get("seuilHum"))));

            //on clear le contenu du graph
            graphHUM.getData().clear();
            //on y ajoute les deux nouvelles series
            graphHUM.getData().add(srhum);
            graphHUM.getData().add(srhumalert);
        }catch (Exception e){
            System.out.println("majChartHUM(): "+e.getMessage());
            System.exit(1);
        }
    }
    /**
     * Méthode qui configure le graphique d'humidité
     * */
    public void initialisationParamGraphHUM(){
        //on choisit le titre du Yaxis
        this.yaxishum.setLabel("Niveau humidité");
        this.yaxishum.setAutoRanging(false);
        //on récupère le max et min du yaxis et on paramètre le graph avec elle
        this.yaxishum.setUpperBound(Integer.parseInt(data.get("tauxMaxHum")));
        this.yaxishum.setLowerBound(Integer.parseInt(data.get("tauxMinHum")));
        // pareil avec le pas du graphique
        this.yaxishum.setTickUnit(Integer.parseInt(data.get("frequenceHum")));
        //on retire la légende du graphique
        this.graphHUM.setLegendVisible(false);
        //on change la largeur des barres en mettant un espace entre elles
        this.graphHUM.setCategoryGap(40);
    }

    /**
     * méthode qui initialise le stage actuel et qui lance actionQuitter si la croix rouge est cliqué sur ce stage
     * */
    public void setFenetrePrincipale(Stage st) {
        //on change la valeur de la fenetreprincipale
        this.fenetrePrincipale = st;
        //on dit quoi faire quand la croix rouge est cliqué
        this.fenetrePrincipale.setOnCloseRequest(e -> {e.consume();this.actionQuitter();});
    }


    /**
     *  méthode liée au bouton quitter pour fermer la fenêtre et arrêter le thread
     */
    public void actionQuitter() {
        //popup d'alerte pour être sûr de quitter
        Alert alert = new Alert(Alert.AlertType.CONFIRMATION);
        alert.setTitle("Fermeture de l'application");
        alert.setHeaderText("Voulez vous vraiment quitter ?");
        alert.initOwner(fenetrePrincipale);
        alert.getButtonTypes().setAll(ButtonType.YES,ButtonType.NO);
        Optional<ButtonType> response = alert.showAndWait();

        // si la réponse est oui on close et on stop le thread
        if (response.orElse(null)== ButtonType.YES) {
            this.fenetrePrincipale.close();
            tmg.stop();
        }
    }


    /**
     * méthode liée au bouton configuration qui lance la page de Configuration
     * */
    public void actionConfig(){
        //on récupère le constructeur
        AppConfig appConfig = new AppConfig();
        //on lance la methode start
        appConfig.start();
    }

    /**
     * méthode qui initialize les paramètres des graphiques en appelant ces méthodes
     * */
    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {
        // on lance les trois méthodes pour initialiser les graphiques
        this.initialisationParamGraphCO2();
        this.initialisationParamGraphTEMP();
        this.initialisationParamGraphHUM();
    }
}
