/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/UnitTests/JUnit4TestClass.java to edit this template
 */
package hotel;

import org.junit.After;
import org.junit.AfterClass;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;
import static org.junit.Assert.*;

/**
 *
 * @author user
 */
public class LoginFrameTest {
    
    public LoginFrameTest() {
    }
    
    @BeforeClass
    public static void setUpClass() {
        // Code exécuté une seule fois avant tous les tests
    }
    
    @AfterClass
    public static void tearDownClass() {
        // Code exécuté une seule fois après tous les tests
    }
    
    @Before
    public void setUp() {
        // Code exécuté avant chaque test
    }
    
    @After
    public void tearDown() {
        // Code exécuté après chaque test
    }

    /**
     * Test de la méthode main de la classe LoginFrame.
     */
    @Test
    public void testMain() {
        System.out.println("Test de LoginFrame.main()");
        String[] args = null;
        try {
            LoginFrame.main(args);
            // On suppose que l'exécution ne lève pas d'exception
            assertTrue(true);
        } catch (Exception e) {
            fail("La méthode main a levé une exception : " + e.getMessage());
        }
    }
}
