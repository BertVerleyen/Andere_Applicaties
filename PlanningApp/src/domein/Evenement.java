package domein;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

import javax.swing.JOptionPane;

import persistentie.EvenementEntity;

public class Evenement {
	
	private int id;
	private String datum;
	private String stringUur;
	private SimpleDateFormat uur;
	private String beschrijving;
	private String remindersTo;
	private static EvenementEntity evtEntity = new EvenementEntity();
	
	/**
	 * 
	 * @param id
	 * @param datum
	 * @param beschrijving
	 */
	
	public Evenement(int id,String evtdatum, String beschr)
	{
		
		create(id,evtdatum, beschr);
	}
	
	

	/*public Evenement(int id, Calendar datum , String beschrijving) {
		super();
		this.id = id;
		this.datum = datum;
		this.uur = new SimpleDateFormat("dd/MM/yyyy HH:mm");
		this.beschrijving = beschrijving;
		
	}*/
	
	/*public Evenement(int id, Date datum, String beschrijving){
		
		this.id = id;
		this.datum = datum;
		this.beschrijving = beschrijving;
		
	}*/
	
	public Evenement(EvenementEntity evtEntity)
	{
		this.evtEntity = evtEntity;
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public SimpleDateFormat getUur() {
		return uur;
	}

	public void setUur(SimpleDateFormat uur) {
		this.uur = uur;
	}
	
	

	public String getDatum() {
		return datum;
	}


	public void setDatum(String datum) {
		this.datum = datum;
	}


	public String getBeschrijving() {
		return beschrijving;
	}

	public void setBeschrijving(String beschrijving) {
		this.beschrijving = beschrijving;
	}

	/*@Override
	public String toString() {
		return "Evenement [id=" + id + ", datum=" + datum + ", uur=" + uur
				+ ", beschrijving=" + beschrijving + "]";
	}*/
	
	public void showDatum()
	{
	  //System.out.printf("%s %<td %<tm %<tY ", "Due date:", this.datum);
	  //%tm %<te %tB, %<tY
		
		//System.out.println(" an evenement Date: " + uur.format(this.datum.getTime()));
		JOptionPane.showMessageDialog(null, "the evenement date: "+uur.format(this.datum));
	}
	
	
	   public String getRemindersTo() {
	      return this.remindersTo;
	   }
	   public void setRemindersTo(String value) {
	      this.remindersTo = value;
	   }
	
	   public void create(int id,String evtdatum,String beschrijving)
	   {
		  
		   this.setId(id);
		   this.setDatum(evtdatum);
		   this.setBeschrijving(beschrijving);
		  
		   try {
			   if(!evtEntity.checkQueryHasDuplicates())
			   {
			     evtEntity.createEvenement(id,evtdatum, beschrijving);
			   }
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace(); e.getMessage();
		}
		   
		   
	   }

	   
	   public void delete(int id)
	   {
		   
		     evtEntity.deleteEvenement(id);
		   
		   
	   }
	   
	   public void update(int id, String datum, String beschrijving)
	   {
		   
		   evtEntity.update(id,datum, beschrijving);
	   }
	   
	   
}
