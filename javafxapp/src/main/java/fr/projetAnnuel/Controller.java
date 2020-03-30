package fr.projetAnnuel;

import com.jfoenix.controls.JFXComboBox;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Hashtable;

public class Controller {
        private DbManager dbManager;



    @FXML
    private TextField textName;
    @FXML
    private Label labelResult;

    @FXML
    private JFXComboBox<String> boxCols;


    public void initialize() throws SQLException {
        ResultSet res;
        dbManager = new DbManager();
        ObservableList<String> values = FXCollections.observableArrayList();

        res = dbManager.query("show COLUMNS FROM person");
        if (res != null) {
            while (res.next()){
               values.add(
                       res.getString(1)
               );
            }
            boxCols.setItems(values);
        }
    }

    @FXML
    void onSubmit(ActionEvent event) throws SQLException {
        ResultSet res = null;
        StringBuilder builder = new StringBuilder();
        String value;
        String[] fields = new String[]{"","firstname: ","lastname: ","email: "};


        if (!textName.getText().equals("")) {
            Hashtable<Integer, String> params = new Hashtable<>();
            params.put(1, textName.getText());
            if (boxCols.getValue() != null)
                res = dbManager.prepare(String.format("select firstName,lastName,email from person where %s = ?",
                        boxCols.getValue()),
                        params);

            if (res != null) {
                for (int i = 1; i < 4; i++) {
                    builder.append(fields[i]);
                    builder.append(res.getString(i));
                    builder.append("\n");
                }
                value = builder.toString();

                labelResult.setText(value);
                return;
            }
            labelResult.setText("pas de correspondance");
        }
    }

}
