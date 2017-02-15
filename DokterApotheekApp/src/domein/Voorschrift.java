package domein;

import java.util.List;

public class Voorschrift {
	
	private int patiëntId;
	private String beschrijving;
	private Medicamenten medicamenten;
	private int dokter;
	
	private Patiënt patiënt;
	
	public Voorschrift(String beschrijving, Medicamenten medicamenten,int dokterId, int patiëntId) {
		super();
		this.beschrijving = beschrijving;
		this.medicamenten = medicamenten;
		this.dokter = dokterId;
		this.patiëntId = patiëntId;
	}
public int getPatiëntId() {
		return patiëntId;
	}

	public void setPatiëntId(int patiëntId) {
		this.patiëntId = patiëntId;
	}

	public int  getDokter() {
		return dokter;
	}

	public void setDokter(int dokter) {
		this.dokter = dokter;
	}

	public String getBeschrijving() {
		return beschrijving;
	}

	public void setBeschrijving(String beschrijving) {
		this.beschrijving = beschrijving;
	}

	public Medicamenten getMedicamenten() {
		return medicamenten;
	}

	public void setMedicamenten(Medicamenten medicamenten) {
		this.medicamenten = medicamenten;
	}

	public Patiënt getPatiënt() {
		return patiënt;
	}

	public void setPatiënt(Patiënt patiënt) {
		this.patiënt = patiënt;
	}
	
	
	
	
	

}
