package app.appsae;

import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;
import java.io.IOException;

public class AppConfig{
    private Stage fenetrePrincipale;
    private Stage secondStage;
    private BorderPane secondPane;


    public void start(){
        this.secondPane = new BorderPane();
        Scene secondScene = new Scene(secondPane);
        this.secondStage = new Stage();

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

            AppConfigController ctrl = loader.getController();

            ctrl.setFenetrePrincipale(secondStage);

            secondPane.setCenter(app);

        }catch (IOException e) {
            System.out.println("Config(): "+e.getMessage());
            System.exit(1);
        }
    }



}
