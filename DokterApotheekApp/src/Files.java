import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Scanner;

import javax.print.Doc;
import javax.print.DocFlavor;
import javax.print.DocPrintJob;
import javax.print.PrintException;
import javax.print.PrintService;
import javax.print.PrintServiceLookup;
import javax.print.ServiceUI;
import javax.print.SimpleDoc;
import javax.print.attribute.PrintRequestAttributeSet;
import javax.swing.JOptionPane;

import domein.Medicamenten;

public class Files {

    public static void main(String args[]){

        /**
         * 
         * schriijven nr voorschrift, later printen we het af.
         */
    	
    	String besch = JOptionPane.showInputDialog("Geef voorschrift-beschrijving in: ");
    	String dokternaam = JOptionPane.showInputDialog("Naam van dokter die voorschrijft:");
    	String m = JOptionPane.showInputDialog("Voor te schrijven medicament/zalf:");
    	//Medicamenten med = (Medicamenten) m ;
    	String patnaam = JOptionPane.showInputDialog("Voorschrift bestemd voor patiënt met ID: ");
    	
    	
    	/*
    	 * List<String> optionList = new ArrayList<String>();
optionList.add("Ham");
optionList.add("Eggs");
optionList.add("Bacon");
Object[] options = optionList.toArray();
Object value = JOptionPane.showInputDialog(null, 
                                           "Favorite Food", 
                                           "Food", 
                                            JOptionPane.QUESTION_MESSAGE, 
                                            null,
                                            options, 
                                            options[0]);

int index = optionList.indexOf(value);
    	 * 
    	 * 
    	 * */
    	//System.out.print("Enter Text: ");
       // Scanner scan = new Scanner(System.in);
        //String text = scan.nextLine();
        FileWriter fWriter = null;
        BufferedWriter writer = null;
        try {
          fWriter = new FileWriter("voorschriften.txt");
          writer = new BufferedWriter(fWriter);
          writer.write("BESCHRIJVING: ");
          writer.write(" ");
          writer.write(besch);
          writer.newLine();
          writer.write("DOKTER: ");
          writer.write(" ");
          writer.write(dokternaam);
          writer.newLine();
          writer.write("VOORGESCHREVEN MEDICAMENT OF ZALF: ");
          writer.write(" ");
          writer.write(m);
          writer.newLine();
          writer.write("PATIËNT MET ID: ");
          writer.write(" ");
          writer.write(patnaam);
          writer.newLine();
          writer.newLine();
          
          writer.close();
          //System.err.println("Your input of " + text.length() + " characters was saved.");
        } catch (Exception e) {
            System.out.println("Error!");
        }
    }
    
    private void readVoorschrift()
    {
    	
    	try(BufferedReader br = new BufferedReader(new FileReader("voorschriften.txt"))) {
    	    StringBuilder sb = new StringBuilder();
    	    String line = br.readLine();

    	    while (line != null) {
    	        sb.append(line);
    	        sb.append(System.lineSeparator());
    	        line = br.readLine();
    	    }
    	    String everything = sb.toString();
    	} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
    	
    	
    }
    
    private void printVoorchrift() throws FileNotFoundException
    {
    	
    	FileInputStream textStream;
    	
			textStream = new FileInputStream("voorschriften.txt");
			DocFlavor flavor = DocFlavor.INPUT_STREAM.AUTOSENSE;
    	Doc mydoc = new SimpleDoc(textStream, flavor, null);
    	PrintService[] services = PrintServiceLookup.lookupPrintServices(
    	                flavor, null);
    	   PrintService defaultService = PrintServiceLookup.lookupDefaultPrintService();
		

    	

    	   

    	   if(services.length == 0) {
    	       if(defaultService == null) {
    	             //no printer found

    	       } else {
    	            //print using default
    	            DocPrintJob job = defaultService.createPrintJob();
    	            try {
						job.print(mydoc, null);
					} catch (PrintException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}

    	       }

    	    } else {

    	       PrintRequestAttributeSet aset = null;
			//built in UI for printing you may not use this
    	       PrintService service = ServiceUI.printDialog(null, 200, 200, services, defaultService, flavor, aset);


    	        if (service != null)
    	        {
    	           DocPrintJob job = service.createPrintJob();
    	           try {
					job.print(mydoc, aset);
				} catch (PrintException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
    	        }

    	    }
    }

}
