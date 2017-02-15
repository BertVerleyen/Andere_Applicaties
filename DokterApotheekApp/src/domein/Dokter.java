package domein;

import java.util.List;

public class Dokter {
	
	private int id;
	private String naam;
	private List<Patiënt> patiënten;
	private List<Voorschrift> voorschriften;
	
	
	public Dokter(int id, String naam, List<Patiënt> patiënten,
			List<Voorschrift> voorschriften) {
		super();
		this.id = id;
		this.naam = naam;
		this.patiënten = patiënten;
		this.voorschriften = voorschriften;
	}
	
	public Dokter(int id, String naam)
	{
		this.id = id;
		this.naam = naam;
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


	public List<Patiënt> getPatiënten() {
		return patiënten;
	}


	public void setPatiënten(List<Patiënt> patiënten) {
		this.patiënten = patiënten;
	}


	public List<Voorschrift> getVoorschriften() {
		return voorschriften;
	}


	public void setVoorschriften(List<Voorschrift> voorschriften) {
		this.voorschriften = voorschriften;
	}
	
	
	
	
	
	

}
