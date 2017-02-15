
import java.sql.Time;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;
import java.util.TimeZone;

import javax.swing.JOptionPane;

import com.mindfusion.common.DateTime;

import domein.Evenement;
import domein.EvenementController;


public class PlanningApp {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		//Time datetime1 = new Time(22, 30, 0);
		Calendar cal = new GregorianCalendar();
		TimeZone timezone = cal.getTimeZone();
		//Calendar date1 = new Calendar("05/06/2017 10:30 PM");
		//SimpleDateFormat ft = new SimpleDateFormat("dd/MM/yyyy HH:mm ");
		//Calendar cal = Calendar.getInstance();
		cal.set(2017, 4, 6, 22, 30);
		cal.setTimeZone(TimeZone.getTimeZone("Europe/Brussels"));
		
		
		
		
		Evenement evt = new Evenement(1,"06/05/2017","blablsdgdglkdgjdfkl todo");
		
		//evt.showDatum();
		//System.out.printf("the id is %d , and eventdata : %s",evt.getId(),evt.getBeschrijving());
        
		JOptionPane.showMessageDialog(null, "the id is "+evt.getId()+ " , and eventdata : "+evt.getBeschrijving());
		
		//Date date;
		/*try {
			date = ft.parse("06/05/2017 22:30 AM");
			System.out.printf("%s",ft.format(date));
		} catch (ParseException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}*/
		String input2;
		String input;
		int inp;
		inp = Integer.parseInt(JOptionPane.showInputDialog("Geef de id van uw evenement in aub"));
		input = JOptionPane.showInputDialog("Geef de datum van uw evenement in aub");
		input2 =  JOptionPane.showInputDialog("Geef de beschrijving van het evenement");
		EvenementController controller = new EvenementController();
		
		//controller.createEvenement(cal, "eerste afspraak op evenementen kalender vb" );
		
		//cal.set(2017,2,8,19,00);
		
		//controller.createEvenement(cal, "tweede afspraak vb in database opgeslagen" );
		
		//SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy HH:mm");
		
			
			controller.createEvenement(inp,input, input2);
		
		
		
		
	}

}
