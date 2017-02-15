000100 IDENTIFICATION DIVISION.
000200 PROGRAM-ID. PlanningsData.
       AUTHOR. BErt VErleyen
       
       ENVIRONMENT DIVISION.
       INPUT-OUTPUT SECTION.
       FILE-CONTROL.
                SELECT PlanningFile ASSIGN TO "planning.txt"
                ORGANIZATION IS LINE SEQUENTIAL
                ACCESS MODE IS DYNAMIC
                 RECORD KEY IS EventId
                ALTERNATE RECORD KEY IS EventName
               WITH DUPLICATES
                FILE STATUS IS PlanningStatus.
      

       DATA DIVISION.
       FILE SECTION.
   
       FD PlanningFile.
        01 PlanningRecord.
                02 EventId            PIC 9(3).
                02 FILLER             PIC X VALUE " ".
                02 EventName          PIC X(50).
                02 FILLER             PIC X VALUE " ".
                02 Datum              PIC 99/99/9999.
                02 FILLER             PIC X VALUE "  ".
                02 EventBeschrijving       PIC X(120).
                02 FILLER             PIC X VALUE "  ".


       WORKING-STORAGE SECTION.
        01 PlanningStatus           PIC X(2).
                88  RecordFound       VALUE "00".

        01 RequiredKey           PIC 9.
                88 EventIdKey      VALUE 1.
                88 EventNameKey     VALUE 2.
           
        01 PrnPlanningRecord.
                02 PrnEventId       PIC 9(5).
                02 PrnEventName     PIC BBBBX(40).
                02 PrnDatum         PIC BBBB99.
                02 PrnBeschrijving  PIC X(222).
   
       PROCEDURE DIVISION.
       Begin.
           OPEN OUTPUT PlanningFile
        
         DISPLAY "Chose key EventId = 1,  EventName = 2, ->"
                     WITH NO ADVANCING.
                ACCEPT RequiredKey
           
        
      *      DISPLAY "Ken ID toe aan event: "
      *      ACCEPT RequiredKey
            FillInEventdata.
            IF EventIdKey
             DISPLAY "Geef de ID voor event in: " WITH NO ADVANCING
                        ACCEPT EventId
                DISPLAY "Enter Planning event name (40 chars) -> " 
              WITH NO ADVANCING
               ACCEPT EventName         
             DISPLay "Enter Date(00/00/0000) :" 
               ACCEPT Datum 
               
             DISPLAY "Elaborate description :"  
             ACCEPT EventBeschrijving           
                 WRITE PlanningRecord
      *                KEY IS EventId
                   INVALID KEY  
                      DISPLAY "PLANNING STATUS :- ", PlanningStatus
                   NOT INVALID KEY display "should work" EventId
                 END-WRITE
             END-IF
               
                

           IF EventNameKey
            DISPLAY "Enter Planning event name (40 chars) -> " 
              WITH NO ADVANCING
               ACCEPT EventName
              
             ADD 1 TO EventId
               
             DISPLay "Enter Date(00/00/0000) :" 
               ACCEPT Datum 
               
             DISPLAY "Elaborate description :"  
             ACCEPT EventBeschrijving
                WRITE PlanningRecord
      *                  KEY IS EventName
                   INVALID KEY  
                      DISPLAY "Planning STATUS :- ", PlanningStatus
                   NOT INVALID KEY display "should work" EventName
                END-WRITE
                END-IF
                
                DISPLAY "Planning event name is " EventName
                Accept EventName

                IF RecordFound
                 MOVE EventId TO PrnEventId
                 MOVE EventName TO PrnEventName
                 MOVE Datum TO PrnDatum
                 MOVE EventBeschrijving TO PrnBeschrijving
                 DISPLAY  PrnPlanningRecord
                        
                END-IF.
                
                PERFORM FillInEventdata
                PERFORM UNTIL PlanningRecord = SPACES
                
                 PERFORM FillInEventdata
              END-PERFORM
              CLOSE PlanningFile.
              STOP RUN.
