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
public class HomeFrameTest {
    
    public HomeFrameTest() {
    }
    
    @BeforeClass
    public static void setUpClass() {
        // Exécuté une seule fois avant tous les tests
    }
    
    @AfterClass
    public static void tearDownClass() {
        // Exécuté une seule fois après tous les tests
    }
    
    @Before
    public void setUp() {
        // Exécuté avant chaque test
    }
    
    @After
    public void tearDown() {
        // Exécuté après chaque test
    }

    /**
     * Test de la méthode main de la classe HomeFrame.
     */
    @Test
    public void testMain() {
        System.out.println("Test de HomeFrame.main()");
        String[] args = null;
        try {
            HomeFrame.main(args);
            // Le test passe si aucune exception n’est levée
            assertTrue(true);
        } catch (Exception e) {
            fail("La méthode main a levé une exception : " + e.getMessage());
        }
    }
}
