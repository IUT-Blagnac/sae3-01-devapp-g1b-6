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

/**
 * Controller de la page de configuration
 * */
public class AppConfigController implements Initializable {

    private Stage fenetrePrincipale;

    //private final AppSAEController appsaecontr = new AppSAEController();
    final private Reader reader= new Reader();

    private Map<String, String> data;
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
    @FXML
    private TextField textserveur;
    @FXML
    private TextField textport;


    /**
     * Méthode initialize qui lance setConfig()
     * */
    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {
        this.setConfig();
    }

    /**
     * Méthode liée au bouton valider qui charge le fichier yml, créait une Map et ajoute chaque donnée saisie sur la page à l'intérieur
     * pour ensuite écraser le contenu du fichier de config pour y mettre les nouvelles données qui sont dans la Map
     * */
    public void actionValider(){
        //on charge le fichier de config dans la Map data
        data = reader.chargerYaml();
        //on créait un nouveau Map pour stocker les nouvelles données
        Map<String, String> map = new HashMap<>();
        //on insère dans map les valeurs de la page de configuration
        map.put("server",this.textserveur.getText());
        map.put("appId",this.textport.getText());
        //ici on récupère l'ancienne valeur (présente dans data) car on ne le changera jamais
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
            //une fois que toutes les données sont dans map on créait un PrintWriter vers le fichier config.yml pour ecraser son contenu
            PrintWriter writer = new PrintWriter(new File("src/main/resources/app/appsae/config.yml"));
            //on créait un nouveau yaml
            Yaml yaml = new Yaml();
            //on dump dans le yaml les données de map dans le fichier config.yml
            yaml.dump(map, writer);
        }catch (Exception e){
            System.out.println("actionValider() : "+e.getMessage());
            System.exit(1);
        }


    }

    /**
     * Méthode qui met les valeurs actuelles (du fichier de config) dans leur case pour les modifier
     * */
    public void setConfig(){
        //on charge le fichier yml
        data= reader.chargerYaml();
        //on créait les objets spinners pour y mettre des données Integer modifiable
        SpinnerValueFactory<Integer> spinnermaxco2= new SpinnerValueFactory.IntegerSpinnerValueFactory(Integer.parseInt(data.get("tauxMinCO2")),5000,Integer.parseInt(data.get("tauxMaxCO2")));
        //on lui donne ça valeur actuelle et on fais ça pour tous
        this.maxCO2.setValueFactory(spinnermaxco2);
        SpinnerValueFactory<Integer> spinnerminco2= new SpinnerValueFactory.IntegerSpinnerValueFactory(0,Integer.parseInt(data.get("tauxMaxCO2")),Integer.parseInt(data.get("tauxMinCO2")));
        this.minCO2.setValueFactory(spinnerminco2);
        SpinnerValueFactory<Integer> spinnerseuilco2= new SpinnerValueFactory.IntegerSpinnerValueFactory(Integer.parseInt(data.get("tauxMinCO2")),Integer.parseInt(data.get("tauxMaxCO2")),Integer.parseInt(data.get("seuilCO2")));
        this.seuilCO2.setValueFactory(spinnerseuilco2);
        SpinnerValueFactory<Integer> spinnerfreqco2= new SpinnerValueFactory.IntegerSpinnerValueFactory(0,Integer.parseInt(data.get("tauxMaxCO2")),Integer.parseInt(data.get("frequenceCO2")));
        this.freqCO2.setValueFactory(spinnerfreqco2);
        //ici on vide le menu déroulant des capteurs
        this.capteurCO2.getItems().clear();
        //on remet les différents capteur (en brut..)
        this.capteurCO2.getItems().addAll("AM107-7","AM107-3","AM107-9","AM107-4","AM107-2");
        //et on lui donne sa valeur actuelle
        this.capteurCO2.setValue(String.valueOf(data.get("capteurCO2")));

        //on fait la meme chose qu'au-dessus pour les éléments de température
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

        //encore la même chose pour les éléments d'humidité
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

        //ici on donne simplement leur valeur au textfield de serveur et port
        this.textserveur.setText(data.get("server"));
        this.textport.setText(data.get("appId"));
    }

    /**
     * Méthode qui initialise le stage actuel et qui lance actionQuitter si la croix rouge est cliquer sur se stage
     * */
    public void setFenetrePrincipale(Stage st) {
        //on change la valeur de la fenetreprincipale
        this.fenetrePrincipale = st;
        //on dit quoi faire quand la croix rouge est cliquée
        this.fenetrePrincipale.setOnCloseRequest(e -> {e.consume();this.actionQuitter("quitter");});
    }


    /**
     * méthode liée au bouton quitter pour fermer la fenêtre ou pour valider le panneau de configuration
     * */
    public void actionQuitter(String type) {
        //un switch case qui sépare le cas valider et quitter
        switch (type) {
            //le cas quitter
            case "quitter":
                //pop up qui arrive quand on veut quitter
                Alert alert = new Alert(Alert.AlertType.CONFIRMATION);
                alert.setTitle("Fermeture de l'application");
                alert.setHeaderText("Voulez vous vraiment quitter ?");
                alert.initOwner(fenetrePrincipale);
                alert.getButtonTypes().setAll(ButtonType.YES, ButtonType.NO);
                Optional<ButtonType> response = alert.showAndWait();

                //si oui on ferme la fenêtre
                if (response.orElse(null) == ButtonType.YES) {
                    this.fenetrePrincipale.close();
                }
            //cas de valider
            case "valider":
                //pop up pour valider la validation des informations
                Alert alert2 = new Alert(Alert.AlertType.CONFIRMATION);
                alert2.setTitle("Validation des informations");
                alert2.setHeaderText("Voulez vous vraiment valider (les informations ce mettront à jour) ?");
                alert2.initOwner(fenetrePrincipale);
                alert2.getButtonTypes().setAll(ButtonType.YES, ButtonType.NO);
                Optional<ButtonType> response2 = alert2.showAndWait();

                //si oui on appelle la méthode actionValider() et on ferme
                if (response2.orElse(null) == ButtonType.YES) {
                    this.actionValider();
                    this.fenetrePrincipale.close();
                }
        }
    }

    /**
     * Méthode liée au bouton valider qui appelle la fonction actionQuitter(valider)
     * */
    @FXML
    public void actionValidation(){
        this.actionQuitter("valider");
    }
}
