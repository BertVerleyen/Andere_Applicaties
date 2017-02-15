package domein;

import java.util.ArrayList;
import java.util.List;

import persistentie.EvenementEntity;

public class EvenementCollectie {
	
	private List<Evenement> evenementen;
	private EvenementEntity evtEntity;

	public EvenementCollectie() {
		super();
		evenementen = new ArrayList<Evenement>();
	    evtEntity = new EvenementEntity();
	}

	public List<Evenement> toonEvenementen()
	{
		return evtEntity.geefAllEvenementen();
		
	}
	
	
	public List getEvenementen() {
		return evenementen;
	}

	public void setEvenementen(List evenementen) {
		evenementen = evenementen;
	}
	
	public List<Evenement> getEvenementenByDay(int day)
	{
		
		return null;
	}
	
	public List<Evenement> getEvenementenByMonth(int month)
	{
		
		
		
		return evenementen;
	
	}

}
