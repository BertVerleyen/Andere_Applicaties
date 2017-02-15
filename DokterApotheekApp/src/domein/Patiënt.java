package domein;

import java.util.ArrayList;
import java.util.List;

public class Patiënt {
	
	private int id;
	private String naam;
	private String voornaam;
	private String adres;
	private String diagnose;
	private int aantalConsultaties; //many to many in database 2 id's 
	private List<Consultatie> consultaties = new ArrayList<Consultatie>();
	
	public Patiënt(int id, String naam, String voornaam, String adres,
			String diagnose, int aantalConsultaties)
	{
		super();
		this.id = id;
		this.naam = naam;
		this.voornaam = voornaam;
		this.adres = adres;
		this.diagnose = diagnose;
		this.aantalConsultaties = aantalConsultaties;
		
	}
	
	
	
	public Patiënt(int id, String naam, String voornaam, String adres,
			String diagnose, int aantalConsultaties, List<Consultatie> consultaties) {
		super();
		this.id = id;
		this.naam = naam;
		this.voornaam = voornaam;
		this.adres = adres;
		this.diagnose = diagnose;
		this.aantalConsultaties = aantalConsultaties;
		this.consultaties = consultaties;
	}


	public int getId() {
		return id;
	}


	public void setId(int id) {
		this.id = id;
	}


	public String getNaam() {
		return naam;
	}


	public void setNaam(String naam) {
		this.naam = naam;
	}


	public String getVoornaam() {
		return voornaam;
	}


	public void setVoornaam(String voornaam) {
		this.voornaam = voornaam;
	}


	public String getAdres() {
		return adres;
	}


	public void setAdres(String adres) {
		this.adres = adres;
	}


	public String getDiagnose() {
		return diagnose;
	}


	public void setDiagnose(String diagnose) {
		this.diagnose = diagnose;
	}


	public int getAantalConsultaties() {
		return aantalConsultaties;
	}


	public void setAantalConsultaties(int aantalConsultaties) {
		this.aantalConsultaties = aantalConsultaties;
	}
	
	
	
	
	

}
