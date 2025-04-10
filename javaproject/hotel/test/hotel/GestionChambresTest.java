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
public class GestionChambresTest {
    
    public GestionChambresTest() {
    }
    
    @BeforeClass
    public static void setUpClass() {
        // Code exécuté une fois avant tous les tests
    }
    
    @AfterClass
    public static void tearDownClass() {
        // Code exécuté une fois après tous les tests
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
     * Test de la méthode main de la classe GestionChambres.
     */
    @Test
    public void testMain() {
        System.out.println("Test de GestionChambres.main()");
        String[] args = null;
        try {
            GestionChambres.main(args);
            // Si aucune exception : test réussi
            assertTrue(true);
        } catch (Exception e) {
            fail("La méthode main a levé une exception : " + e.getMessage());
        }
    }
}
