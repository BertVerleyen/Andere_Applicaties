package domein;

public class Consultatie {
	
	private String datum;
	private String beginUur;
	private String eindUur;
	private int pati�ntId;
	private int dokterId;
	
	public Consultatie(String datum, String beginUur, String eindUur) {
		super();
		this.datum = datum;
		this.beginUur = beginUur;
		this.eindUur = eindUur;
	}
	
	public Consultatie(String datuur, int dokterId, int pati�ntId)
	{
		this.setDatum(datuur);
		this.setDokterId(dokterId);
		this.setPati�ntId(pati�ntId);
	}

	public int getPati�ntId() {
		return pati�ntId;
	}

	public void setPati�ntId(int pati�ntId) {
		this.pati�ntId = pati�ntId;
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
