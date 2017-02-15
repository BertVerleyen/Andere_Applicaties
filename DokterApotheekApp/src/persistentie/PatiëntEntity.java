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


import domein.Patiënt;

public class PatiëntEntity {
	
	
	private Connection connect = null;
    //private Statement statement = null;
    private PreparedStatement ps = null;
    //private ResultSet resultSet = null;
    
    private List<Patiënt> patiënten;
	private Connection connection;
	private Statement statement;
	private ResultSet resultSet;
	private Calendar cal;
	private SimpleDateFormat f;
	private String sqlQuery;
    
    public PatiëntEntity()
    {
      patiënten = new ArrayList<Patiënt>();
      cal = new GregorianCalendar();
      f = new SimpleDateFormat("dd/MM/yyyy HH:mm:ss");
    }
    
    public List<Patiënt> geefPatiënten()
	{
		patiënten = new ArrayList<Patiënt>();
		try{	
			connection = ConnectieManager.getInstance().getconnection();	
			statement = connection.createStatement();
			//allleen voor select-statements
			resultSet = statement.executeQuery("SELECT * FROM patiënt");	
			while (resultSet.next()) {
				int id = resultSet.getInt("id");
				String naam = resultSet.getString("naam");
				String voornaam = resultSet.getString("voornaam");
				String adres = resultSet.getString("adres");
				String diagnose = resultSet.getString("diagnose");
				int aantalconsultaties = resultSet.getInt("aantalConsultaties");
				
				
				patiënten.add(new Patiënt(id, naam, voornaam, adres, diagnose, aantalconsultaties));
			}
			resultSet.close();
			statement.close();
			connection.close();

		}
		catch (Exception e) {
			e.printStackTrace();
		}
		return patiënten;
	}
    
    public void createPatiënt(int id, String naam, String vnaam, String adres, String diagnose, int aantalconsultaties)
    {
    	try {
    		connection = ConnectieManager.getInstance().getconnection();	
			statement = connection.createStatement();
			
			
			statement.executeUpdate("INSERT INTO patiënt "+
			        "VALUES ('"+id+"','"+naam+"', '"+vnaam+"', '"+adres+"', '"+diagnose+"', '"+aantalconsultaties+"')");
			statement.close();
			connection.close();
				
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
    	
    }
    
    //Wegens many-to-many relatie tussen dokter en patiënt, VOEG je best bij het maken van een dokter en patiënt
    //ook een toewijzing toe van een patiënt bij een dokter
	public void addRelation(int dokterID, int patiëntID){
		try {
			
			connection = ConnectieManager.getInstance().getconnection();
			sqlQuery = "INSERT INTO dokter_patiënt VALUES ('"+dokterID+"','"+patiëntID+"')";
			ps = connection.prepareStatement(sqlQuery);
			ps.executeUpdate();	
			ps.close();
			connection.close();
			
		}catch (SQLException e) {
			e.printStackTrace();
		}
	}
    
    
    
    public void delete(int id)
    {
    	try{	
			connection = ConnectieManager.getInstance().getconnection();	
			statement = connection.createStatement();
			statement.executeUpdate("DELETE FROM patiënt WHERE id="+id);	
			
			
			statement.close();
			connection.close();

		}
		catch (Exception e) {
			e.printStackTrace();
		}
    	
    }
    
    public void update(int id, String naam, String vnaam, String adres, String diagnose, int aantalconsultaties)
    {
    	try{	
			connection = ConnectieManager.getInstance().getconnection();	
			statement = connection.createStatement();
			statement.executeUpdate("UPDATE patiënt SET naam='"+naam+"', voornaam='"+vnaam+"', adres='"+adres+"', diagnose='"+diagnose+"', aantalConsultaties='"+aantalconsultaties+"' WHERE id="+id);	
			
             
			statement.close();
			connection.close();

		}
		catch (Exception e) {
			e.printStackTrace();
		}
    	
    }
    
  
   /*private boolean checkQueryHasDuplicates()
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
   }*/

	
	
	

}
