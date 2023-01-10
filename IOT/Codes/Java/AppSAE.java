package app.appsae;

import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

import java.io.IOException;

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

        primaryStage.setTitle("AppSAE");
        primaryStage.setScene(scene);
        primaryStage.setResizable(false);

        App();

        primaryStage.show();

    }

    public void App(){
        try {
            FXMLLoader loader = new FXMLLoader();
            loader.setLocation(AppSAE.class.getResource("AppSAE.fxml"));



            this.ctrl = loader.getController();

            this.ctrl.setFenetrePrincipale(primaryStage);

            this.ctrl.infoChartCO2();
            this.ctrl.infoChartTEMP();
            this.ctrl.infoChartHUM();

            rootPane.setCenter(loader.load());

        }catch (IOException e) {
            System.out.println("Ressource FXML non disponible : AppSAE");
            System.exit(1);
        }
    }
}
