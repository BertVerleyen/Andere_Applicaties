package gui;

import java.awt.Color;
import java.awt.Font;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;
import java.util.List;

import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.JTextField;
import javax.swing.table.DefaultTableModel;

import domein.Evenement;
import domein.EvenementController;




public class PlanningsDataGUI {
	
	
	private static EvenementController evtController = new EvenementController();
	
	
	public static void main(String[] args)
	{
		JFrame frame = new JFrame();
		final JTable table = new JTable();
		
		
		Object[] columns = {"Id", "Datum", "Beschrijving"};
		final DefaultTableModel model = new DefaultTableModel();
		model.setColumnIdentifiers(columns);
		table.setModel(model);
		
		table.setBackground(Color.cyan);
		table.setForeground(Color.red);
		Font font = new Font("",1,22);
		
		table.setFont(font);
		table.setRowHeight(30);
		
		
		JLabel newIdLbl = new JLabel("new Id");
		JLabel datumLbl = new JLabel("date new event");
		JLabel beschrijvingLbl = new JLabel("beschrijving");
		
		
		
		
		final JTextField textId = new JTextField();
		final JTextField textDatum = new JTextField();
		final JTextField textBeschrijving = new JTextField();
		
		final JButton btnAdd = new JButton("Add");
		final JButton btnDelete = new JButton("Delete");
		final JButton btnUpdate = new JButton("Update");
		
		
	    newIdLbl.setBounds(300,220,100,25);
		datumLbl.setBounds(300,250,100,25);
		beschrijvingLbl.setBounds(300,310,100,25);
		
		
		
		textId.setBounds(20,220,100,25);
		textDatum.setBounds(20,250,100,25);
		textBeschrijving.setBounds(20,310,100,25);
		
		btnAdd.setBounds(150,220,100,25);
		btnDelete.setBounds(150,250,100,25);
		btnUpdate.setBounds(150,310,100,25);
		
		JScrollPane pane = new JScrollPane(table);
		pane.setBounds(0,0,880,200);
		
		frame.setLayout(null);
		
		frame.add(pane);
		
		frame.add(newIdLbl);
		frame.add(datumLbl);
		frame.add(beschrijvingLbl);
		
		frame.add(textId);
		frame.add(textDatum);
		frame.add(textBeschrijving);
		
		frame.add(btnAdd);
		frame.add(btnDelete);
		frame.add(btnUpdate);
		
	    final String[] row = new String[3]; 
	    
	    final List<Evenement> evtn = evtController.toonEvenementen();
	    final Object[] databaseRow = new Object[3];
	    
	    if(evtn.size()>0){
	    for(int ind = 0;ind<evtn.size();ind++)
	    {
	    	databaseRow[0] = evtn.get(ind).getId();
	    	databaseRow[1] = evtn.get(ind).getDatum();
	    	databaseRow[2] = evtn.get(ind).getBeschrijving();
	    	
	    	
	    }
	    model.addRow(databaseRow);
	    
	    }
	    btnAdd.addActionListener(new ActionListener(){
       
			@Override
			public void actionPerformed(ActionEvent e) {
				
				Calendar cal = new GregorianCalendar();
				DateFormat df = new SimpleDateFormat("dd MM yyyy HH:mm:ss");
				
					
				
				if(e.getSource()==btnAdd)
				{
					row[0] = textId.getText();
				    row[1] = textDatum.getText();
				    row[2] = textBeschrijving.getText();
				
				
				    model.addRow(row);
				   
				  	
				  evtController.createEvenement(Integer.parseInt(row[0]),row[1],(row[2]));
				 
				   
				}
			}
			
			
			
		});
		
		btnDelete.addActionListener(new ActionListener(){

			@Override
			public void actionPerformed(ActionEvent e) {
				
				int i = table.getSelectedRow();
				if(i >= 0 && e.getSource()==btnDelete){
					model.removeRow(i);
					evtController.deleteEvenement(i+1);
					
				}
				else{
					System.out.println("Delete Error");
				}
				
				
					
				
				
			}
			
		});
		
		table.addMouseListener(new MouseAdapter() {
		
		  public void mouseClicked(MouseEvent ev)
		  {
			  int i = table.getSelectedRow();
			  textId.setText(model.getValueAt(i, 0).toString());
			  textDatum.setText(model.getValueAt(i, 1).toString());
			  textBeschrijving.setText(model.getValueAt(i, 2).toString());
		  }
		
		});
		
		btnUpdate.addActionListener(new ActionListener(){

			@Override
			public void actionPerformed(ActionEvent e) {
				
				int i = table.getSelectedRow();
				
				if(i >= 0 && e.getSource()==btnUpdate)
				{
				//model.setValueAt(textId, i, 0);
				//model.setValueAt(textDatum, i, 0);
				//model.setValueAt(textBeschrijving, i, 0);
					
					model.fireTableCellUpdated(i, 0);
				
				
					
	            evtController.updateEvenement(Integer.parseInt(textId.getText()), textDatum.getText(),textBeschrijving.getText());
				DefaultTableModel tabl = (DefaultTableModel) table.getModel();
				tabl.setRowCount(0);
				
				for(int ind = 0;ind<evtn.size();ind++)
			    {
			    	databaseRow[0] = evtn.get(ind).getId();
			    	databaseRow[1] = evtn.get(ind).getDatum();
			    	databaseRow[2] = evtn.get(ind).getBeschrijving();
			    	
			    	
			    }
			    model.addRow(databaseRow);
			    
				
				
				}
				else{
					System.out.println("Update Error");
				}
				
				
			
				
			}
			
		});
		
		
		
		
		frame.setSize(900,400);
		frame.setLocationRelativeTo(null);
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frame.setVisible(true);
		
		
		
		
	}

}
