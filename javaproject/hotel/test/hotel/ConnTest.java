package hotel;

import java.sql.Connection;
import java.sql.SQLException;
import org.junit.After;
import org.junit.AfterClass;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;
import static org.junit.Assert.*;

public class ConnTest {

    @BeforeClass
    public static void setUpClass() throws Exception {
        // Définit le mot de passe réel à utiliser pour la connexion.
        // Remplace "tonMotDePasseReel" par le mot de passe réel de ta base de données.
        System.setProperty("database.password", "fati");
    }

    @AfterClass
    public static void tearDownClass() throws Exception {
    }

    @Before
    public void setUp() throws Exception {
    }

    @After
    public void tearDown() throws Exception {
    }

    @Test
    public void testConnection() {
        try (Connection conn = Conn.connect()) {
            assertNotNull("La connexion ne doit pas être nulle", conn);
            assertFalse("La connexion ne doit pas être fermée", conn.isClosed());
        } catch (SQLException e) {
            fail("Échec de la connexion : " + e.getMessage());
        }
    }

    /**
     * Test de la méthode connect de la classe Conn.
     */
    @Test
    public void testConnect() throws Exception {
        System.out.println("connect");
        Connection result = Conn.connect();
        assertNotNull("La connexion doit être initialisée", result);
        result.close();
    }
}
