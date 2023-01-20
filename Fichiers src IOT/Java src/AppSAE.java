package app.appsae;

import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;



/**
 * Classe Application de mon code
 * donc premier fichier à être lu et lance la première fenêtre
 * */
public class AppSAE extends Application {

    private Stage primaryStage;
    private BorderPane rootPane;

    /**
     * Main de l'app avec la méthode launch() qui va lancer la méthode start
     * */
    public static void main(String[] args) {
        launch();
    }

    /**
     *Lance la première fenêtre de l'application
     * */
    @Override
    public void start(Stage stage){
        this.primaryStage = stage;
        this.rootPane = new BorderPane();

        Scene scene = new Scene(rootPane);

        //on paramètre la scène (titre, scene dans le stage et changement de taille impossible)
        primaryStage.setTitle("Application capteur SubOne");
        primaryStage.setScene(scene);
        primaryStage.setResizable(false);

        //on appelle la méthode App()
        App();


    }

    /**
     * Méthode utilisée pour lier le fxml à la fenêtre
     * */
    public void App(){
        try {
            //on charge le fichier fxml
            FXMLLoader loader = new FXMLLoader();
            //on lui donne le chemin du fichier fxml
            loader.setLocation(AppSAE.class.getResource("AppSAE.fxml"));

            //on charge le borderpane avec le fxml
            BorderPane app = loader.load();

            //on récupère le controller pour avoir accès à ses méthodes
            AppSAEController ctrl = loader.getController();

            //on utilise la méthode setFenetrePrincipale pour qu'on puisse fermer correctement la page
            ctrl.setFenetrePrincipale(primaryStage);

            rootPane.setCenter(app);

            //on lance les méthodes initContext() et displayDialog()
            ctrl.initContext(this.primaryStage);
            ctrl.displayDialog();
        }catch (Exception e) {
            System.out.println("App(): "+e.getMessage());
            System.exit(1);
        }
    }
}
