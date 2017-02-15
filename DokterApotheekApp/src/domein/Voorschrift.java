package domein;

import java.util.List;

public class Voorschrift {
	
	private int pati�ntId;
	private String beschrijving;
	private Medicamenten medicamenten;
	private int dokter;
	
	private Pati�nt pati�nt;
	
	public Voorschrift(String beschrijving, Medicamenten medicamenten,int dokterId, int pati�ntId) {
		super();
		this.beschrijving = beschrijving;
		this.medicamenten = medicamenten;
		this.dokter = dokterId;
		this.pati�ntId = pati�ntId;
	}
public int getPati�ntId() {
		return pati�ntId;
	}

	public void setPati�ntId(int pati�ntId) {
		this.pati�ntId = pati�ntId;
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

	public Pati�nt getPati�nt() {
		return pati�nt;
	}

	public void setPati�nt(Pati�nt pati�nt) {
		this.pati�nt = pati�nt;
	}
	
	
	
	
	

}
