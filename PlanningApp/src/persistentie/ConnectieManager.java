package persistentie;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

import javax.swing.JOptionPane;

public class ConnectieManager {
	
	
	
	
		
		
		private static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";
		
		private static ConnectieManager manager;
			/**
			 * Database pad
			 */
		private String databaseUrl = "jdbc:mysql://localhost/PlanningDb";
			/**
			 * Database connectie
			 */
		private Connection databaseConnection = null;

			public static ConnectieManager getInstance(){
				if (manager == null){
					manager = new ConnectieManager();
				}
				return manager;
			}
			private ConnectieManager()
			{
				try         
				{
					Class.forName(JDBC_DRIVER);
						
				}
				catch (Exception e) {	
					JOptionPane.showMessageDialog(null, e.getMessage(), "Database Error", JOptionPane.ERROR_MESSAGE);
				}
			}

			
			
			/**
			 * Sluit de huidige database connectie.
			 */
			public void close()
			{
				try
				{
					// sluit de laatst aangemaakte database verbinding
					if (databaseConnection != null && !databaseConnection.isClosed()) {
						databaseConnection.close();
					}
				}
				catch (SQLException sqlException) 
				{
					JOptionPane.showMessageDialog(null, sqlException.getMessage(),
							"Database Error", JOptionPane.ERROR_MESSAGE);

					System.exit(1);
				}
			}


			private void openConnection(){
				try {
					databaseConnection = DriverManager.getConnection(databaseUrl,"root","root");
				} catch (SQLException e) {
					JOptionPane.showMessageDialog(null, e.getMessage(), "Database Error", JOptionPane.ERROR_MESSAGE);
				}
			}

			public Connection getconnection() {
				openConnection();
				
				return databaseConnection;
			}

}
