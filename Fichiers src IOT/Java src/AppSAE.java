package app.appsae;

import javafx.application.Application;
import javafx.application.Platform;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

import java.io.IOException;

import static java.lang.Thread.sleep;

public class AppSAE extends Application {

    private Stage primaryStage;
    private BorderPane rootPane;
    private AppSAEController ctrl;

    public static void main(String[] args) {
        launch();
    }

    @Override
    public void start(Stage stage){
        this.primaryStage = stage;
        this.rootPane = new BorderPane();

        Scene scene = new Scene(rootPane);

        primaryStage.setTitle("Application capteur SubOne");
        primaryStage.setScene(scene);
        primaryStage.setResizable(false);

        App();

        primaryStage.show();
        /*
        Platform.runLater(new ThreadGraph() {
            @Override
            public void run() {
                try {
                    // Appel des mises à jour de l'interface (méthodes, ...)
                    ctrl.infoChartCO2();
                    sleep(30000);
                }catch(Exception e){
                    System.out.println("run2(): "+e.getMessage());
                    System.exit(1);
                }
            }
        });*/

    }

    public void App(){
        try {
            FXMLLoader loader = new FXMLLoader();
            loader.setLocation(AppSAE.class.getResource("AppSAE.fxml"));

            BorderPane app = loader.load();

            this.ctrl = loader.getController();

            this.ctrl.setFenetrePrincipale(primaryStage);

            this.ctrl.infoChartCO2();
            this.ctrl.infoChartTEMP();
            this.ctrl.infoChartHUM();

            rootPane.setCenter(app);

        }catch (IOException e) {
            System.out.println("App(): "+e.getMessage());
            System.exit(1);
        }
    }
}
