package fr.projetAnnuel;

import com.jfoenix.controls.JFXComboBox;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;

import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.util.Hashtable;

public class Controller {
    private DbManager dbManager;



    @FXML
    private TextField textName;

    @FXML
    private Label labelResult;
    @FXML
    private Label labelTableAdded;


    @FXML
    private JFXComboBox<String> boxCols;
    @FXML
    private JFXComboBox<String> boxTable;

    private FileWriter csvWriter;

    public void initialize() throws SQLException, IOException {
        csvWriter = new FileWriter("export.csv");

        dbManager = new DbManager();
        ResultSet res;
        ObservableList<String> colValues = FXCollections.observableArrayList();
        ObservableList<String> tableValues = FXCollections.observableArrayList();
        res = dbManager.query("show COLUMNS FROM person");
        if (res != null) {
            while (res.next()){
               colValues.add(
                       res.getString(1)
               );
            }
            boxCols.setItems(colValues);
        }

        res = dbManager.query("show TABLES");
        if (res != null) {
            while (res.next()){
                tableValues.add(
                       res.getString(1)
               );
            }
            boxTable.setItems(tableValues);
        }

    }

    @FXML
    void onSubmitWithFilter(ActionEvent event) throws SQLException {
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

    @FXML
    void onSubmitCSV(ActionEvent event) throws SQLException, IOException {
        ResultSet res = null;
        ResultSetMetaData rsmd = null;
        if (boxTable.getValue() != null) {
            if (labelTableAdded.getText()!=null) {
                String beforeText = labelTableAdded.getText();
                labelTableAdded.setText(beforeText + " " + boxTable.getValue());
            }else {
                labelTableAdded.setText(boxTable.getValue());
            }
                res = dbManager.query(String.format("select * from %s ", boxTable.getValue()));
                rsmd = res.getMetaData();


        }

        if (res != null) {
            while (res.next()) {
                for (int i = 1; i < rsmd.getColumnCount(); i++) {
                    csvWriter.append(rsmd.getColumnName(i));
                    csvWriter.append(";");
                    csvWriter.append(res.getString(i));
                    csvWriter.append(";");
                }
                csvWriter.append("\n");
            }
        }
    }

    @FXML
    void onSubmitSaveCSV(ActionEvent event) throws IOException {
        File file = new File("export.csv");
        if (file.length()!= 0){
            csvWriter.close();
        }
    }
}
