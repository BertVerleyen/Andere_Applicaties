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

import domein.Consultatie;

public class ConsultatieEntity {
	
	
	
	private Connection connect = null;
    //private Statement statement = null;
    private PreparedStatement ps = null;
    //private ResultSet resultSet = null;
    
    private List<Consultatie> consultaties;
	private Connection connection;
	private Statement statement;
	private ResultSet resultSet;
	private Calendar cal;
	private SimpleDateFormat f;
	private String sqlQuery;
    
    public ConsultatieEntity()
    {
      consultaties = new ArrayList<Consultatie>();
      cal = new GregorianCalendar();
      f = new SimpleDateFormat("dd/MM/yyyy HH:mm:ss");
    }
    
    public List<Consultatie> geefConsultaties()
	{
		consultaties = new ArrayList<Consultatie>();
		try{	
			connection = ConnectieManager.getInstance().getconnection();	
			statement = connection.createStatement();
			//allleen voor select-statements
			resultSet = statement.executeQuery("SELECT * FROM consultatie");	
			while (resultSet.next()) {
				ResultSet auto_id_resultset = statement.getGeneratedKeys();
				int id = auto_id_resultset.getInt("id");
				String datumUur = resultSet.getString("datumUur");
				int dokterId = resultSet.getInt("dokterId");
				int patId = resultSet.getInt("patiëntId");
				
				
				
				consultaties.add(new Consultatie(datumUur,dokterId,patId));
			}
			resultSet.close();
			statement.close();
			connection.close();

		}
		catch (Exception e) {
			e.printStackTrace();
		}
		return consultaties;
	}
    
    public void createConsultatie(String datumUur,int dokterId, int patiëntId)
    {
    	try {
    		connection = ConnectieManager.getInstance().getconnection();	
			statement = connection.createStatement();
			
			
			statement.executeUpdate("INSERT INTO consultatie (id, datumUur, dokterId, patiëntId) "+
			        "VALUES ('"+statement.RETURN_GENERATED_KEYS+"', '"+datumUur+"', '"+dokterId+"', '"+patiëntId+"')");
            
				
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
    	
    	/*AUTO-increment keys!!!!!!
    	 * String sql = "INSERT INTO table (column1, column2) values(?, ?)";
stmt = conn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS);


stmt.executeUpdate();
if(returnLastInsertId) {
   ResultSet rs = stmt.getGeneratedKeys();
    rs.next();
   auto_id = rs.getInt(1);
}
    	 * 
    	 * */
    	
    }
    
    //Wegens many-to-many relatie tussen dokter en patiënt, VOEG je best bij het maken van een dokter en patiënt
    //ook een toewijzing toe van een patiënt bij een dokter
	/*public void addRelation(int dokterID, int patiëntID){
		try {
			
			connection = ConnectieManager.getInstance().getconnection();
			sqlQuery = "INSERT INTO dokter_patiënt VALUES ('"+dokterID+"','"+patiëntID+"')";
			PreparedStatement stat = connection.prepareStatement(sqlQuery);
			stat.executeUpdate();	
			stat.close();
			connection.close();
			
		}catch (SQLException e) {
			e.printStackTrace();
		}
	}
    */
    
    
    public void delete(int id)
    {
    	try{	
			connection = ConnectieManager.getInstance().getconnection();	
			statement = connection.createStatement();
			statement.executeUpdate("DELETE FROM consultatie WHERE id="+id);	
			
			
			statement.close();
			connection.close();

		}
		catch (Exception e) {
			e.printStackTrace();
		}
    	
    }
    
    public void update(int id, String datumUur, int dokterId, int patId)
    {
    	try{	
			connection = ConnectieManager.getInstance().getconnection();	
			statement = connection.createStatement();
			statement.executeUpdate("UPDATE dokter SET beschrijving='"+datumUur+"', dokterId='"+dokterId+"', patiëntId='"+patId+"'  WHERE id="+id);	
			
             
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
