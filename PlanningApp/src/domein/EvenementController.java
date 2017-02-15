package domein;

import java.util.Calendar;
import java.util.Date;
import java.util.List;

import persistentie.EvenementEntity;

public class EvenementController {
	
	
	private Evenement evt;
	private EvenementCollectie evtn;
	
	
	public EvenementController()
	{
		evt = new Evenement(new EvenementEntity());
		evtn = new EvenementCollectie();
	}
	
	public List<Evenement> toonEvenementen()
	{
		return evtn.toonEvenementen();
	}
	
	
	public void createEvenement(int id,String evtdatum,String beschrijving)
	{
		
		evt.create(id, evtdatum, beschrijving);
	}
	
	public void deleteEvenement(int id)
	{
		
		evt.delete(id);
	}
	
	public void updateEvenement(int id, String datum, String beschrijving)
	{
		
		evt.update(id,datum, beschrijving);
	}
	

}
