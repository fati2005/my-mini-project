package hotel;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public final class Conn {
    private static final String URL = "jdbc:mysql://localhost:4306/hotelgestion";
    private static final String USER = "root";
    private static final String PASSWORD = "";

    // Constructeur privé pour empêcher l'instanciation de cette classe utilitaire
    private Conn() {
        throw new IllegalStateException("Utility class");
    }

    public static Connection connect() throws SQLException {
        try {
            // Connexion à la base de données
            return DriverManager.getConnection(URL, USER, PASSWORD);
        } catch (SQLException e) {
            throw new SQLException("Connection failed: " + e.getMessage(), e);
        }
    }
}
