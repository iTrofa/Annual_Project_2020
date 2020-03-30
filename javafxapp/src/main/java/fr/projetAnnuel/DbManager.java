package fr.projetAnnuel;
import java.io.FileInputStream;
import java.io.IOException;
import java.sql.*;
import java.util.Hashtable;
import java.util.Properties;

public class DbManager {
    private Connection connection;

    public DbManager() {
            Properties config = new Properties();
            try (FileInputStream fp =
                         new FileInputStream("src/main/resources/db.properties")) {
                config.load(fp);
            } catch (IOException e) {
                e.printStackTrace();
                System.exit(-1);
            }
            try {
                Class.forName(config.getProperty("jdbc.driver.class"));
            } catch (ClassNotFoundException e) {
                e.printStackTrace();
                System.exit(3);
            }
            try {
                connection = DriverManager.getConnection(config.getProperty("jdbc.url"), config.getProperty("jdbc.login"),
                        config.getProperty("jdbc.pwd"));
            } catch (SQLException e) {
                e.printStackTrace();
                System.exit(3);
            }

    }
    public ResultSet query(String query)  {
        ResultSet res = null;
        Statement statement ;
               try {
                   statement = connection.createStatement();
                   res = statement.executeQuery(query);
               } catch (SQLException e) {
                   e.printStackTrace();
                   System.exit(3);
               }
        try {
            if (res.next()) {
                return res;
            }
        } catch (SQLException e) {
            e.printStackTrace();
            System.exit(3);
        }
        return res;
    }
    public ResultSet prepare(String query, Hashtable<Integer, String>  params)  {
        ResultSet res;
        PreparedStatement stmt = null;
        try {
             stmt = connection.prepareStatement(query);
            for (int i = 1; i <= params.size() ; i++)
            {
                stmt.setString(i, params.get(i));
            }
            System.out.println(stmt);
        }catch (SQLException e)
        {
            e.printStackTrace();
            System.exit(3);
        }
        try {

            res = stmt.executeQuery();
            if (res.next())
            {
                return res;
            }
        }catch (SQLException e){
            e.printStackTrace();
            System.exit(3);
        }
        return null;
    }
}
