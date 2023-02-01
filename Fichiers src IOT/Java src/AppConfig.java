package app.appsae;

import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;
import java.io.IOException;

/**
 * Classe de la fenêtre de configurations
 * */
public class AppConfig{
    private Stage secondStage;
    private BorderPane secondPane;


    /**
     * Méthode start() pour commencer la fenêtre
     * */
    public void start(){
        //on instancie le borderpane, la scene et le stage
        this.secondPane = new BorderPane();
        Scene secondScene = new Scene(secondPane);
        this.secondStage = new Stage();

        //on choisit un titre, on met la scene dans le stage
        secondStage.setTitle("AppSAE Configuration");
        secondStage.setScene(secondScene);
        //on empêche de changer la taille de la fenêtre manuellement
        secondStage.setResizable(false);

        //on lance la méthode config
        Config();

        //on montre la page
        secondStage.show();
    }

    /**
     * Méthode qui charge le fxml et le lie à la page
     * */
    public void Config(){
        try {
            //on créait un objet FXMLLoader
            FXMLLoader loader = new FXMLLoader();
            //on lui donne le chemin de notre fichier fxml de la page
            loader.setLocation(AppSAE.class.getResource("AppConfig.fxml"));

            //on charge le borderpane avec le fxml
            BorderPane app = loader.load();

            //on récupère le controller pour utiliser ses méthodes
            AppConfigController ctrl = loader.getController();

            //on utilise la méthode setFenetrePrincipale du controller pour lui dire que c'est cette page qu'il devra fermer
            ctrl.setFenetrePrincipale(secondStage);

            secondPane.setCenter(app);

        }catch (IOException e) {
            System.out.println("Config(): "+e.getMessage());
            System.exit(1);
        }
    }



}
