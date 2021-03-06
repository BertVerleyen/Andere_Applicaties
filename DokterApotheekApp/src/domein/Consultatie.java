package domein;

public class Consultatie {
	
	private String datum;
	private String beginUur;
	private String eindUur;
	private int patiŽntId;
	private int dokterId;
	
	public Consultatie(String datum, String beginUur, String eindUur) {
		super();
		this.datum = datum;
		this.beginUur = beginUur;
		this.eindUur = eindUur;
	}
	
	public Consultatie(String datuur, int dokterId, int patiŽntId)
	{
		this.setDatum(datuur);
		this.setDokterId(dokterId);
		this.setPatiŽntId(patiŽntId);
	}

	public int getPatiŽntId() {
		return patiŽntId;
	}

	public void setPatiŽntId(int patiŽntId) {
		this.patiŽntId = patiŽntId;
	}

	public int getDokterId() {
		return dokterId;
	}

	public void setDokterId(int dokterId) {
		this.dokterId = dokterId;
	}

	public String getDatum() {
		return datum;
	}

	public void setDatum(String datum) {
		this.datum = datum;
	}

	public String getBeginUur() {
		return beginUur;
	}

	public void setBeginUur(String beginUur) {
		this.beginUur = beginUur;
	}

	public String getEindUur() {
		return eindUur;
	}

	public void setEindUur(String eindUur) {
		this.eindUur = eindUur;
	}
	
	
	
	

}
