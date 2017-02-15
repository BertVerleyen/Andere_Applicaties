package domein;

import java.util.List;

public class Dokter {
	
	private int id;
	private String naam;
	private List<Pati�nt> pati�nten;
	private List<Voorschrift> voorschriften;
	
	
	public Dokter(int id, String naam, List<Pati�nt> pati�nten,
			List<Voorschrift> voorschriften) {
		super();
		this.id = id;
		this.naam = naam;
		this.pati�nten = pati�nten;
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


	public List<Pati�nt> getPati�nten() {
		return pati�nten;
	}


	public void setPati�nten(List<Pati�nt> pati�nten) {
		this.pati�nten = pati�nten;
	}


	public List<Voorschrift> getVoorschriften() {
		return voorschriften;
	}


	public void setVoorschriften(List<Voorschrift> voorschriften) {
		this.voorschriften = voorschriften;
	}
	
	
	
	
	
	

}
