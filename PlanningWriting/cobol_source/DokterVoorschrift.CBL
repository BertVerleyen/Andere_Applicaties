000100 IDENTIFICATION DIVISION.
000200 PROGRAM-ID. DokterVoorschrift.
       AUTHOR. Bert Verleyen.
       
       ENVIRONMENT DIVISION.
       INPUT-OUTPUT SECTION.
       FILE-CONTROL.
       
      
       SELECT logfile ASSIGN TO "logfile.txt"
       ORGANIZATION IS LINE SEQUENTIAL
       ACCESS MODE IS SEQUENTIAL.
       
       SELECT rapportbestand ASSIGN TO "DoktersVoorschriften.out"
       FILE STATUS is rapportStatus.
       
       
       DATA DIVISION.
       FILE SECTION.
        
       FD rapportbestand.
       01 rapportrecord.
          04 rapportlijn pic x(200).
          
       FD logfile.
       01   logrec.
          05   loglijn  pic  x(100).
          
       WORKING-STORAGE SECTION.
       01 EINDE_BESTAND pic 9 value 0.
         88 EOF VALUE 1.
       
       01 jbcd-string pic x(1000).
    
       01 rapportStatus pic x(2).
       
       01 VoorschriftRecord.
          03 VoorschriftId pic 9(3).
          03 medicamenten  pic x(60).
          03 dokterId      pic 9(3).
          03 patientId     pic 9(3).    
         
        EXEC SQL BEGIN DECLARE SECTION END-EXEC
      * SQLCODE is 0 for success, 100 for no data, -1 for failure        	
        01 SQLCODE PIC S9(3).         	
      * SQLSTATE is a 5 character communication code; 00xxx is success.        	
        01 SQLSTATE PIC X(5).
        01 JdbcString PIC X(255).
        EXEC SQL END DECLARE SECTION END-EXEC
         
         
       PROCEDURE DIVISION.
       PGM.
       
       
       OPEN OUTPUT logfile
       PERFORM LEES-CONNECTIESTRING
       PERFORM UNTIL EOF
       PERFORM VUL-GEGEVENS-VOORSCHRIFT-IN
       
       END-PERFORM
       .
        
       LEES-CONNECTIESTRING.       
       
       PERFORM WRITE-LOG
       
      * END-READ
       STRING "jdbc:mysql://localhost/DokterApotheekDb"
               DELIMITED BY SIZE
             
       
       INTO jbcd-string
       display  'jbcd-string ingelezen'
       move "connectiestring ingelezen" to loglijn
       PERFORM WRITE-LOG.
       
       
       
       
       VUL-GEGEVENS-VOORSCHRIFT-IN.
      
        MOVE 'geen voorschrift' to loglijn
        PERFORM WRITE-LOG
        
        DISPLAY 'id graag:'
        ACCEPT VoorschriftId
        
        DISPLAY "voor te schrijven medicamenten:"
        ACCEPT medicamenten
        
         DISPLAY 'dokter id:'
        ACCEPT dokterId
        
         DISPLAY 'patient id:'
        ACCEPT patientId
        
        WRITE VoorschriftRecord
        MOVE 'voorschrift correct weggeschreven' to loglijn
        PERFORM WRITE-LOG
       
       DISPLAY 'Voorschrift id ' VoorschriftId.
       DIsPLAY "Nog één ingeven (typ 1) of niet (typ 0)?"
       ACCEPT EINDE-BESTAND
     
        
        
        2000-genereerRapport.
        DISPLAY 'rapport wordt uitgevoerd'
        OPEN OUTPUT rapportbestand
        PERFORM DO-CONNECT
     
        
        EXEC SQL
        SELECT id,medicamenten, dokterId, patientId
        INTO :VoorschriftId, :medicamenten, :dokterId, :patientId
        FROM voorschrift
        WHERE id = :VoorschriftId
        END-EXEC
        DISPLAY "SQLCODE: " SQLCODE
        
        DISPLAY 'ID '
        DISPLAY VoorschriftId
        DISPLAY ' Voorgeshreven Medicamenten '
        DISPLAY medicamenten
        DISPLAY ' dokterId '
        DISPLAY dokterId
        DISPLAY ' patientId '
        DISPLAY patientId
        DISPLAY ' Function Current-date'
        DISPLAY FUNCTION CURRENT-DATE
        
        
        
        PERFORM DO-DISCONNECT
        
        ACCEPT EINDE_BESTAND
        
        STRING
        "VoorschriftId " DELIMITED BY SIZE 
        VoorschriftId DELIMITED BY SPACES 
        " Voorgeshreven Medicamenten " DELIMITED BY SIZE
        medicamenten DELIMITED BY SPACES 
        " dokterId " DELIMITED BY SIZE
        dokterId DELIMITED BY SPACES  
        " patientId " DELIMITED BY SIZE
        patientId DELIMITED BY SPACES
        ";" DELIMITED BY SIZE
        INTO rapportlijn
        END-STRING
          
      * Relevante info in rapport wegschrijven
      * Verdeellijn om de tekst te splitsen per 80 karakters, zonder dat er woorden gesplitst worden
      * CALL "VerdeelLijnUC5" USING, rapportrecord, ";", 0
      
      *tekst niet gesplitst:
        WRITE rapportrecord
        
       
     
       WRITE-LOG.
       write logrec 
       end-write.
       
  
       
       DO-CONNECT.
       EXEC SQL
       CONNECT
         TO :jbcd-string    
         DRIVER "com.mysql.jdbc.Driver"                 
       END-EXEC
       .
       
       DO-DISCONNECT.
       EXEC SQL
       DISCONNECT
       END-EXEC
       .
       
       
