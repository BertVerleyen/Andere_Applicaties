import javax.swing.JOptionPane;

import persistentie.ConsultatieEntity;
import persistentie.DokterEntity;
import persistentie.Pati�ntEntity;
import persistentie.VoorschriftEntity;
import domein.Consultatie;
import domein.Dokter;
import domein.Medicamenten;
import domein.Pati�nt;


public class DokterApotheekApp {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		
		DokterEntity ent = new DokterEntity();
		Pati�ntEntity patent = new Pati�ntEntity();
		ConsultatieEntity cons = new ConsultatieEntity();
		VoorschriftEntity v = new VoorschriftEntity();
		
		Dokter d1 = new Dokter(1,"Dr. Phil");
		Dokter d2 = new Dokter(2,"Dr. House");
		
		Pati�nt pat1 = new Pati�nt(1, "VErhafen", "Gert", "fiersenstraat 8 8520 Kuurne", "scheune sceetje", 10);
		
		
		
		/*ent.createDokter(1, "Dr. Phil" );
		ent.createDokter(2, "Dr House");*/
		
		/*patent.createPati�nt(1, "VErhafen", "Gert", "fiersenstraat 8 8520 Kuurne", "scheune sceetje", 10);
		patent.addRelation(d1.getId(),pat1.getId());
		patent.addRelation(d2.getId(), pat1.getId());*/
        
		System.out.println("check database");
		
		String besch = JOptionPane.showInputDialog("Geef voorschrift-beschrijving in: ");
    	
		String dokternaam = JOptionPane.showInputDialog("Voorschrijvende dokter met ID:");
		int dokId = Integer.parseInt(dokternaam);
    	
    	String m = JOptionPane.showInputDialog("Voor te schrijven medicament/zalf:");
    	//Medicamenten med = Medicamenten.valueOf(m);
    	Medicamenten med = Medicamenten.case_insensitive(m);
    	
    	String patnaam = JOptionPane.showInputDialog("Voorschrift bestemd voor pati�nt met ID: ");
    	int patId = Integer.parseInt(patnaam);
    	
    	
    	v.createVoorschrift(besch, med, dokId, patId);
    	
    	
    	JOptionPane.showMessageDialog(null,"Dit is het overzicht van de voorschriften:/n/n"+v.geefVoorschriften());
	}

}
