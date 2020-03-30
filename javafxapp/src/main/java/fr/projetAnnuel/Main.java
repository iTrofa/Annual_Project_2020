package fr.projetAnnuel;

import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.image.Image;
import javafx.stage.Stage;

import java.awt.Dimension;

public class Main extends Application {

    @Override
    public void start(Stage primaryStage) throws Exception{
        Parent root = FXMLLoader.load(getClass().getResource("/test.fxml"));
        primaryStage.setTitle("SQL client");


        Image icon = new Image(getClass().getResourceAsStream("/logo.png"));
        primaryStage.getIcons().add(icon);

        Dimension dimension = java.awt.Toolkit.getDefaultToolkit().getScreenSize();
        primaryStage.setScene(new Scene(root, dimension.getWidth() / 2, dimension.getHeight() / 2));
        primaryStage.show();
        
    }


    public static void main(String[] args) {
        launch(args);
    }
}
