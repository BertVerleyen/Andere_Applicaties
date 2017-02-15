package persistentie;

import java.sql.Connection;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.GregorianCalendar;
import java.util.List;
import java.util.Date;
import domein.Evenement;





public class EvenementEntity  {
	
	private Connection connect = null;
    //private Statement statement = null;
    private PreparedStatement ps = null;
    //private ResultSet resultSet = null;
    
    private List<Evenement> evenementen;
	private Connection connection;
	private Statement statement;
	private ResultSet resultSet;
	private Calendar cal;
	private SimpleDateFormat f;
    
    public EvenementEntity()
    {
      evenementen = new ArrayList<Evenement>();
      cal = new GregorianCalendar();
      f = new SimpleDateFormat("dd/MM/yyyy HH:mm:ss");
    }
    
    public List<Evenement> geefAllEvenementen()
	{
		evenementen = new ArrayList<Evenement>();
		try{	
			connection = ConnectieManager.getInstance().getconnection();	
			statement = connection.createStatement();
			//allleen voor select-statements
			resultSet = statement.executeQuery("SELECT * FROM evenement");	
			while (resultSet.next()) {
				int id = resultSet.getInt("id");
				String datum = resultSet.getString("datum");
				String beschrijving = resultSet.getString("beschrijving");
				
				//cal.setTime(datum);
				
			    evenementen.add(new Evenement(id,datum,beschrijving));
			}
			resultSet.close();
			statement.close();
			connection.close();

		}
		catch (Exception e) {
			e.printStackTrace();
		}
		return evenementen;
	}
    
    public void createEvenement(int id,String datum, String beschrijving )
    {
    	try {
    		connection = ConnectieManager.getInstance().getconnection();	
			statement = connection.createStatement();
			
			
			statement.executeUpdate("INSERT INTO evenement (id, datum, beschrijving) "+
			        "values ('"+id+"','"+datum+"', '"
			                 +beschrijving+"')");
              
				
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
    	
    }
    
    
    
    public void deleteEvenement(int id)
    {
    	try{	
			connection = ConnectieManager.getInstance().getconnection();	
			statement = connection.createStatement();
			statement.executeUpdate("DELETE FROM evenement WHERE id="+id);	
			
			
			statement.close();
			connection.close();

		}
		catch (Exception e) {
			e.printStackTrace();
		}
    	
    }
    
    public void update(int id, String datum, String beschrijving)
    {
    	try{	
			connection = ConnectieManager.getInstance().getconnection();	
			statement = connection.createStatement();
			statement.executeUpdate("UPDATE evenement SET datum='"+datum+"', beschrijving='"+beschrijving+"' WHERE id="+id);	
			
             
			statement.close();
			connection.close();

		}
		catch (Exception e) {
			e.printStackTrace();
		}
    	
    }
    
  
   public boolean checkQueryHasDuplicates()
   {
	   
	   String queryCheck = "SELECT count(*) FROM evenement T1 WHERE T1.beschrijving = (SElECT T2.beschrijving FROM evenement T2 )";
	   
	try {
		connection = ConnectieManager.getInstance().getconnection();
		ps = connection.prepareStatement(queryCheck);  
		
		final ResultSet resultSet = ps.executeQuery(queryCheck);
	   
		if(resultSet.next()) {
	       final int count = resultSet.getInt(1);
	       if(count<=1){
	    	   return false;
	       }
	   }
	} catch (SQLException e) {
		// TODO Auto-generated catch block
		e.printStackTrace();
	}
	   
	 
	   return true;
   }




}


